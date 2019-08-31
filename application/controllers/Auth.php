<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Ini Auth Biasa
/**
 *  Isi JSON
 *  ----------
 *  index: check authentication status
 *  auth_debug: autoLogin for admin
 *  do_login: action authentication 
 *  logout: action deauthentication (destroy session)
 */

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['m_user', 'm_authorized']);
    }

    public function index()
    {
        // userdata() ada dari HELPER
        $userdata = userdata();

        if (!empty($userdata)) {
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($userdata));
        }
        // if userdata() doesn't exist
        return $this->output->set_status_header(401);
    }

    public function authDebug($kodeAkses)
    {
        $this->set_logged_in($kodeAkses);
    }

    private function set_logged_in($kodeAkses)
    {
        $aski = ['admin', 'operator', 'developer'];
        $user = '';
        if ($kodeAkses === 'vendor') {
            $user = $this->db->select("a.id, a.fullname, a.username, a.email, a.role, v.vendorcode, v.vendorname company")
                ->from('ep_vendor_auth a')
                ->join('ep_vendor v', 'a.vendorcode = v.vendorcode')
                ->where('a.id', 1)
                ->where('a.role', $kodeAkses)
                ->get()->row();
        } else {
            $user = $this->db->select("a.id, CONCAT(a.firstname, ' ', a.lastname) AS fullname, a.username, a.email, a.role, a.company")
            ->where('a.email', "$kodeAkses@aski.id")
            ->get('ep_admin a')
            ->row();
        }

        if ($user) {
            set_userdata($user);
            if ($kodeAkses === 'vendor') {
                redirect('v1/dashboard');
            } else {
                redirect('v1/admin');
            }
        } else {
            $this->logout();
        }
    }

    public function logout()
    {
        clear_userdata();
        redirect('/');
    }
}
