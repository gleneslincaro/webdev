<?php

require('/var/www/html/vjs_joyspe/class.phpmailer.php');
$day = 7;

class Common {

    protected $_mailer;

    function __construct() {
        $this->_mailer = new PHPMailer();
        $this->_mailer->IsSMTP();
        $this->_mailer->Host = 'mail.vitenet.sakura.ne.jp';
        $this->_mailer->CharSet = 'UTF-8';
    }

    //--------------------------------------
    /**
     * @author: [IVS] Nguyen Hong Duc
     * @name : getJobUser
     * @todo : get Job User
     * @param $userId
     * @return data
     */
    function getJobUser($userId) {
        $dataArrayJobUser = array();
        $getJobUser = mysql_query("SELECT mst_job_types.name AS jobtype_user
                                    FROM
                                      users
                                      INNER JOIN job_type_users
                                        ON users.id = job_type_users.user_id
                                      INNER JOIN mst_job_types
                                        ON job_type_users.job_type_id = mst_job_types.id
                                    WHERE mst_job_types.display_flag = 1
                                      AND users.display_flag = 1
                                      AND users.id = $userId");
        while ($arrJobUser = mysql_fetch_assoc($getJobUser)) {
            array_push($dataArrayJobUser, $arrJobUser);
        }
        return $dataArrayJobUser;
    }

    /**
     * author: [IVS] Nguyen Bao Trieu
     * name : getUserSelect
     * todo : get User Select
     * @param array $userIds
     * @return data
     */
    function getUserSelect($userIds) {
        $dataArrayUserSelect = array();
        $getUserSelect = mysql_query("SELECT users.id AS user_id,unique_id,mst_cities.name AS city_name
                                        FROM users
                                          INNER JOIN `user_recruits`
                                            ON users.`id` = `user_recruits`.`user_id`
                                          LEFT JOIN mst_cities 
                                            ON `user_recruits`.`city_id` = mst_cities.id
                                        WHERE user_recruits.display_flag = 1
                                          AND users.`id` IN ($userIds)");

        while ($arrUserSelect = mysql_fetch_assoc($getUserSelect)) {
            array_push($dataArrayUserSelect, $arrUserSelect);
        }
        return $dataArrayUserSelect;
    }

//--------------------------------------

    /**
     * author: [IVS] Nguyen Hong Duc
     * name : sendMail
     * todo : send mail to object
     * @param string $from
     * @param string $to
     * @param array $maildata
     * @param array  $result_variable
     * @param array  $dataTemplate
     */
    function sendMailBatch($dataTemplate = null, $maildata = null, $result_variable = null, $from = null, $to = null, $senderName = null, $param) {

        $from = $from;
        $body = $maildata['content'];
        $title = $maildata['title'];

        foreach ($result_variable as $key => $value) {
            if (!empty($dataTemplate[$value['mapping_name']])) {

                $title = str_replace('/--' . $value['name'] . '--/', ($value['mapping_name'] == 'password') ? base64_decode($dataTemplate[$value['mapping_name']]) : $dataTemplate[$value['mapping_name']], $title);
                $body = str_replace('/--' . $value['name'] . '--/', ($value['mapping_name'] == 'password') ? base64_decode($dataTemplate[$value['mapping_name']]) : $dataTemplate[$value['mapping_name']], $body);
            }
        }

        //------- Replace many users -----------

        $bodyArr = mb_split('//////////////////////////////', $body);
        $content_template = $bodyArr[1];
        $content_replace = '';

        $dataRebeat = $this->getUserSelect($param);

        $addContent = '';

        foreach ($dataRebeat as $key => $data) {
            // string job type user
            $jobUser = $this->getJobUser($data['user_id']);
            $strJob = '';
            foreach ($jobUser as $userJob) {
                $strJob .= ($strJob != '' ? '、' : '') . $userJob['jobtype_user'];
            }
            $data['jobtype_user'] = $strJob;
            $dataRe[] = $data;
        }

        foreach ($dataRe as $key => $data) {

            $content_replace = $content_template;

            foreach ($result_variable as $key => $value) {

                if (strpos($content_template, '/--' . $value['name'] . '--/')) {
                    $content_replace = str_replace('/--' . $value['name'] . '--/', $data[$value['mapping_name']], $content_replace);
                }
            }
            $addContent .= $content_replace;
        }

        $body = str_replace($content_template, $addContent, $body);

        $this->_mailer->ClearAddresses();
        $this->_mailer->Username = $from;
        $this->_mailer->FromName = 'VJ_Solution';
        $this->_mailer->From = $from;
        $this->_mailer->AddAddress($to);
        $this->_mailer->Subject = $title;
        $this->_mailer->Body = $body;
        if (!$this->_mailer->Send()) {
            echo "Mailer Error: " . $this->_mailer->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

}

$username = "openpne";
$password = "123456";
$hostname = "10.32.5.176";
$port = "3306";

//connection to the database
$dbhandle = mysql_connect($hostname . ":" . $port, $username, $password) or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

//select a database to work with
$selected = mysql_select_db("vjsolutions", $dbhandle) or die("Could not select vjsolutions");

//execute the SQL query and return records
mysql_query("set character_set_results='utf8'");

$condition = mysql_query("SELECT owners.email_address, owners.id AS owId, owner_recruits.id
                        FROM user_payments
                        INNER JOIN owner_recruits
                        ON user_payments.owner_recruit_id = owner_recruits.id
                        INNER JOIN owners
                        ON owner_recruits.owner_id = owners.id
                        WHERE user_payments.display_flag = 1
                        AND user_payments.user_payment_status = 0 AND DATEDIFF(NOW(),user_payments.apply_date) > $day
                        AND owners.owner_status != 3
                        GROUP BY `owners`.`id`");
$result_variable = mysql_query("SELECT * FROM mst_variable_list WHERE display_flag = '1' AND group_type ='ow14'");
$templsql = mysql_query("SELECT * FROM `mst_templates` WHERE `mst_templates`.`template_type` = 'ow14'");
$templ = mysql_fetch_assoc($templsql);
$temp = '';
$str = '';

$email = new Common();
while ($row = mysql_fetch_array($condition)) {
    $dataArrayUS = array();
    while ($tempRowUser = mysql_fetch_assoc($result_variable)) {
        array_push($dataArrayUS, $tempRowUser);
    }
    $datasql = mysql_query("SELECT
                                ow.`storename`,
                                mhm.`user_happy_money`,
                                mhm.`joyspe_happy_money`,
                                owr.`cond_happy_money`
                            FROM
                                `owners` ow
                                INNER JOIN `owner_recruits` owr
                                  ON ow.`id` = owr.`owner_id`
                                INNER JOIN `mst_happy_moneys` mhm
                                  ON owr.`happy_money_id` = mhm.`id`
                            WHERE ow.`id` = " . $row['owId'] .
            " GROUP BY ow.id");
//-----------------------------------------
    $condition1 = mysql_query("SELECT user_payments.`user_id`
                        FROM user_payments
                        INNER JOIN owner_recruits
                        ON user_payments.owner_recruit_id = owner_recruits.id
                        INNER JOIN owners
                        ON owner_recruits.owner_id = owners.id
                        WHERE user_payments.display_flag = 1
                        AND user_payments.user_payment_status = 0 AND DATEDIFF(NOW(),user_payments.apply_date) > $day
                        AND owners.id = " . $row['owId']);

    $dataArrayUser = array();
    while ($rowUser = mysql_fetch_assoc($condition1)) {
        array_push($dataArrayUser, $rowUser);
    }

    foreach ($dataArrayUser as $data) {
        foreach ($data as $value) {
            $str .= $value . ',';
        }
    }
    $str = substr($str, 0, -1);
//-----------------------------------------
    $data = mysql_fetch_assoc($datasql);
    $email->sendMailBatch($data, $templ, $dataArrayUS, '', $row['email_address'], '', $str);
    $temp = $temp . $row['id'] . ",";
}
$temp = substr($temp, 0, strlen($temp) - 1);
$upstatus = "UPDATE owners,owner_recruits SET owners.owner_status = 3
                 WHERE owner_recruits.id IN ($temp) AND owner_recruits.owner_id = owners.id";
mysql_query($upstatus);
//close the connection
mysql_close($dbhandle);
?>
