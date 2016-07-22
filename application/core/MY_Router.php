<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Router.php";

class MY_Router extends MX_Router {

	/**
	 * URL読み替え処理
	 */
	public function locate($segments){
		/* get the segments array elements */
		list($module, $directory, $controller) = array_pad($segments, 3, NULL);
		if($module == 'owner' && $directory == null){
			$segments[1] = 'index';
		}elseif($module == 'kanri'){
			$segments[0] = 'admin';
			$segments[1] = 'system';
		}
		return parent::locate($segments);
	}

}
