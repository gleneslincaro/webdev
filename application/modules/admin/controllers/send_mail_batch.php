
 <?php
require($_SERVER['DOCUMENT_ROOT']."/system/libraries/Email.php");
class Common extends MX_Controller {
    
    function __construct() {
       $this->load->library('email');       

    }
       
    /**
     * author: [IVS] Ho Quoc Huy
     * name : sendMail
     * todo : send mail to object
     * @param string $from
     * @param string $to
     * @param array $maildata
     * @param array  $result_variable
     * @param array  $dataTemplate
     */     
    function sendMail($dataTemplate=null,$maildata =null,$result_variable=null, $to = null, $senderName = null,$from = null)

    {  $from = $maildata['from_mail'];    
        $body = $maildata['content'];
        $title = $maildata['title'];
            foreach ($result_variable as $value) 
            {     
               if(strpos($body, '/--'.$value['name'].'--/',0)!='')
               {                  
                   $body = str_replace('/--'.$value['name'].'--/', ($value['mapping_name']=='password')? base64_decode( $dataTemplate[$value['mapping_name']]): $dataTemplate[$value['mapping_name']], $body);  
               }
                if(strpos($title, '/--'.$value['name'].'--/',0)!='')
               {                  
                   $title = str_replace('/--'.$value['name'].'--/', ($value['mapping_name']=='password')? base64_decode( $dataTemplate[$value['mapping_name']]): $dataTemplate[$value['mapping_name']], $title);  
               }  
            }    
         $this->email->clear();
         $this->email->from($from,$senderName == null ? 'Vj_Solution' : $senderName);
         $this->email->to($to);
         $this->email->subject($title);  
         $this->email->message(str_replace(array("\r\n", "\n", "\r"), "<br/>",$body));          
         $this->email->send(); 
    }   
}

$username = "openpne";
$password = "123456";
$hostname = "10.32.5.176"; 
$port = "3306";

//connection to the database
$dbhandle = mysql_connect($hostname.":".$port, $username, $password)
 or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

//select a database to work with
$selected = mysql_select_db("vjsolutions",$dbhandle)
  or die("Could not select vjsolutions");

//execute the SQL query and return records
mysql_query ("set character_set_results='utf8'");
$result = mysql_query("SELECT * FROM mail_queue WHERE display_flag = '1' AND DATE_FORMAT(send_date,'%Y-%m-%d %H:%i') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d %H:%i')");
//$result = mysql_query("SELECT * FROM mail_queue WHERE display_flag = '1' AND id=38");
$emai = new Common();
//fetch tha data from the database
while ($row = mysql_fetch_array($result)) {
   
         $arrEmail = explode(",", $row['to_mail']);
         foreach ($arrEmail as $key => $emailaddress) {
                        if($row['member_type']==0){
                        $result_variable = mysql_query("SELECT * FROM mst_variable_list WHERE display_flag = '1' AND group_type ='usCommon'");
                        $dataArrayUS =array();
                        while ($tempRowUser = mysql_fetch_assoc($result_variable)){
                            array_push($dataArrayUS, $tempRowUser);
                        }
                         $datasql = mysql_query("SELECT email_address,users.password,users.name,users.`unique_id`,
                            mst_cities.`name` AS city_name,
                            GROUP_CONCAT(mst_job_types.name,'') AS job_type
                            FROM users
                            LEFT JOIN user_recruits ON users.id = user_recruits.user_id AND user_recruits.`display_flag` = '1'
                            LEFT JOIN mst_cities ON user_recruits.city_id = mst_cities.id AND mst_cities.`display_flag` = '1'
                            LEFT JOIN job_type_users ON user_recruits.user_id = job_type_users.user_id 
                            LEFT JOIN mst_job_types ON job_type_users.job_type_id = mst_job_types.id AND mst_job_types.`display_flag` = '1'
                            WHERE users.display_flag = 1 AND users.email_address = '".$emailaddress."'
                            GROUP BY user_recruits.id");
                        $data = mysql_fetch_assoc($datasql);
                         $emai->sendMail($data,$row,$dataArrayUS, $emailaddress,'','');
                        }else if ( $row['member_type'] == 1){
                        $result_variable = mysql_query("SELECT * FROM mst_variable_list WHERE display_flag = '1' AND group_type ='owCommon'");
                        $dataArrayOw =array();
                        while ($tempRowOwner = mysql_fetch_assoc($result_variable)){
                            array_push($dataArrayOw, $tempRowOwner);
                        }
                         $datasql = mysql_query("SELECT email_address,owners.password,storename,pic,address,tel,bank_name,branch_name,
                            account_type,account_no,account_name,mst_cities.`name` AS city_name,nearest_station,
                            GROUP_CONCAT(mst_job_types.name,'') AS job_type,joyspe_happy_money,0.4*joyspe_happy_money AS happy_money
                            FROM owners
                            LEFT JOIN owner_recruits ON owners.id = owner_recruits.owner_id AND owner_recruits.`display_flag` = '1'
                            LEFT JOIN mst_cities ON owner_recruits.city_id = mst_cities.id AND mst_cities.`display_flag` = '1'
                            LEFT JOIN job_type_owners ON owner_recruits.id = job_type_owners.owner_recruit_id 
                            LEFT JOIN mst_job_types ON job_type_owners.job_type_id = mst_job_types.id AND mst_job_types.`display_flag` = '1'
                            LEFT JOIN mst_happy_moneys ON mst_happy_moneys.id = owner_recruits.happy_money_id AND mst_happy_moneys.`display_flag` = '1'
                            WHERE owners.display_flag = 1 AND owners.email_address = '".$emailaddress."'
                            GROUP BY owner_recruits.id");
                         $data = mysql_fetch_assoc($datasql);
                         $emai->sendMail($data,$row,$dataArrayOw, $emailaddress,'','');
                          
                        } 
             
             
         }
	 
}        
//close the connection
mysql_close($dbhandle);
 
 ?>       

