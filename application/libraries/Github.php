<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('curl_init'))  throw new Exception('CURL PHP extension is required.');
if (!function_exists('json_decode')) throw new Exception('JSON PHP extension is required.');

class Github {
		
	protected $api_url = 'https://api.github.com/';
	protected $client_id = '';
	protected $client_secret = '';
	protected $state = '';
	protected $redirect_uri = '';
	protected $scope = '';
	protected $access_token = '';
	
	protected $error_message = FALSE;

	public function __construct($user_config = array())
	{
		$this->CI =& get_instance();		
		$this->CI->config->load('github');
		
		$default_config = array(
			'redirect_uri' => urlencode($this->CI->config->item('redirect_uri')),
			'client_id' => $this->CI->config->item('client_id'),
			'client_secret' => $this->CI->config->item('client_secret'),
			'state' => $this->CI->session->userdata('session_id'),
			'scope' => $this->CI->config->item('scope')
        );
		
        // Merge default and user config. User config takes predence over default config
        $config = array_merge($default_config, $user_config);

        // Set all attributes
        $this->redirect_uri		= $config['redirect_uri'];
        $this->client_id    	= $config['client_id'];
        $this->client_secret 	= $config['client_secret'];
        $this->state  			= $config['state'];
        $this->scope 			= $config['scope'];
		
		$this->access_token		= $this->CI->session->userdata('access_token');
	}
	
	public function get_login_url()
	{
		return 'https://github.com/login/oauth/authorize?redirect_uri='.$this->redirect_uri.'&client_id='.$this->client_id.'&state='.$this->state.'&scope='.$this->scope;
	}
	
	public function authorize()
	{
		$session_id = $this->CI->session->userdata('session_id');
		$state = $this->CI->input->get('state');
		$code = $this->CI->input->get('code');
		
		//checks if application was accepted and all data (code + state get params) from GitHub is returned
		if ($this->CI->input->get('error') || !$state || !$code)
		{
			$this->_set_error('You must login with Github to continue! Please try again.');
			return FALSE;
		}
		
		//make sure that the request for authentication was sent from your site
		if ($session_id != $state)
		{
			$this->_set_error('The request may have been created by a third party and the process was terminated for your security! Please try again.');
			return FALSE;
		}
		
		//at this point, user has accepted the application, $_GET['state'] == session_id -- time/safe to proceed and retrieve the access_token 
		$request = $this->request_access_token($code, $state);
		
		//checks to see if access_token was returned successfully (if error occurs, it's likely because the temporary code param has expired)
		if (isset($request->error))
		{
			$this->_set_error('There was an error because things were probably happening too slow! Possibly a timeout or an expired code parameter. Please try again!');
			return FALSE;
		}
		
		//request for access token was a success! Store the access_token in the session for future use
		$this->set_access_token($request->access_token);
		$this->CI->session->set_userdata('access_token', $request->access_token);
		
		return TRUE;
	}
	
	public function request_access_token($code, $state)
	{
		$url = 'https://github.com/login/oauth/access_token?client_id='.$this->client_id.'&client_secret='.$this->client_secret.'&code='.$code.'&state='.$state;
		return $this->curl($url);
	}
	
	public function get_access_token()
	{
		return $this->access_token;
	}
	
	/*	Note:
	The access_token is stored in the session when "authorize()"
	is called, so you'll only need to use this if you're using
	a different access_token than the current logged in user.
	You'll see in the construct of this file that the access_token
	is set by the session each time this library is initialized/loaded. */
	public function set_access_token($access_token)
	{
		$this->access_token = $access_token;
		return;
	}
	
	public function rate_limit()
	{
		return $this->curl('rate_limit');
	}
	
	public function user()
	{
		return $this->curl('user');
	}
	
	public function list_gists()
	{
		return $this->curl('gists');
	}
	
	public function read_gist($id)
	{
		return $this->curl('gists/'.$id);
	}

	public function create_gist($body = array())
	{
		return $this->curl('gists', 'POST', $body);
	}

	public function edit_gist($id, $body = array())
	{
		return $this->curl('gists/'.$id, 'PATCH', $body);
	}

	public function delete_gist($id)
	{
		return $this->curl('gists/'.$id, 'DELETE', '');
	}
	
	public function curl($uri, $verb = 'GET', $body = array(), $headers = FALSE)
	{
		$url = (preg_match('#^www|^http|^//#', $uri)) ? $uri : $this->api_url.$uri.'?access_token='.$this->access_token;
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)"); 
		
		if ($headers)
		{
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			curl_setopt($ch, CURLOPT_HEADER, 1);
		}
		
		if (!empty($body))
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body)); 
		}
		
		switch ($verb)
		{
			case 'POST' :
				curl_setopt($ch, CURLOPT_POST, 1);
				break;
			case 'PATCH' :
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
				break;
			case 'PUT' :
				curl_setopt($ch, CURLOPT_PUT, 1);
				break;
			case 'DELETE' :
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
			default :
				break;
		}
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		$output = curl_exec($ch);

		if ($headers)
			$result = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		else
			$result = json_decode($output);

		curl_close($ch);
		
		if (isset($result->message))
		{
			$this->_set_error($result->message);
			return FALSE;
		}
		
		return $result;
	}
	
	public function get_error()
	{
		if (!$this->error_message)
			return FALSE;

		$error_message = $this->error_message;
		$this->error_message = FALSE;

		return $error_message;
	}
	
	protected function _set_error($message)
    {
        $this->error_message = $message;
        return FALSE;
    }
}
/* End of file Github.php */
/* Location: ./application/libararies/Github.php */