<?php 
    $ci =& get_instance();
    echo $ci->asset_loader->all_jquery(); 
?>
<style type="text/css">
    body {
        background-color : #EEEEEE;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $("div#menu").treeview();
    });    
</script>
