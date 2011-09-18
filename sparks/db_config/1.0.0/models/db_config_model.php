<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//  CI 2.0 Compatibility
if(!class_exists('CI_Model')) { class CI_Model extends Model {} }


class db_config_model extends CI_Model
{
        /**
         * Holds an array of tables used
         *
         * @var string
         **/
        public $tables = array();
        
        public function __construct()
        {
                parent::__construct();
                $this->load->database();
                
                $this->load->config('db_config', TRUE);
                $this->tables  = $this->config->item('tables', 'db_config');
        }
        
        public function getConfig($key)
        {
                $result = NULL;
                $this->db->select('value')
                        ->from($this->tables['config'])
                        ->where(array("key"=>$key));
                $query = $this->db->get();
                
                if($query->num_rows()>0){
                  foreach ($query->result() as $row)
                  {
                      $result = $row->value;
                  }
                }
                
                return $result;                
        }
        
        public function getAllConfig()
        {
                $result = array();
                $this->db->select(array('key','value'))
                        ->from($this->tables['config']);
                $query = $this->db->get();
                
                foreach ($query->result() as $row)
                {
                    $result[$row->key] = $row->value;
                }                
                return $result; 
                
        }
        

        public function setConfig($key, $value)
        {
            $this->db->delete($this->tables['config'], array('key' => $key));
            $this->db->insert($this->tables['config'], array('key' => $key, 'value' => $value));
        }
  
}
