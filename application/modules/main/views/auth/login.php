<div class='mainInfo'>

	<h1>Login</h1>
    <div class="pageTitleBorder"></div>
	<p>Please login with your email/username and password below.</p>
	
	<div id="infoMessage"><?php echo $message;?></div>
	
    <?php echo form_open("main/login");?>
    	
      <p>
      	<label for="identity">Email/Username:</label><br />
      	<?php echo form_input($identity);?>
      </p>
      
      <p>
      	<label for="password">Password:</label><br />
      	<?php echo form_input($password);?>
      </p>
      
      <p>
	      <label for="remember">Remember Me:</label>
	      <?php echo form_checkbox('remember', '1', FALSE);?>
	  </p>
      
      
      <p><?php echo form_submit('submit', 'Login');?></p>

      
    <?php echo form_close();?>

</div>
