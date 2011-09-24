<?php
    function makeMenu($data){
        $result = '';
        if(count($data)>0){
          $result .="<ul>";
          for($i=0; $i<count($data); $i++){
            if(isset($data[$i]['code']) && isset($data[$i]['name'])){
              $haveChild = isset($data[$i]['children']) && count($data[$i]['children'])>0;  
              $spanClass = $haveChild? "folder" : "file";
              
              $result .="<li>"; 
              $result .= anchor($data[$i]['code'], $data[$i]['name'], array("target"=>"content"));
              if($haveChild){
                $result .= makeMenu($data[$i]['children']);
              }
              $result .="</li>";
            }
          }
          $result .="</ul>";
        }
        return $result;    
    }  
    
    
    $message = isset($data["message"])?$data["message"]:"";
    $identity = isset($data["identity"])?$data["identity"]:"";
    echo "<div id=\"infoMessage\">". $message. "</div>";
    if($logged_in){          
        echo form_open("main/logout"); 
        echo "Welcome, ".$username;
        echo br();
        echo form_submit('logout', 'Logout');
        echo form_close();
    }else{
        echo form_open("main/login");    	
        echo "<label>Email/Username : </label>";
        echo br();
        echo form_input('identity', $identity);
        echo br();        
        echo "<label>Password : </label>";
        echo br();
        echo form_password('password', "");
        echo br();
        echo form_checkbox('remember', '1', FALSE);
        echo "<label>Remember me</label>";
        echo br();
        echo form_submit('login', 'Login');          
        echo form_close();
    }
    echo br();
    echo "<ul class=\"treeview\">";
    echo "<li>";
    echo "Menu";
    echo makeMenu($menu);
    echo "</li>";
    echo "</ul>";
?>
