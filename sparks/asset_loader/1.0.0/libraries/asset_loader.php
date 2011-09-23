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
    
    public function jquery_treeview()
    {
        $result = $this->css('assets/js/jquery.treeview/jquery.treeview.css');
        $result .= $this->js('assets/js/jquery.treeview/jquery.treeview.js');
        return $result;
    }  
    
    public function jquery_ui()
    {
        $result = $this->css('assets/js/jquery-ui/css/ui-lightness/jquery-ui.css');
        $result .= $this->js('assets/js/jquery-ui/js/jquery-ui.min.js');
        /*
        $result .='
            <script type="text/javascript">
                $(document).ready(function(){
                    $("input.datepicker").datepicker();
                });
            </script>
            ';
         * 
         */
        
        return $result;
    }
    
    public function jquery_form()
    {
        $result = $this->js('assets/js/jquery.form.js');
        /*
        $result .='
            <script type="text/javascript">
                $(document).ready(function(){
                    $("form").ajaxForm(function(data){
                        alert(data);
                        $(".content").html(data);
                    });
                });
            </script>
            ';
         * 
         */
        
        return $result;
    }
    
    public function all_jquery()
    {
        $result = $this->jquery();
        $result .= $this->jquery_ui();
        $result .= $this->jquery_form();
        $result .= $this->jquery_treeview();
        return $result;
    }
    
    public function all_extjs()
    {
        $result = $this->jquery();
        $result = $this->extjs();
        $result .= $this->grid();
        return $result; 
    }
    
    public function all()
    {
        $result = $this->all_jquery();
        $result .= $this->all_extjs();
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