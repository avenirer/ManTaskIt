<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo 'bau';
    }

    public function login()
    {
        if($this->ion_auth->logged_in())
        {
            redirect('welcome');
        }
        $redirect_to = $this->session->flashdata('redirect_to');
        if(!isset($redirect_to) && isset($_SERVER['HTTP_REFERER']))
        {
            $redirect_to = $_SERVER['HTTP_REFERER'];
            if(strpos($redirect_to, site_url(), 0)=== FALSE) $redirect_to = site_url();
        }
        elseif(!isset($redirect_to))
        {
            $redirect_to = site_url();
        }
        $this->data['redirect_to'] = $redirect_to;
        $this->data['page_title'] = 'Login';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('remember','Remember me','integer');
        $this->form_validation->set_rules('redirect_to','Redirect to','valid_url');
        if($this->form_validation->run()===TRUE)
        {
            $remember = (bool) $this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
            {
                redirect('/');
            }
            else
            {
                $this->postal->add($this->ion_auth->errors(),'error');
                redirect('user/login');
            }
        }
        $this->load->helper('form');
        $this->load->view('login_view');
    }

    public function logout()
    {
        $this->ion_auth->logout();
        $this->postal->add($this->ion_auth->messages(),'error');
        redirect('user/login');
    }
}