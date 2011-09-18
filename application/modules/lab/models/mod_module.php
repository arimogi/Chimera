<?php

namespace lab\models;

/**
 * @Entity @Table(name="mod_module")
 */
class Mod_module{
  
  /**
   * @Id @Column(type="integer") @GeneratedValue
   */ 
  private $id;
  
  /**
   * @Column(type="string", length=50, nullable=false)
   */ 
  private $menu;
  
  /**
   * @Column(type="string", length=50, nullable=false)
   */ 
  private $module;
  
  
  
  public function id($value=NULL)
  {
    return is_null($value) ? ($this->id) : ($this->id = $value);
  }
  
  public function menu($value=NULL)
  {
    return is_null($value) ? ($this->menu) : ($this->menu = $value);
  }
  
  public function module($value=NULL)
  {
    return is_null($value) ? ($this->module) : ($this->module = $value);
  }
}

?>