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

$route['default_controller'] = "user/login";
$route['404_override'] = '';

$route['dashboard'] = "presences/input";

// naskah
$route['naskah/roles/index'] = 'naskah_roles/index';
$route['naskah/roles/getAll'] = 'naskah_roles/getAll';
$route['naskah/roles/getMappedKaryawans'] = 'naskah_roles/getMappedKaryawans';
$route['naskah/roles/saveMapping'] = 'naskah_roles/saveMapping';
$route['naskah/pengajuan'] = 'naskah/index';

$route['proses_job'] = 'proses_job/index';

$route['report/daily'] = 'report/daily';
$route['report/naskah'] = 'report/naskah';
$route['report/naskah/(:any)'] = 'report/naskahView/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */