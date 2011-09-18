<?php

class Asset_loader{
    
    protected $ci;
    
    public function __construct()
    {
      $this->ci =& get_instance();  
      $this->ci->load->helper('url');
    }
  
    public function baseTag()
    {
        return '<base href='.base_url().'>';
    }
    
    public function js($location)
    {
        return '<script type="text/javascript" src="'.base_url().$location.'"></script>';
    }
    
    public function css($location)
    {
        return '<link rel="stylesheet" href="'.base_url().$location.'"></link>';
    }
    
    public function jquery()
    {
        return $this->js('assets/js/jquery.js');
    }
    
    public function extjs()
    {
        $result = $this->css('assets/js/extjs/resources/css/ext-all.css');
        $result .= $this->js('assets/js/extjs/ext-all.js');
        return $result;
    }
    
    public function grid()
    {
        return $this->js('assets/js/persistence_grid.js');        
    }
    
    public function treeview()
    {
        $result = $this->css('assets/js/jquery.treeview/jquery.treeview.css');
        $result .= $this->js('assets/js/jquery.treeview/jquery.treeview.js');
        return $result;
    }  
    
    
    public function all()
    {
        $result = $this->jquery();
        $result = $this->treeview();
        $result .= $this->extjs();
        $result .= $this->grid();
        return $result;
    }
    
    public function getValue($value, $default = NULL, $prefix = NULL, $suffix = NULL)
    {
      return isset($value) ? 
        (is_string($value) ? ($prefix.$value.$suffix) : $value) : 
        $default;   
    }
    
    public function getValueFromArray($array, $index, $default = NULL, $prefix = NULL, $suffix = NULL)
    {
      $array = $this->getValue($array, array());
      return isset($array[$index]) ? 
        (is_string($array[$index]) ? $prefix.$array[$index].$suffix : $array[$index] ) : 
        $default;
    }
    
    
    
}

?>