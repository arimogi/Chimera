<style type="text/css">

        ::selection{ background-color: #E13300 !important; color: white !important; }
        ::moz-selection{ background-color: #E13300!important; color: white!important; }
        ::webkit-selection{ background-color: #E13300!important; color: white!important; }        

        body {
                background-color: #fff!important;
                font: 13px/20px normal Helvetica, Arial, sans-serif!important;
                color: #4F5155!important;
                padding : 10px!important;
                background-color : #EEEEEE!important;
        }

        a {
                color: #003399!important;
                background-color: transparent!important;
                font-weight: normal!important;
        }

        h1 {
                color: #444!important;
                background-color: transparent!important;
                border-bottom: 1px solid #D0D0D0!important;
                font-size: 19px!important;
                font-weight: normal!important;
                margin: 0 0 14px 0!important;
                padding: 14px 15px 10px 15px!important;
        }
        
        div#all {
                /*text-align:left!important;*/
                width : 1050px!important;
                margin : auto;
                background-color : #FFFFFF!important;
                padding : 10px;
        }
        
        div#header {
                width : 1000px!important;
        }
        
        div#nav_account {
                overflow : auto!important;
                padding: 10px 10px 10px 10px!important;
                text-align: right!important;
                width : 1000px!important;
        }
        
        div#center {                
                height : 400px!important;
                padding-left : 250px!important;
                padding-right : 0px!important;
                width : 750px!important;
        }
        
        div#nav_menu {
                position : absolute!important;
                z-index : 100!important;                
                width : 250px!important;
                overflow : auto!important;
                height : 400px!important;
        }
        
        .content {
                overflow : auto!important; 
                height : 100%!important;
                width : 730px!important;
                border : 1px solid #D0D0D0!important;
                padding : 10px!important;
        }
        
        div#footer {
                text-align : center!important;
                font-size: 10px!important;
                width : 1000px!important;
        }
        
        
                
        .center {
                text-align : center!important;
        }
        .right {
                text-align : right!important;
        }

        code {
                font-family: Consolas, Monaco, Courier New, Courier, monospace!important;
                font-size: 12px!important;
                background-color: #f9f9f9!important;
                border: 1px solid #D0D0D0!important;
                color: #002166!important;
                display: block!important;
                margin: 14px 0 14px 0!important;
                padding: 12px 10px 12px 10px!important;
        }

        
        p.footer{
                text-align: right!important;
                font-size: 11px!important;
                border-top: 1px solid #D0D0D0!important;
                line-height: 32px!important;
                padding: 0 10px 0 10px!important;
                margin: 20px 0 0 0!important;
        }
        
        #loginForm{
                display: inline-block!important;
                width : 600px!important;
        }
        
        
</style>
<?php echo $meta ?>
<script type="text/javascript">
    
  function show_div(){
    $('iframe.content').hide();
    $('div.content').show();
  }
  function show_iframe(){
    $('div.content').hide();
    $('iframe.content').show();
  }
  
  $(document).ready(function(){
    //make treeview
    $('#nav_menu ul').treeview();
    //show div
    show_div();
    
    //show div or iframe depend on link clicked
    $('a[target="_SELF"]').click(show_div);
    $('a[target="content"]').click(show_iframe);

  });
</script>