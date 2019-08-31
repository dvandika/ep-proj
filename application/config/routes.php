<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *  All Internal Routes is located in /controller/admin/
 * 
 *  Admin Routes     :   PT. Astra Komponen Indonesia
 *  Contains:
 *      // Global Access
 *      -   Admin Login Page
 *      -   Vendor Login Page
 * 
 *      // Administrator Access
 *      -   Master Data Vendor
 *      -   Master Data Material (Include: Standar Level Stock)
 *      -   Master Data User (ASKI & Vendor)
 *      -   Master Data Web Information (optional)
 *      -   Order Sheet
 * 
 *      // Vendor Access
 *      -   Stock Material
 *      -   Order Sheet
 *      
 */

$route['default_controller'] = 'vue_controller';
$route['404_override'] = 'vue_controller';
$route['translate_uri_dashes'] = FALSE;

$route['v1/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'vue_controller';
$route['v1/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'vue_controller';
$route['v1/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'vue_controller';
$route['v1/(:any)/(:any)/(:any)/(:any)'] = 'vue_controller';
$route['v1/(:any)/(:any)/(:any)'] = 'vue_controller';
$route['v1/(:any)/(:any)'] = 'vue_controller';
$route['v1/(:any)'] = 'vue_controller';
$route['v1'] = 'vue_controller';