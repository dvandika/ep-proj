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

        if (!empty($userdata) AND $userdata->role !== "vendor") {
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

    public function cek_debug()
    {
        echo json_encode(userdata());
    }

    private function set_logged_in($kodeAkses)
    {
        $aski = ['admin', 'operator', 'developer'];
        $user = '';
        if ($kodeAkses === 'vendor') {
            $user = $this->db->select("a.id, a.fullname, a.username, a.email, a.role, v.name company, v.code vendor_code")
                ->from('tb_v_authorized a')
                ->join('tb_vendor v', 'a.vendor_code = v.code')
                ->where('a.id', 1)
                ->where('a.role', $kodeAkses)
                ->get()->row();
        } else {
            $user = $this->db->select("a.id, a.fullname, a.username, a.email, a.role, a.company")
                ->where('a.email', $kodeAkses . '@aski.id')
                ->get('tb_admin_user a')
                ->row();
        }

        if ($user) {
            set_userdata($user);
            redirect('v/dashboard');
        } else {
            $this->logout();
        }
    }

    public function vendor_login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));

            $userdata = $this->m_authorized->login_vendor($username, $password);
            if ($userdata) {
                $user = new stdClass;
                $user->id            = $userdata->ID;
                $user->username      = $userdata->Username;
                $user->fullname      = $userdata->Fullname;
                $user->email         = $userdata->Email;
                $user->code          = $userdata->VendorCode;
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
                $msg = "Username / Password salah.";
            }
        } else {
            $msg = "Data belum lengkap.";
        }

        $data['message'] = $msg;

        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function do_login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));

            $userdata = $this->m_user->login_admin($username, $password);

            if ($userdata) {
                $user = new stdClass;
                $user->id            = $userdata->id;
                $user->username      = $userdata->username;
                $user->fullname      = $userdata->fullname;
                $user->email         = $userdata->email;
                $user->role          = $userdata->role;
                set_userdata($user);

                $visited_url = get_visited_url();
                $data['user'] = $user;
                $data['visited_url'] = $visited_url;

                return $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
            } else {
                $msg = "Username / Password salah.";
            }
        } else {
            $msg = "Data belum lengkap.";
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
        redirect('/');
    }
}
