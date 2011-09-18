<?php echo doctype(); ?>
<html>
    <head>
        <title><?php echo $template['title']; ?></title>
    </head>

    <body>
        <?php echo $template['partials']['menu'] ?>
        <?php echo $template['body']; ?>
    </body>
</html>  