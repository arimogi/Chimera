<title><?php echo $site_title ?></title>
<img id="imglogo" src="assets/images/chimera/chimera.png" />
<h1 id="sitename">    
    <?php echo $site_title; ?>
</h1>
<div class="right">
    <p><?php echo $site_slogan; ?></p>    
    <?php
        if($logged_in){          
          echo form_open("main/logout"); 
          echo "Welcome, ".$username."&nbsp;";
          echo form_submit('logout', 'Logout');
          echo form_close();
        }else{
          echo form_open("main/login");    	
          echo "<label>Email/Username : </label>";
          echo form_input('identity', isset($identity)?$identity:"");
          echo "&nbsp;&nbsp;";
          echo "<label>Password : </label>";
          echo form_password('password', isset($password)?$password:"");          
          echo form_submit('login', 'Login');
          echo br();
          echo form_checkbox('remember', '1', FALSE);
          echo "<label>Remember me</label>";
          echo form_close();
        }
    ?>
</div>
