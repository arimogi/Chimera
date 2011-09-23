<?php
  function makeMenu($data){
    $result = '';
    if(count($data)>0){
      $result .="<ul>";
      for($i=0; $i<count($data); $i++){
        if(isset($data[$i]['code']) && isset($data[$i]['name'])){
          $result .="<li>";
          $result .= anchor($data[$i]['code'], $data[$i]['name'], array("target"=>"content"));
          if(isset($data[$i]['children']) && count($data[$i]['children'])>0){
            $result .= makeMenu($data[$i]['children']);
          }
          $result .="</li>";
        }
      }
      $result .="</ul>";
    }
    return $result;    
  }
  
  echo makeMenu($menu);
?>
