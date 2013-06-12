<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Authorize extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('access_token'))
			redirect('meow', 'location');
	}
	
	public function index()
	{
		$url = $this->github->get_login_url();
		redirect($url, 'location');
	}
	
	public function github()
	{
		//this function needs to be called wherever your redirect_uri goes to
		$is_authorized = $this->github->authorize();
	
		//Login failed!
		if (!$is_authorized)
		{		
			$this->session->set_flashdata('message', error_message($this->github->get_error()));
			redirect(base_url(), 'location');
		}
		//Login success!
		else
		{
			//show how to get access token from session here
			$github_user = $this->github->user();
			
			$user = array(
					'github_id' => $github_user->id,
					'name' => $github_user->name,
					'email' => $github_user->email,
					'login' => $github_user->login,
					'type' => $github_user->type,
					'company' => $github_user->company,
					'avatar_url' => $github_user->avatar_url,
					'hireable' => $github_user->hireable,
					'blog' => $github_user->blog,
					'bio' => $github_user->bio,
					'gravatar_id' => $github_user->gravatar_id,
					'location' => $github_user->location,
					'access_token' => $this->github->get_access_token()
			);
			
			// Checks to see if the user exists already
			// $this->load->model('users_model');
			// $db_user = $this->users_model->get_user_by('github_id', $github_user->id);

			// If User exists update otherwise create a new record
			// if ($db_user)
			// {
			// 	$this->users_model->update($db_user->id, $user);
			// }
			// else
			// {	
			// 	$this->users_model->create($user);
			// }
			
			// For the purpose of example, we store everything in the session instead of the database
			$this->session->set_userdata($user);
		
			$this->session->set_flashdata('message', 'Boom! You\'re logged in! Welcome.');
			redirect('secure', 'location');
		}
	}
}

/* End of file authorize.php */
/* Location: ./application/controllers/authorize.php */