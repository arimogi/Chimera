<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use \lab\models\mod_module;
use \lab\models\mod_privilege;

class Lab extends MY_Controller {
  public function __construct()
  {
    parent::__construct();                
  }
    
  public function index()
  {
    $data = array(
      "include" => $this->asset_loader->baseTag().
        $this->asset_loader->all()
    );
    $this->template->build('lab/lab_index', $data);
  }
  
  public function install()
  {
    $this->doctrine->tool->createSchema(array(
         $this->doctrine->em->getClassMetadata('lab\models\mod_module'),
         $this->doctrine->em->getClassMetadata('lab\models\mod_privilege')
    ));
    echo "Installed, mod_module and mod_privilege added";
  }
}

/* End of file welcome.php */
/* Location: ./application/modules/lab/controllers/lab.php */
