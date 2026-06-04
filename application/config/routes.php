<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth routes
$route['login']    = 'Auth/login';
$route['register'] = 'Auth/register';
$route['logout']   = 'Auth/logout';

// Dashboard
$route['dashboard'] = 'Jobs/dashboard';

// Job routes
$route['jobs']              = 'Jobs/index';
$route['jobs/add']          = 'Jobs/add';
$route['jobs/edit/(:num)']  = 'Jobs/edit/$1';
$route['jobs/delete/(:num)']= 'Jobs/delete/$1';
$route['jobs/view/(:num)']  = 'Jobs/view/$1';

// AJAX routes
$route['jobs/update_status'] = 'Jobs/update_status';
$route['jobs/get_stats']     = 'Jobs/get_stats';