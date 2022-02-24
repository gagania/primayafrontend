<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('url');
    }

    function _remap() {
        $segment_1 = $this->uri->segment(1);
        $segment_2 = $this->uri->segment(2);
        $this->data['title'] = 'LOGIN';
        $this->data['menu_active'] = 'Home';
        $this->data['content'] = 'login/index';
        if ($segment_2 == '' && !strpos($segment_1, '.html')) {
        
        } else if ($segment_2 == 'auth') {
            $this->login();
        } else if ($segment_2 == 'logout') {
            $this->logout();
        }
        
        $this->load->view('layout_frontend_login', $this->data);
    }

    function login() {
        $postData = $this->input->post();
        $username = trim($postData['user_name']);
        $password = trim($postData['user_pass']);
        $result = array();
        $result['success'] = true;
        $result['login'] = false;
        
        $user = $this->login_api($username, $password);
        if (!isset($user['error'])) {
            $input_session = array('user_id' => $user[0]['id'], 'user_name' => $user[0]['user_name'],
                'user_email' => $user[0]['user_email'], 'login' => TRUE);
            $this->session->set_userdata($input_session);
            $result['success'] = true;
        } else {
            $result['success'] = false;
        }
        header("Content-type: application/json");
        echo json_encode($result);exit;
    }
    
    function login_api($username, $password) {
        $url = "localhost/primayaapi/user/login";
        $ch = curl_init($url);

        $data = array('username'=>$username,"userpass"=>$password);
        $data_string = http_build_query($data);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded')
        );

        if (curl_errno($ch)) {
            echo curl_errno($ch);
            echo curl_error($ch);
        } else {
            $response = curl_exec($ch);
            $token = $this->getToken();
            if (isset($token['error'])) {
                redirect('/');
            }
            if (!$this->session->userdata('token')) {
                $this->session->set_userdata(array('token'=>$token['access_token']));
            }
            curl_close($ch);
            return json_decode($response, true);
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }

}
