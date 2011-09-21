<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

if ( ! class_exists('Controller'))
{
	class Controller extends CI_Controller {}
}

class MY_Controller extends Controller
{    
    public function __construct()
    {
        parent::__construct(); 
        $this->load->library('user_agent');
        $this->load->library('form_validation');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->helper('form');
        
        //sparks
        $this->config->load('main', TRUE);
        $sparks = $this->config->item('sparks', 'main');
        for($i=0; $i<count($sparks); $i++){
            $this->load->spark($sparks[$i]['name'].'/'.$sparks[$i]['version']);
        }      
    }
    
    protected function init_template()
    {         
        $this->controllerName = $this->router->fetch_class();
        $controllerName = $this->controllerName; 
        
        $this->allConfig = $this->db_config->getAllConfig();
        $allConfig = $this->allConfig;
        
        //partials
        $this->template->set_partial('meta', 'partials/meta', array('meta'=>($this->asset_loader->jquery()).($this->asset_loader->treeview())));        
        $this->template->set_partial('nav_menu', 'partials/menu', array('menu'=>$this->ion_mod->get_menu()));
        $this->template->set_partial('footer', 'partials/footer', $allConfig);
        $this->template->set_partial('header', 'partials/header', $allConfig);
                    
        
        //theme
        $this->template->set_theme($this->db_config->getConfig('site_theme'));
        
        //layout
        if ($this->agent->is_mobile())
            $this->template->set_layout('mobile');
        else if ($this->agent->is_browser())
            $this->template->set_layout('desktop');  
    } 
    
    protected function check_privilege($code)
    {
        $allowed = $this->ion_mod->check_privilege($code);
        if(!$allowed){
            redirect(base_url());
        }
    } 
}
