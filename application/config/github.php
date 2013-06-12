<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['client_id'] = '6ea6b446fb1352fad67a';
$config['client_secret'] = '36fb30c3a54262c35d2967a3a136e3af392f4f22';
$config['redirect_uri'] = 'http://server.dev/authorize/github';
//user,user:email,user:follow,public_repo,repo,repo:status,delete_repo,notifications,gist
$config['scope'] = 'user,user:email,notifications,repo,gist';


/* End of file github.php */
/* Location: ./application/config/github.php */