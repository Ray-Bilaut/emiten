<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| META TAG
|--------------------------------------------------------------------------
|
|	untuk config meta tag aplikasi
|
*/
$config['app_meta_title'] = 'Emitennews.com - Salam Market dan Update';			// maksimal 12 words, best 3-5 words
$config['app_meta_description'] = 'Menyajikan industri pasar modal sebagai menu utama. Bersumber dari regulator, emiten, perusahaan sekuritas, pelaku pasar, dan sumber kredibel lainnya.';	// 150 karakter
$config['app_meta_keywords'] = 'regulator, emiten, sekuritas, pelaku pasar, investor, saham, makro, mikro, keuangan';		// maksimal 30 keywords

/*
|--------------------------------------------------------------------------
| Session name
|--------------------------------------------------------------------------
|
|	Nama session user
|
*/
$config['app_session_name'] = '47.s]Xu7ELldmeMiTenN3wsP82i/v1W[5y6X_z(5f24sq[8';

/*
|--------------------------------------------------------------------------
| Login page
|--------------------------------------------------------------------------
|
|	Halaman untuk login
|
*/
$config['app_login_page'] = 'auth/login';

/*
|--------------------------------------------------------------------------
| Register page
|--------------------------------------------------------------------------
|
|	Halaman register
|
*/
$config['app_register_page'] = 'auth/register';

/*
|--------------------------------------------------------------------------
| After login page
|--------------------------------------------------------------------------
|
|	Setelah login user akan dilempar kesini, kecuali yang telah di set callback url nya
|
*/
$config['app_after_login_page'] = 'home';

/*
|--------------------------------------------------------------------------
| Google Analytic
|--------------------------------------------------------------------------
|
|	code google analytic (javascript)
|
*/
$config['app_google_analytic'] = "";

/*
|--------------------------------------------------------------------------
| REST API SETTING
|--------------------------------------------------------------------------
|
|	settingan buat REST API
|
*/
$config['app_api_appname'] = ""; //API APP NAME

/*
|--------------------------------------------------------------------------
| WEBTOOLS CONFIG
|--------------------------------------------------------------------------
|
|	Webtools Configurations
|
*/
$config['app_webtools_default_page'] = 'welcome';

/*
|--------------------------------------------------------------------------
| PASSWORD HASH CONFIG
|--------------------------------------------------------------------------
|
|	Password HASH Configuration
|
*/
$config['app_password_rotations'] = 7;
$config['app_password_salt'] = '1z9!SHWSA3P]E1B47.s]Xu7ELldmP82i/v1W[5y6X_z(5f24sq[8';

/*
|--------------------------------------------------------------------------
| CONFIG LAIN_LAIN
|--------------------------------------------------------------------------
|
*/
$config['app_cron_base'] = "http://localhost";