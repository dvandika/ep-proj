<?php

define('AUTH_SESS_NAME', 'ep_logged_in');
define('AUTH_VISIT_SESS_NAME', 'ep_visited_url');

if ( ! function_exists('auth_checker_init')) 
{
	function auth_checker_init() { 
		$_ci =& get_instance();

		$userdata = $_ci->session->userdata(AUTH_SESS_NAME);

		if (!empty($userdata)) {
			return $userdata;
		}
	} 
}

if ( ! function_exists('auth_checker')) 
{
	function auth_checker($roles) { 
		$_ci =& get_instance();

		$userdata = $_ci->session->userdata(AUTH_SESS_NAME);

		if (empty($userdata)) {
			// Save current url
			$_ci->session->set_userdata(AUTH_VISIT_SESS_NAME, uri_string());
			redirect('v1/');
		} else if (!in_array($userdata->role, explode(',', $roles))) {
			redirect('v1/error/403');
		}
	} 
}

if ( ! function_exists('is_users')) 
{
	function is_users($roles) { 
		$_ci =& get_instance();

		$userdata = $_ci->session->userdata(AUTH_SESS_NAME);

		if (empty($userdata)) {
			// Save current url
			$_ci->session->set_userdata(AUTH_VISIT_SESS_NAME, uri_string());
			redirect('auth');
		} else if (!in_array($userdata->role, explode(',', $roles))) {
			return false;
		}
		return true;
	} 
}

if ( ! function_exists('set_userdata')) 
{
	function set_userdata($data) { 
		$_ci =& get_instance();
		$_ci->session->set_userdata(AUTH_SESS_NAME, $data);
	} 
}

if ( ! function_exists('userdata')) 
{
	function userdata() { 
		$_ci =& get_instance();

		$userdata = $_ci->session->userdata(AUTH_SESS_NAME);

		if (empty($userdata)) return NULL;

		return $userdata;
	} 
}

if ( ! function_exists('get_visited_url')) 
{
	function get_visited_url() { 
		$_ci =& get_instance();

		$visited_url = $_ci->session->userdata(AUTH_VISIT_SESS_NAME);

		if (empty($visited_url)) return NULL;

		return $visited_url;
	} 
}

if ( ! function_exists('clear_userdata')) 
{
	function clear_userdata() { 
		$_ci =& get_instance();
		$_ci->session->unset_userdata(AUTH_SESS_NAME);
		$_ci->session->unset_userdata(AUTH_VISIT_SESS_NAME);
	} 
}