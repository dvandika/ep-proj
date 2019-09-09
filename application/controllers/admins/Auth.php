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
        $this->load->model(['m_authentication']);
    }

    public function index()
    {
        $userdata = userdata();
        if (!empty($userdata) AND $userdata->role !== "vendor") {
            return $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($userdata));
        } 
        // if userdata() doesn't exist
        // or userdata()->role is vendor
        return $this->output->set_status_header(401);
    }

    public function do_login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));

            $userdata = $this->m_authentication->login_admin($username, $password);
            if ($userdata) {
                $user = new stdClass;
                $user->id            = $userdata->ID;
                $user->username      = $userdata->Username;
                $user->fullname      = $userdata->Fullname;
                $user->email         = $userdata->Email;
                $user->company       = $userdata->Company;
                $user->role          = $userdata->Role;
                set_userdata($user);

                $visited_url = get_visited_url();
                $data['user'] = $user;
                $data['visited_url'] = $visited_url;

                return $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
            } else {
                $msg = "Username atau Password salah!";
            }
        } else {
            $msg = "Mohon masukkan data dengan lengkap!";
        }

        $data['message'] = $msg;

        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function logout()
    {
        clear_userdata();
        redirect('/v1/admin');
    }
}
