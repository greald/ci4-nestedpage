<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Nestle extends BaseConfig
{
	public $pagebuildupArr = 		["page","nest"]; // content [controller, method]
	public $contentcontrollerNS = 	"\\App\\Controllers\\"; // Fully qualified name
	public $pagedata = 				["title" => "nestedpage", 
									 "authorizationstrip" => '\App\Controllers\Auth::orise', // login link / user profile
									 ];
	public $defaultContent =		["\\App\\Controllers\\Page","bottomfloor"];
}
