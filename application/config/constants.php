<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/*
|--------------------------------------------------------------------------
| お祝い金対応関連
|--------------------------------------------------------------------------
|
|　表示文字列、文字サイズ等
|
*/

define('OIWAI_PAY_TEXT_PRFEFIX', '応募後､採用されたら');
define('OIWAI_PAY_TEXT_MIDDLE', 'お祝い金');
define('OIWAI_PAY_TEXT_SUFFIX', '贈呈します!!');
define('OIWAI_PAY_MONEY_FONTSIZE_LARGE', 20);	//お祝い金の数字表示用のフォントサイズ(6桁以下の数字)
define('OIWAI_PAY_MONEY_FONTSIZE_SMALL', 16);	//お祝い金の数字表示用のフォントサイズ(7桁以上の数字)
define('OIWAI_PAY_YEN_FONTSIZE_LARGE', 14);
define('OIWAI_PAY_YEN_FONTSIZE_SMALL', 13);

/*
|
|--------------------------------------------------------------------------
| オープンデート
|--------------------------------------------------------------------------
|
|下記のオープンデートに達するかOPEN_FLAGが1になった場合、オンナーのページが表示される
|
|
*/
define('OPEN_DATE','2014/04/15'); //オープンデート設定
define('OPEN_FLAG',1);            //オープンフラグ: 0か1に設定してください

/*
|
| クレジットカード決済関連
|
*/
define('CREDIT_CARD_CLIENTIP', '07264');
define('CREDIT_CARD_COMPANY_URL_NORMAL','https://secure.telecomcredit.co.jp/inetcredit/secure/order.pl');
define('CREDIT_CARD_COMPANY_URL_SPEED','https://secure.telecomcredit.co.jp/inetcredit/secure/one-click-order.pl');
//define('CREDIT_CARD_COMPANY_URL_SPEED', 'https://secure.telecomcredit.co.jp/inetcredit/secure/one-click-order.pl');

/*
|
| 運営会社リンク
|
*/
define('OPERATING_COMPANY','http://uni-inc.biz');

/*
 |
 | クレジット決済の時、内部のファイルを呼べるIPアドレスリスト
 |
 */
 define('ALLOWED_SERVERS',
 serialize(array(
	'203.191.250.65',
	'203.191.250.66',
	'203.191.250.67',
	'203.191.250.68',
	'203.191.250.69',
	'203.191.250.70',
	'203.191.250.71',
	'203.191.250.72',
	'203.191.250.73',
	'203.191.250.74',
	'203.191.250.75',
	'203.191.250.75',
	'203.191.250.76',
	'203.191.250.77',
	'203.191.250.78',
	'203.191.250.79',
	'203.191.250.80',
	'203.191.250.81',
	'203.191.250.82',
	'203.191.250.83',
	'203.191.250.84',
	'203.191.250.85',
	'203.191.250.86',
	'203.191.250.87',
	'203.191.250.88',
	'203.191.250.89',
	'203.191.250.90',
	'203.191.250.91',
	'203.191.250.92',
	'203.191.250.93',
	'203.191.250.94',
	'117.102.215.161',
	'117.102.215.162',
	'117.102.215.163',
	'117.102.215.164',
	'117.102.215.165',
	'117.102.215.166',
	'117.102.215.167',
	'117.102.215.168',
	'117.102.215.169',
	'117.102.215.170',
	'117.102.215.171',
	'117.102.215.172',
	'117.102.215.173',
	'117.102.215.174',
	'203.191.240.81',
	'203.191.240.82',
	'203.191.240.83',
	'203.191.240.84',
	'203.191.240.85',
	'203.191.240.86',
	'203.191.240.87',
	'203.191.240.88',
	'203.191.240.89',
	'203.191.240.90',
	'203.191.240.91',
	'203.191.240.92',
	'203.191.240.93',
	'203.191.240.94',
	'123.50.201.57',
	'123.50.202.58',
	'123.50.203.59',
	'123.50.204.60',
	'123.50.205.61',
	'123.50.206.62')
));

/*
* Define centimet constant
*/
define('CONST_CENTIMET','cm');

/*
* Define server ip constant
*/
define('SERVER_ADDRESS', '104.41.171.104'); //joyspe.comのIP

/*
* Define 2 constant sites for remote login
*/
define('REMOTE_LOGIN_SITE_1', 'http://m-mb.jp');
define('REMOTE_LOGIN_SITE_2', 'test2.com');
define('GET_MACHERIE_ID_API', 'http://macherie.tv/pro_manage/joyspe_getid.php?encrytid=');
define('MOBA_PREFIX', 'FOMA');

/*
* Default title, description, keywords
*/
define('DEFAULT_TITLE', '風俗求人・高収入アルバイトがみつかる -ジョイスペ-');
define('DEFAULT_KEYWORDS', '風俗,求人,高収入アルバイト');
define('DEFAULT_DESCRIPTION', '風俗求人の高収入アルバイトと言えばジョイスペで決まり！日本全国から探すことのできる大人のハローワークだから女性に大人気☆高収入をゲットできる求人情報はこちらよりご覧ください。
');

/*
* 業種Prefix(求人一覧に表示される業種のPREFIX)
*/
define('INDUSYTRY_PREFIX','業種/');

/*
* ユーザから店舗のオナーへのメール内容
*/
define('MAIL_TITLE','ジョイスペからの応募');
define('MAIL_HEAD_SUFFIX',' (消さないで本文を書いてください)');
define('MAIL_HEAD_SUFFIX_SJIS','%20%28%8f%c1%82%b3%82%c8%82%a2%82%c5%96%7b%95%b6%82%f0%8f%91%82%a2%82%c4%82%ad%82%be%82%b3%82%a2%29');
define('MAIL_HEAD_SUFFIX_NO_LOGIN', "本文");
define('MAIL_HEAD_SUFFIX_NO_LOGIN_SJIS', "%96%7b%95%b6");

/*
* ユーザから店舗のオーナーへの初回問い合わせ時のボーナスポイント数
*/
define('USER_FIRST_MSG_BONUS', 100);

define('BONUS_REASON_OPEN_SCOUT_MAIL', 'スカウトメール開封');
define('BONUS_REASON_FIRST_MSG', 'はじめての問い合わせ');
define('BONUS_REASON_LOGIN', '累計ログインポイント設定');
define('BONUS_REASON_PAGE_ACCESS', '店舗ページアクセス');
define('BONUS_REASON_INTERVIEW', '面接交通費');
define('BONUS_REASON_TRIAL_WORK', '体験入店お祝い金');
define('BONUS_REASON_STEP_UP_CAMPAIGN', 'ステップアップキャンペーンボーナス');
define('MISSION_LOGIN_DAYS', 10);
define('MISSION_ACCESS_PAGE_DAYS', 10);
define('SCOUT_MAIL_LIMIT_HOURS', 24);
define('LOGIN_FAILS_LIMIT', 3);
define('CAPTCHA_DISPLAY_EXPIRATION', 10);

define('STORE_LIMIT', 10);

/*
* Interviewer total number of senior profile to be added
*/
define('TOTAL_SENIOR_PROFILE', 3);

/* End of file constants.php */
/*
* FAQ owner pagination
*/
define('TOTAL_DISPLAY_FAQ', 3);

/*
* Link to automatically login will expire after the following hours
*/
define('LOGIN_EXPIRE_HOURS', 48);

/*
* Shuffle search store after specific time
*/
define('STORE_TIME_SHUFFLE',10);

/*Messages that will be display in the users message list for PC*/
define('LIMIT_MESSAGE_LIST_PC',10);

/*
* Experience page limit
*/
define('LIMIT_EXPERIENCE_LIST',10);

/* Location: ./application/config/constants.php */

switch (ENVIRONMENT)
{
	case 'development':
        $aruaru_url = 'aruaru.joyspe.local';
        $onayami_url = 'onayami.joyspe.local';
        $aruaru_protocol = 'http://';
        $onayami_protocol = 'http://';
        break;

	case 'testing':
        $aruaru_url = 'aruaru.fdc-inc.com';
        $onayami_url = 'onayami.fdc-inc.com';
        $aruaru_protocol = 'http://';
        $onayami_protocol = 'http://';
        break;
	
    case 'production':
        $aruaru_url = 'aruaru.joyspe.com';
        $onayami_url = 'onayami.joyspe.com';
        $aruaru_protocol = 'https://';
        $onayami_protocol = 'https://';
        break;
        
	default:
        $aruaru_url = 'aruaru.fdc-inc.com';
        $onayami_url = 'onayami.fdc-inc.com';
        $aruaru_protocol = 'http://';
        $onayami_protocol = 'http://';
        break;
}
define('ARUARU_URL', $aruaru_url);
define('ONAYAMI_URL', $onayami_url);
define('ARUARU_PROTOCOL', $aruaru_protocol);
define('ONAYAMI_PROTOCOL', $onayami_protocol);
define('SECRET', "ebA7jg2uh06rW71Vn8VNk1Z8o2t5Sk6z");
