<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $website;
	protected $data = array();
	function __construct()
	{
		parent::__construct();
        $this->website = $this->website_model->get();
        $this->data['website'] = $this->website;
        $this->data['page_title'] = $this->website->title;
        $this->data['page_description'] = '';
		$this->data['before_head'] = '';
		$this->data['before_body'] = '';

        if (!$this->ion_auth->logged_in())
        {
            //redirect them to the login page
            redirect('user/login');
        }
        $current_user = $this->ion_auth->user()->row();
        $this->user_id = $current_user->id;
        //$this->data['current_user'] = $current_user;
        $this->data['current_user_menu'] = '';
        if($this->ion_auth->is_admin()) $this->data['current_user_menu'] = $this->load->view('templates/_parts/user_menu_admin_view',NULL, TRUE);
        $ips = $this->banned_model->get_all();
        $banned_ips = array();
        if(!empty($ips))
        {
            foreach($ips as $ip)
            {
                $banned_ips[] = $ip->ip;
            }
        }
        if(in_array($_SERVER['REMOTE_ADDR'],$banned_ips))
        {
            echo 'You are banned from this site.';
            exit;
        }
        if($this->website->status == '0') {
            if (!$this->ion_auth->is_admin()) {
                redirect('offline', 'refresh', 503);
            }
        }
        unset($current_user);

	}

	protected function render($the_view = NULL, $template = 'master')
	{
		if($template == 'json' || $this->input->is_ajax_request())
		{
			header('Content-Type: application/json');
			echo json_encode($this->data);
		}
		elseif(is_null($template))
		{
			$this->load->view($the_view,$this->data);
		}
		else
		{
			$this->data['the_view_content'] = (is_null($the_view)) ? '' : $this->load->view($the_view, $this->data, TRUE);
			$this->load->view('templates/' . $template . '_view', $this->data);
		}
	}
}