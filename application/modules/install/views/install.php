<?php
echo '<h1>Install Chimera on your server</h1>';
echo $message;
echo form_open('install/apply');
echo form_fieldset('Database Information');
echo form_label('Database Server');
echo br();
echo form_input('server','localhost');
echo br();
echo form_label('User Name');
echo br();
echo form_input('username','root');
echo br();
echo form_label('Password');
echo br();
echo form_password('password');
echo br();
echo form_label('Database/Schema (Should be exists)');
echo br();
echo form_input('database');
echo form_fieldset_close();
echo br();
echo form_submit('Install', 'INSTALL NOW');
echo form_close()
?>
