<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use \lab\models\mod_module;

class Module extends MX_Controller{
  
  public function __construct()
  {
    parent::__construct();
  }
  
  public function add()
  { 
    $chimera = $this->chimera_lib;
    $input = $chimera->getValue($this->input->post());
    $newData = $chimera->getValueFromArray($input, "newData", array());
    $masterData = $chimera->getValueFromArray($input, "masterData", array());
    
    $module = new Mod_module;
    $module->menu($chimera->getValueFromArray($newData, "menu"));
    $module->module($chimera->getValueFromArray($newData, "module"));
    
    $this->doctrine->em->persist($module);
    $this->doctrine->em->flush();
    
    echo $module->id();    
  }
  
  public function edit()
  {
    $chimera = $this->chimera_lib;
    $input = $chimera->getValue($this->input->post());
    $newData = $chimera->getValueFromArray($input, "newData", array());
    $masterData = $chimera->getValueFromArray($input, "masterData", array());
    $key = $chimera->getValueFromArray($input,"key","");
    
    $module = $this->doctrine->em->find('lab\models\mod_module', $key);
    $module->menu($chimera->getValueFromArray($newData, "menu"));
    $module->module($chimera->getValueFromArray($newData, "module"));
    
    $this->doctrine->em->persist($module);
    $this->doctrine->em->flush();
    
    echo $module->id();
  }
  
  public function delete()
  {
    $chimera = $this->chimera_lib;
    $input = $chimera->getValue($this->input->post());
    $key = $chimera->getValueFromArray($input,"key","");
    
    $module = $this->doctrine->em->find('lab\models\mod_module', $key);
    if($module){      
      $this->doctrine->em->remove($module);
      $this->doctrine->em->flush();
      
      $dql = "DELETE
            FROM lab\models\mod_module tb
            WHERE tb.id = ?1";
      
      $this->doctrine->em->createQuery($dql)
                ->setParameter(1, $key)
                ->execute();
      
    }else{
      show_404();
    }
    
  }
  
  public function view()
  {
    $chimera = $this->chimera_lib;
    $input = $chimera->getValue($this->input->post());
    $filter = $chimera->getValueFromArray($input, "filter", array());
    $master = $chimera->getValueFromArray($input, "master", array());
    $dql = "SELECT tb.id, tb.menu, tb.module
            FROM lab\models\mod_module tb
            WHERE tb.menu LIKE ?1 AND tb.module LIKE ?2";
    
    $result = $this->doctrine->em->createQuery($dql)
                ->setParameter(1, $chimera->getValueFromArray($filter, "menu", "%", "%", "%"))
                ->setParameter(2, $chimera->getValueFromArray($filter, "module", "%", "%", "%"))
                ->getResult();
                
    echo json_encode($result);
  }
  
}