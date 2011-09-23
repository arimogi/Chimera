<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//  CI 2.0 Compatibility
if(!class_exists('CI_Model')) { class CI_Model extends Model {} }


class Ion_mod_model extends CI_Model
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
                
                $this->load->config('ion_mod', TRUE);
                $table_mod  = $this->config->item('tables', 'ion_mod');                
                $this->load->config('ion_auth', TRUE);
                $table_auth = $this->config->item('tables', 'ion_auth');
                $this->tables = array_merge($table_mod, $table_auth);                
                
                $this->load->library('ion_auth');
                
                
                $this->logged_in = $this->ion_auth->logged_in();
                $this->is_admin = $this->ion_auth->is_admin();                
                $this->profile = $this->ion_auth->user($this->session->userdata('user_id'))->row_array();
                $this->user_id = isset($this->profile['id']) ? $this->profile['id'] : 0;
        }
        
        public function get_menu($parentId = 0){
                $result = array();
                if(is_null($parentId)){
                  return $result;
                }
                
                //$group_id = isset($this->profile["group_id"]) ? $this->profile["group_id"] : 0;
                
                $SQL_valid_menu = "
                  SELECT 
                    MG.menu_id 
                  FROM ".
                    $this->tables["menus_groups"]." AS MG, ".$this->tables["users_groups"] ." AS UG
                  WHERE 
                    (MG.group_id = UG.group_id) AND
                    (UG.user_id = ".(isset($this->profile["id"])?$this->profile["id"]:0).")";
                  
                $SQL = "
                  SELECT 
                    id, code, name, description
                  FROM ".
                    $this->tables["menus"]."
                  WHERE 
                    (
                      ((parent_id = ".$this->db->escape($parentId).")) OR 
                      (".($parentId==0?"TRUE":"FALSE")." AND (ISNULL(parent_id)))
                    ) AND
                    (
                      (type=0) OR
                      ((type=1) AND (".(!$this->logged_in?"TRUE":"FALSE").")) OR
                      ((type=2) AND (".($this->logged_in?"TRUE":"FALSE").")) OR
                      (
                        (type=3) AND 
                        (
                          (id IN (".$SQL_valid_menu.")) OR
                          (".($this->is_admin?"TRUE":"FALSE").")
                        )
                      )
                    )
                    
                ";
                
                $query = $this->db->query($SQL);
                if($query->num_rows()>0){   
                  foreach ($query->result() as $row)
                  {
                      $tmp = array();
                      $tmp['code'] = $row->code;
                      $tmp['name'] = $row->name;
                      $tmp['description'] = $row->description;
                      $tmp['children'] = $this->get_menu($row->id);
                      $result[] = $tmp;
                  }
                }
                
                return $result;
        }
        
        public function check_privilege($code)
        {
          if($this->is_admin) return TRUE;
          
          $SQL = "
                  SELECT id, type
                  FROM ".$this->tables["menus"]."
                  WHERE code = ".$this->db->escape($code); 
          $query = $this->db->query($SQL);
          foreach ($query->result() as $row)
          {
            switch($row->type){
              case 0 : return TRUE; break;
              case 1 : return !$this->logged_in; break;
              case 2 : return $this->logged_in; break;
              case 3 : 
                  $SQL = "
                    SELECT 
                      MG.menu_id 
                    FROM ".
                      $this->tables["menus_groups"]." AS MG, ".$this->tables["users_groups"] ." AS UG
                    WHERE 
                      (MG.group_id = UG.group_id) AND
                      (UG.user_id = ".(isset($this->profile["id"])?$this->profile["id"]:0).") AND
                      (MG.menu_id = ".$row->id.")";
                  $query2 = $this->db->query($SQL);
                  return ($query2->num_rows()>0) ? TRUE : FALSE;
                  break;
            }
          }
          return FALSE;
          
        }
  
}
