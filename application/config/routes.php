<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "user/joyspe_user";

// Temporary pages -START
$route['user/jobs/hokkaido/yamagata/tsuruoka/(:any)'] = 'user/misc/tsuruoka/$1';
// Temporary pages -END
$route['404_override'] = 'user/my404';
$route['user/jobs/(:any)'] = 'user/jobs/index/$1';
$route['user/jobs/refin'] = 'user/jobs/refin';

$route['jobtype_(:any)'] = 'user/jobtype_treatment/jobtype/$1';
$route['treatment_(:any)'] = 'user/jobtype_treatment/treatment/$1';

//$route['user/jobs2/(:any)'] = 'user/jobs2/index/$1';
//$route['user/jobs2/refin'] = 'user/jobs2/refin';

$route['user/faq/(:any)'] = 'user/faq/index/$1';
$route['user/faq/faq_ajax'] = 'user/faq/faq_ajax/';
$route['user'] = 'user/joyspe_user/index';
$route['user/jobs/ajax_cityname_list'] = 'user/jobs/ajax_cityname_list';
$route['user/jobs/ajax_area_list'] = 'user/jobs/ajax_area_list';
$route['user/contact'] = 'user/qa/qa_page';
$route['user/inquiry/(:any)'] = 'user/inquiry/index/$1';
$route['user/inquiry_user/(:any)'] = 'user/inquiry_user/index/$1';
$route['user/inquiry/complete'] = 'user/inquiry/complete';
$route['user/inquiry_user/complete'] = 'user/inquiry_user/complete';
$route['user/contact/complete'] = 'user/qa/qa_complete';
$route['user/settings/(:any)'] = 'user/profile_change/load_profile_change/$1';
$route['user/settings'] = 'user/profile_change/load_profile_change';
$route['user/info_list'] = 'user/news';
$route['user/info_detail/(:any)'] = 'user/news/news_details/$1';
$route['user/scout_list'] = 'user/scout/scout_list';
$route['user/message_list'] = 'user/user_messege/message_list/0';
$route['user/message_list/(:any)'] = 'user/user_messege/message_list/$1';
$route['user/message_list_garbage/(:any)'] = 'user/user_messege/message_list_garbage/$1';
$route['user/message_detail/(:any)'] = 'user/user_messege/messege_reception_in/$1/$2/$3';
$route['user/delete_message/(:any)'] = 'user/messege_details/messege_delete/$1/$2';
$route['user/return_message/(:any)'] = 'user/user_messege/messege_return/$1';
$route['user/tos'] = 'user/footer/agreement';
$route['user/privacy'] = 'user/footer/privacy';
$route['user/signup'] = 'user/registration';
$route['user/signup/makia'] = 'user/registration/makia';
$route['user/signup_complete'] = 'user/registration/recommended_profile_reg';
$route['user/onayami_signup_complete'] = 'user/registration/onayami_signup_complete';
$route['user/features/(:any)'] = 'user/features/index/$1';

$route['user/maintenance/update_city/(:any)'] = 'user/maintenance/update_city/$1';
$route['user/maintenance/update_town/(:any)'] = 'user/maintenance/update_town/$1';
$route['user/maintenance/(:any)'] = 'user/maintenance/index/$1';

$route['user/updatejob/update_town/(:any)'] = 'user/updatejob/update_town/$1';
$route['user/updatejob/(:any)'] = 'user/updatejob/index/$1';

$route['campaign/(:any)'] = 'user/misc/campaign/$1';

//$route['user/consultation/posting/(:any)'] = 'user/consultation/posting/$1';
//$route['user/consultation/posting'] = 'user/consultation/posting';
//$route['user/consultation/answer/(:any)'] = 'user/consultation/answer/$1';
//$route['user/consultation/qalist/(:any)'] = 'user/consultation/qalist/$1';
//$route['user/consultation/(:any)'] = 'user/consultation/index/$1';

//landing page
$route['user/lp01'] = 'user/landing_page/lp01';
$route['user/lp02'] = 'user/landing_page/lp02';
$route['user/lpstep'] = 'user/landing_page/lpstep';
$route['user/lp_hokkaido'] = 'user/landing_page/lp_hokkaido';
$route['user/lp_kanto'] = 'user/landing_page/lp_kanto';
$route['user/lp_kansai'] = 'user/landing_page/lp_kansai';
$route['user/lp_tokai'] = 'user/landing_page/lp_tokai';

$route['sitemap_index\.xml'] = "user/sitemap/sitemap_index";
$route['sitemap_01\.xml'] = "user/sitemap/sitemap_01";
$route['sitemap_jobtype_treatment\.xml'] = "user/sitemap/sitemap_jobtype_treatment";
$route['sitemap_area\.xml'] = "user/sitemap/sitemap_area";
$route['sitemap_shop\.xml'] = "user/sitemap/sitemap_shop";
$route['points_api/getAllTotalPoints'] = 'user/points_API/getAllSiteTotalPoints';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
