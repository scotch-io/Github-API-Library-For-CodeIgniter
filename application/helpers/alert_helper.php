<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('error_message'))
{
	function error_message($content = NULL)
	{
		if (is_null($content))
		{
			return FALSE;
		}

		return '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Oh snap!</strong> '.$content.'</div>';
	}
}

if (!function_exists('success_message'))
{
	function success_message($content = NULL)
	{
		if (is_null($content))
		{
			return FALSE;
		}

		return '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Success!</strong> '.$content.'</div>';
	}
}

/* End of file alert_helper.php */
/* Location: ./application/helpers/alert_helper.php */ 