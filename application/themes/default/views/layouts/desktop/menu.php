<?php
  function getTarget($targetType){
      switch($targetType){
          case 0 : return 'content';
          case 1 : return '_SELF';
          case 2 : return '_BLANK';
          default : return 'content';
      }
  }
  function makeMenu($data){
    $result = '';
    if(count($data)>0){
      $result .="<ul>";
      for($i=0; $i<count($data); $i++){
        if(isset($data[$i]['code']) && isset($data[$i]['name'])){
          $result .="<li>";
          $config = array("target"=>getTarget($data[$i]['target']));
          $result .= anchor($data[$i]['code'], $data[$i]['name'], $config);
          if(isset($data[$i]['children'])){
            $result .= makeMenu($data[$i]['children']);
          }
          $result .="</li>";
        }
      }
      $result .="<li>";
    }
    return $result;    
  }
  
  echo makeMenu($menu);
?>
