<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Secure extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		// If Useris Not Logged In, redirect back home
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

	public function index()
	{
		$this->stencil->title('Secure');
		$this->stencil->paint('secure/index_view');
	}

	// List the Logged In Users Gists
	public function gists()
	{
		$this->stencil->title('My Gists');

		$data['gists'] = $this->github->list_gists();

		$this->stencil->paint('secure/gists_view', $data);
	}

	// Create a Gist Saying that you love this library
	public function create_gist()
	{
		$this->stencil->title('Create Gists');

		$new_gist =  array(
			'description' => 'This Gist was created by scotch.io CodeIgniter Library for Github',
			'public' => 1,
			'files' => array(
				'ilovescotch.txt' => array(
					'content' => 'Scotch Scotch Scotch'
				),
				'ilovecodeigniter.php' => array(
					'content' => 'Nicholas Cerminara was here. But how!?'
				)
			)
		);

		$data['gist'] = $this->github->create_gist($new_gist);

		if ($data['gist'])
		{
			$this->stencil->paint('secure/new_gist_view', $data);
		}
	}

	public function logout()
	{
		foreach ($this->session->all_userdata() as $key => $value) {
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
				$this->session->unset_userdata($key);
			}
		}
		
		$this->session->set_flashdata('message', success_message('And you are now logged out!'));
		redirect(base_url(), 'location');
	}

}