<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->github->get_access_token())
			redirect(base_url(), 'location');

		$this->stencil->slice('head');
		$this->stencil->layout('subpage_layout');

		$data['github_id'] = $this->session->userdata('github_id');
		$data['name'] = $this->session->userdata('name');
		$data['email'] = $this->session->userdata('email');
		$data['login'] = $this->session->userdata('login');
		$data['type'] = $this->session->userdata('type');
		$data['company'] = $this->session->userdata('company');
		$data['avatar_url'] = $this->session->userdata('avatar_url');
		$data['hireable'] = $this->session->userdata('hireable');
		$data['blog'] = $this->session->userdata('blog');
		$data['bio'] = $this->session->userdata('bio');
		$data['location'] = $this->session->userdata('location');
		$data['access_token'] = $this->session->userdata('access_token');

		// Makes data available to all views
		$this->stencil->data($data);
	}

  	function index()
 	{
		switch ($this->uri->segment(1)) 
		{
			// This is used for quick static pages without having to deal with routing (see routes.php and the docs for more info)
			// Just make the "case" look exactly like the URL you want
			case 'license' :
				$this->stencil->title('License');
				$this->stencil->paint('license_view');
				break;
			
			default :
				$this->output->set_status_header('404');
				
				$this->stencil->title('404 Page Not Found');
				$this->stencil->paint('404_view');
				break;
		}
	}
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */