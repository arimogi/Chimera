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
            <div id="menu"><?php echo $template['partials']['menu']; ?></div>
            <div id="center">               
              <iframe id="content" name="content" src="<?php echo $template['body']; ?>"></iframe>
            </div>
            <div id="footer">
              <?php echo $template['partials']['footer']; ?>
            </div>
        </div>
    </body>
</html>  