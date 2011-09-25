<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

if ( ! class_exists('Controller'))
{
	class Controller extends CI_Controller {}
}
/**
 * Description of install
 *
 * @author gofrendi
 */
class install extends Controller {
    private $db;
    
    public function __construct(){
        parent::__construct();
        
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->helper('form');  
    }
    
    public function index(){
        //view configuration form
        $data = array ("message" => $this->session->flashdata('message'));
        $this->load->view('install', $data);        
    }
    
    public function apply(){
        $correct = true;
        $message = "";
        
        //examine configuration input
        $this->session->set_userdata($this->input->post());
        if(!is_writeable('./application/config')){
            $correct = false;
            $message .= 'Directory application/config is not writeable'.br();
        }
        if(!$this->test_db_connection()){
            $correct = false;
            $message .= 'Cannot connect to database'.br();
        }
        $this->session->set_flashdata('message',$message);
        
        //if correct, install, else, redirect to index
        if($correct){
            //config.php
            $str = file_get_contents('./application/modules/install/assets/config.php');
            file_put_contents('./application/config/config.php', $str);
            
            //database.php
            $server = $this->session->userdata('server');
            $username = $this->session->userdata('username');
            $password = $this->session->userdata('password');
            $port	  = $this->session->userdata('port');
            $database = $this->session->userdata('database');
            $str = file_get_contents('./application/modules/install/assets/database.php');            
            $str = str_replace('@SERVER', "$server:$port", $str);
            $str = str_replace('@DATABASE', $database, $str);
            $str = str_replace('@USERNAME', $username, $str);
            $str = str_replace('@PASSWORD', $password, $str);
            file_put_contents('./application/config/database.php', $str);
            
            //route.php
            $str = file_get_contents('./application/modules/install/assets/routes.php');
            file_put_contents('./application/config/routes.php', $str);
            
            //database
            $str = file_get_contents('./application/modules/install/assets/data.sql');
            $queries 	= explode('--split--', $str);		
            foreach($queries as $query)
            {
                $query = rtrim( trim($query), "\n;");

                @mysql_query($query, $this->db);

                if (mysql_errno($this->db) > 0)
                {
                        echo "database installation failed, please install by yourself".br();
                }
            }
            
            echo "Installed successfully".br();
            echo "delete /application/modules/install".br();
            echo "perform chmod 755 * -R".br();
            echo anchor("main","Click this link to see the chimera");
        }
        else{
            echo "not correct";
            redirect('install/index', 'refresh');
        }
    }
    
    private function test_db_connection(){
        $server = $this->session->userdata('server');
        $username = $this->session->userdata('username');
        $password = $this->session->userdata('password');
        $port	  = $this->session->userdata('port');
        $database = $this->session->userdata('database');

        $this->db = @mysql_connect("$server:$port", $username, $password);
        
        if (!$this->db) return false;
        
        if (@mysql_select_db($database, $this->db)) return true;
        else return false;
    }
}

?>
