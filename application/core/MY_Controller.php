<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->spark('ion_mod/default');
        $this->load->spark('asset_loader/default');
        $this->load->spark('template/default');
        $this->load->library('form_validation');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->helper('form');
        
        
        $this->controllerName = $this->router->fetch_class();
        $controllerName = $this->controllerName; 
        
        //login or logout (different nav_account)
        $login = $this->ion_auth->logged_in();
        
        if($login){    
            $isAdmin = $this->ion_auth->is_admin();
            
            $profile = $this->ion_auth->user($this->session->userdata('user_id'))->row_array();
            
            
            $userName = $profile["username"];
            
            $content = 'Welcome, '. $userName .'&nbsp;';
            $content .= 
                '<a href="index.php/'.$controllerName.'/change_password">Change Password</a>&nbsp;
                <a href="index.php/'.$controllerName.'/logout">Logout</a>';
                
            $this->template->inject_partial('nav_account', $content);
        }
        else{
            $content = '
              <div id="loginForm">
                <form method="POST" action="index.php/'.$controllerName.'/login">
                  Login :
                  <input name="email" type="text" />
                  <input name="password" type="password" />
                  <input name="login" value="login" type="submit" />
                </form>
              </div>
              <a href="index.php/'.$controllerName.'/forgot_password">Forgot Password</a>
            ';
            $this->template->inject_partial('nav_account', $content);
        }
        
        $this->template->set_partial('header', 'partials/header');
        
        $meta = ($this->asset_loader->jquery());
        $meta .= ($this->asset_loader->treeview());
        $data = array("meta"=>$meta);
        $this->template->set_partial('meta', 'partials/meta', $data);
        
        $this->template->inject_partial('nav_menu',$this->ion_mod->get_menu());
        $this->template->set_partial('footer', 'partials/footer');
        
        
        
         //desktop or mobile (different layout)
        $this->template->set_theme('default');
        if ($this->agent->is_mobile())
            $this->template->set_layout('mobile');
        else if ($this->agent->is_browser())
            $this->template->set_layout('desktop');
        
       
    }
    
    public function logout()
    {
      $this->ion_auth->logout();
      redirect($this->config->item('base_url'), 'refresh');
    }
    
    public function login()
    {
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $this->ion_auth->login($email, $password);
      redirect($this->config->item('base_url'), 'refresh');
    }
    
    //forgot password
    public function forgot_password()
    {
            //get the identity type from config and send it when you load the view
            $identity = $this->config->item('identity', 'ion_auth');
            $identity_human = ucwords(str_replace('_', ' ', $identity)); //if someone uses underscores to connect words in the column names
            $this->form_validation->set_rules($identity, $identity_human, 'required');
            if ($this->form_validation->run() == false)
            {
                    //setup the input
                    $this->data[$identity] = array('name' => $identity,
                            'id' => $identity, //changed
                    );
                    //set any errors and display the form
                    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                    $this->data['identity'] = $identity; $this->data['identity_human'] = $identity_human;
                    $this->template->build('auth/forgot_password', $this->data);
            }
            else
            {
                    //run the forgotten password method to email an activation code to the user
                    $forgotten = $this->ion_auth->forgotten_password($this->input->post($identity));

                    if ($forgotten)
                    { //if there were no errors
                            $this->session->set_flashdata('message', $this->ion_auth->messages());
                            redirect($this->controllerName.'/login', 'refresh'); //we should display a confirmation page here instead of the login page
                    }
                    else
                    {
                            $this->session->set_flashdata('message', $this->ion_auth->errors());
                            redirect($this->controllerName.'/forgot_password', 'refresh');
                    }
            }
    }

    //reset password - final step for forgotten password
    public function reset_password($code)
    {
            $reset = $this->ion_auth->forgotten_password_complete($code);

            if ($reset)
            {  //if the reset worked then send them to the login page
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect($controllerName.'/login', 'refresh');
            }
            else
            { //if the reset didnt work then send them back to the forgot password page
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect($controllerName.'/forgot_password', 'refresh');
            }
    }  
    
    public function change_password()
    {
        $this->form_validation->set_rules('old', 'Old password', 'required');
        $this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

        if (!$this->ion_auth->logged_in())
        {
                redirect($this->config->item('base_url'), 'refresh');
        }
        $user = $this->ion_auth->user($this->session->userdata('user_id'))->row_array();

        if ($this->form_validation->run() == false)
        { //display the form
                //set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['old_password'] = array('name' => 'old',
                        'id' => 'old',
                        'type' => 'password',
                );
                $this->data['new_password'] = array('name' => 'new',
                        'id' => 'new',
                        'type' => 'password',
                );
                $this->data['new_password_confirm'] = array('name' => 'new_confirm',
                        'id' => 'new_confirm',
                        'type' => 'password',
                );
                $this->data['user_id'] = array('name' => 'user_id',
                        'id' => 'user_id',
                        'type' => 'hidden',
                        'value' => $user['id'],
                );

                //render
                //$this->load->view($this->controllerName.'/change_password', $this->data);
                $this->template->build('auth/change_password', $this->data);
        }
        else
        {
                $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

                $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

                if ($change)
                { //if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        $this->logout();
                }
                else
                {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect($this->controllerName.'/change_password', 'refresh');
                }
        }
    }
    
    
    protected function check_privilege($code)
    {
        $allowed = $this->ion_mod->check_privilege($code);
        if(!$allowed){
            redirect(base_url());
        }
    } 
}