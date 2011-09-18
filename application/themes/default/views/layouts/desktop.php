<?php echo doctype(); ?>
<html>
    <head>
        <title><?php echo $template['title']; ?></title>
        <base href="<?php echo base_url(); ?>" />
        <?php echo $template['partials']['meta']; ?>        
    </head>
    <body>
        <div id="all">
            <div id="header">
              <?php echo $template['partials']['header']; ?>
            </div>         
            <div id="nav_menu"><?php echo $template['partials']['nav_menu']; ?></div>
            <div id="center">               
              <iframe class="content" name="content"></iframe> 
              <div class="content" name="content"><?php echo $template['body']; ?></div>
            </div>
            <div id="footer">
              <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
              <img src="assets/images/chimera/chimera.png" /><br />
              <?php echo $template['partials']['footer']; ?>
            </div>
        </div>
    </body>
</html>  