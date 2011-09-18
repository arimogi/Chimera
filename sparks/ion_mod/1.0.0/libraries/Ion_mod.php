<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ion_mod
{
	
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->config('ion_mod', TRUE);
		$this->ci->load->model('ion_mod_model');
	}

	/**
	 * __call
	 *
	 * Acts as a simple way to call model methods without loads of stupid alias'
	 *
	 **/
	public function __call($method, $arguments)
	{
		if (!method_exists( $this->ci->ion_mod_model, $method) )
		{
			throw new Exception('Undefined method Ion_mod::' . $method . '() called');
		}

		return call_user_func_array( array($this->ci->ion_mod_model, $method), $arguments);
	}	

}