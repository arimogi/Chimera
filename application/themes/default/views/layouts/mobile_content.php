<?php echo doctype(); ?>
<html>
    <head>
        <base href="<?php echo base_url(); ?>" />
        <?php echo $template['partials']['meta_all']; ?>  
        <?php echo $template['partials']['meta_content']; ?>
    </head>
    <body>
        <?php echo $template['body']; ?>
    </body>
</html> 
