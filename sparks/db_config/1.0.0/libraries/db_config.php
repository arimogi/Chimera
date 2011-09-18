<?php

class db_config{
    
    protected $ci;  
    
    public function __construct()
    {
            $this->ci =& get_instance();
            $this->ci->load->config('db_config', TRUE);
            $this->ci->load->model('db_config_model');            
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     **/
    public function __call($method, $arguments)
    {
            if (!method_exists( $this->ci->db_config_model, $method) )
            {
                    throw new Exception('Undefined method db_config::' . $method . '() called');
            }

            return call_user_func_array( array($this->ci->db_config_model, $method), $arguments);
    }
    
    
    
    
}

?>
