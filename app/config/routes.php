<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'login';
$route['404_override'] = 'errors/notfound';
$route['webtools'] = 'webtools/auth';
$route['webtools/(:any)'] = 'webtools/$1';
$route['webtools/(:any)/(:any)'] = 'webtools/$1/$2';
$route['webtools/(:any)/(:any)/(:any)'] = 'webtools/$1/$2/$3';
$route['category/(:any)'] = 'category/index/$1';
$route['category/(:any)/(:num)'] = 'category/index/$1/$2';
$route['home/updates/(:num)'] = 'home/updates/$1';
$route['home/trending/(:num)'] = 'home/trending/$1';
$route['infographic/(:num)'] = 'infographic/index/$1';
$route['infographic/(:any)'] = 'infographic/detail/$1';
$route['news/(:any)'] = 'news/index/$1';
$route['news/(:any)/(:num)'] = 'news/index/$1/$2';
$route['tag/(:any)'] = 'tag/index/$1';
$route['tag/(:any)/(:num)'] = 'tag/index/$1/$2';
$route['expert/(:num)'] = 'expert/index/$1';
$route['expert/(:any)'] = 'expert/detail/$1';
$route['expert/(:any)/(:num)'] = 'expert/detail/$1/$2';
$route['podcast/(:num)'] = 'podcast/index/$1';
$route['podcast/(:any)'] = 'podcast/detail/$1';
$route['search/(:any)'] = 'search/index/$1';
$route['search/(:any)/(:num)'] = 'search/index/$1/$2';