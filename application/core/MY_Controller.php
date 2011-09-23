<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

if ( ! class_exists('Controller'))
{
	class Controller extends CI_Controller {}
}

class MY_Controller extends Controller
{    
    protected $allConfig;
    protected $controllerName;
    
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
        
        //the properties that can also be accessed from the children class
        $this->allConfig = $this->db_config->getAllConfig();
        $this->allConfig["logged_in"] = $this->ion_auth->logged_in();
        $this->allConfig["is_admin"] = $this->ion_auth->is_admin();
        $this->allConfig["username"] = 
            $this->allConfig["logged_in"] ? 
            $this->ion_auth->user($this->session->userdata('user_id'))->row()->username:
            "";
        $this->allConfig["menu"] = $this->ion_mod->get_menu();
        
        $this->controllerName = $this->router->fetch_class();
    }
    
    protected function init_main_template()
    {
        $controllerName = $this->controllerName;
        $allConfig = $this->allConfig;
        
        //theme
        $this->template->set_theme($this->db_config->getConfig('site_theme'));
        
        //layout
        $layout = $this->agent->is_mobile() ? 'mobile' : 'desktop';
        $this->template->set_layout($layout);
        
        //partials
        $this->template->set_partial('meta', 'layouts/'.$layout.'/meta', 
                array(
                    'meta'=>
                        ($this->asset_loader->jquery()).
                        ($this->asset_loader->jquery_treeview()).
                        ($this->asset_loader->jquery_form()).
                        ($this->asset_loader->jquery_ui())
                ));        
        $this->template->set_partial('menu', 'layouts/'.$layout.'/menu', $allConfig);
        $this->template->set_partial('footer', 'layouts/'.$layout.'/footer', $allConfig);
        $this->template->set_partial('header', 'layouts/'.$layout.'/header', $allConfig);
                    
        
         
    } 
    
    protected function init_content_template()
    {
        $controllerName = $this->controllerName;
        $allConfig = $this->allConfig;
        
        //theme
        $this->template->set_theme($this->db_config->getConfig('site_theme'));
        
        //layout
        $layout = $this->agent->is_mobile() ? 'mobile_content' : 'desktop_content';
        $this->template->set_layout($layout);
        
        //partials
        $this->template->set_partial('meta', 'layouts/'.$layout.'/meta');
                    
        
         
    } 
    
    protected function check_privilege($code)
    {
        $allowed = $this->ion_mod->check_privilege($code);
        if(!$allowed){
            redirect(base_url());
        }
    } 
}
