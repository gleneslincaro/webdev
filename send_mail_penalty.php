<?php

require('/var/www/arche_html/joyspe/web/class.phpmailer.php');
$hours = 168; // 7*24

class Common {

    protected $_mailer;

    function __construct() {
        $this->_mailer = new PHPMailer();
        $this->_mailer->IsSMTP();
        $this->_mailer->Host = 'mail.joyspe.com';
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
    function getUserSelect($userIds, $ownerId) {
        $dataArrayUserSelect = array();
        $getUserSelect = mysql_query("SELECT
                                          users.id AS user_id,
                                          users.`unique_id`,
                                          mst_cities.name AS city_name,
                                          owner_recruits.`cond_happy_money`,
                                          mst_happy_moneys.`user_happy_money`,
                                          mst_happy_moneys.`joyspe_happy_money`,
                                          `user_payments`.`request_money_date`
                                        FROM
                                          `users`
                                          JOIN `user_recruits`
                                            ON `users`.`id` = `user_recruits`.`user_id`
                                          LEFT JOIN `mst_cities`
                                            ON `user_recruits`.`city_id` = `mst_cities`.`id`
                                          JOIN `user_payments`
                                            ON `users`.`id` = `user_payments`.`user_id`
                                          JOIN `owner_recruits`
                                            ON `user_payments`.`owner_recruit_id` = `owner_recruits`.`id`
                                          JOIN `mst_happy_moneys`
                                            ON `owner_recruits`.`happy_money_id` = `mst_happy_moneys`.`id`
                                          JOIN `owners`
					    ON `owners`.id = `owner_recruits`.`owner_id`
                                        WHERE `owner_recruits`.`owner_id` = $ownerId
					    AND `user_payments`.`user_payment_status` = 5
					    AND `user_recruits`.`display_flag` = 1
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
    function sendMailBatch($dataTemplate = null, $maildata = null, $result_variable = null, $from = null, $to = null, $senderName = null, $param, $ownerId = null) {

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

        $dataRebeat = $this->getUserSelect($param, $ownerId);

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
        $this->_mailer->FromName = 'joyspe';
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
$hostname = "172.16.15.48";
$username = "joyspe";
$password = "joyspe123";
$port = "3306";
$databasename = "vjsolutions";

//connection to the database
$dbhandle = mysql_connect($hostname . ":" . $port, $username, $password) or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

//select a database to work with
$selected = mysql_select_db($databasename, $dbhandle) or die("Could not select vjsolutions");

//execute the SQL query and return records
mysql_query("set character_set_results='utf8'");

$condition = mysql_query("SELECT owners.email_address, owners.id AS owId, owner_recruits.id
                        FROM user_payments
                        INNER JOIN owner_recruits
                        ON user_payments.owner_recruit_id = owner_recruits.id
                        INNER JOIN owners
                        ON owner_recruits.owner_id = owners.id
                        WHERE user_payments.display_flag = 1
                        AND user_payments.user_payment_status = 5 AND TIME_TO_SEC(TIMEDIFF(NOW(),user_payments.request_money_date))/3600 > $hours
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
                                ow.`storename`
                            FROM
                                `owners` ow
                                INNER JOIN `owner_recruits` owr
                                  ON ow.`id` = owr.`owner_id`
                            WHERE ow.`id` = " . $row['owId'] .
            " GROUP BY ow.id");
//-----------------------------------------
    $condition1 = mysql_query("SELECT
                      user_payments.`user_id`
                    FROM
                      user_payments
                      INNER JOIN owner_recruits
                        ON user_payments.owner_recruit_id = owner_recruits.id
                      INNER JOIN owners
                        ON owner_recruits.owner_id = owners.id
                    WHERE user_payments.display_flag = 1
                        AND user_payments.user_payment_status = 5 AND TIME_TO_SEC(TIMEDIFF(NOW(),user_payments.request_money_date))/3600 > $hours
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
    $email->sendMailBatch($data, $templ, $dataArrayUS, $templ['mail_from'], $row['email_address'], '', $str, $row['owId']);
    $temp = $temp . $row['id'] . ",";
}
$temp = substr($temp, 0, strlen($temp) - 1);
$upstatus = "UPDATE owners,owner_recruits SET owners.owner_status = 3, owners.penalty_date = CURRENT_TIMESTAMP
                 WHERE owner_recruits.id IN ($temp) AND owner_recruits.owner_id = owners.id";
mysql_query($upstatus);
//close the connection
mysql_close($dbhandle);
?>
