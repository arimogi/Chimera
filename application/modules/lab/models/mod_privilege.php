<?php

namespace lab\models;

/**
 * @Entity
 * @Table(name="mod_privilege")
 */

//Module have : id, group_id, module_id
class Mod_privilege{
  /**
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  private $id;
  
  /**
   * @Column(type="integer")
   */ 
  private $group_id;
  
  /**
   * @Column(type="integer")
   */ 
  private $module_id;
  
  
  
  public function id($value=NULL)
  {
    return is_null($value) ? ($this->id) : ($this->id = $value);
  }
  
  public function group_id($value=NULL)
  {
    return is_null($value) ? ($this->group_id) : ($this->group_id = $value);
  }
  
  public function module_id($value=NULL)
  {
    return is_null($value) ? ($this->module_id) : ($this->module_id = $value);
  }
}

?>