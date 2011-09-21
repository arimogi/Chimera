<!DOCTYPE html>

  <?php echo $include; ?>
  <script type="text/javascript">
      Ext.require('Seed.PersistenceGrid');
      var mod_module = null;
      var mod_privilege = null;

      Ext.onReady(function(){
          mod_module = Ext.create('Seed.PersistenceGrid',{
              y : 0,
              x : 0,
              fields : [
                  'id', 'menu', 'module'],
              data : [
                  {
                      id : 1,
                      menu : 'welcome',
                      module : 'welcome/index'
                  },
                  {
                      id : 2,
                      menu : 'blog',
                      module : 'blog/posts'
                  }
              ],
              editor : [
                  {
                      header : 'Code',
                      dataIndex : 'id',
                      view : 1, edit : 0, add :0, search : 0,
                      xtype : 'textfield',
                      width : 50
                  },
                  {
                      header : 'Menu Path',
                      dataIndex : 'menu',
                      view : 1, edit : 1, add :1, search : 1,
                      xtype : 'textfield',
                      width : 100
                  },
                  {
                      header : 'Module',
                      dataIndex : 'module',
                      view : 1, edit : 1, add :1,
                      xtype : 'textfield',
                      width : 100
                  }
              ],
              keyColumn : 'id'                
          });
          
          
          mod_privilege = Ext.create('Seed.PersistenceGrid',{
              y : 200,
              x : 0,
              fields : ['id', 'group_id', 'module_id'],
              data : [
                  {
                      id : 1,
                      group_id : 1,
                      module_id : 1
                  },
                  {
                      id : 2,
                      group_id : 1,
                      module_id : 2
                  },
                  {
                      id : 3,
                      group_id : 2,
                      module_id : 1
                  }
              ],
              editor : [
                  {
                      header : 'Code',
                      dataIndex : 'id',
                      view : 1, edit : 0, add : 0,
                      xtype : 'textfield',
                      width : 50
                  },
                  {
                      header : 'Group Code',
                      dataIndex : 'group_id',
                      view : 1, edit : 1, add : 1, search : 1,
                      xtype : 'textfield',
                      width : 80
                  },
                  {
                      header : 'Module Code',
                      dataIndex : 'module_id',
                      view : 1, edit : 1, add : 1,
                      xtype : 'textfield',
                      width : 80
                  }
              ]
          });
          
          
          mod_module.on('addData', function(newData, masterData){
            $.ajax({
              url : 'index.php/lab/module/add',
              async : true,
              type: 'POST',
              data : {
                newData : newData,
                masterData : masterData
              },
              success : function(response){
                alert(response);
              },
              error : function(response){
                alert(response);
              }
            });
          });
          mod_module.on('editData', function(key, newData, masterData){
            $.ajax({
              url : 'index.php/lab/module/edit',
              async : true,
              type: 'POST',
              data : {
                key : key,
                newData : newData,
                masterData : masterData
              },
              success : function(response){
                alert(response);
              },
              error : function(response){
                alert(response);
              }
            });
          });
          mod_module.on('deleteData', function(key){
            $.ajax({
              url : 'index.php/lab/module/delete',
              async : true,
              type: 'POST',
              data : {
                key : key
              },
              success : function(response){
                alert(response);
              },
              error : function(response){
                alert(response);
              }
            });
          });
          mod_module.on('viewData', function(searchData, masterData){
            $.ajax({
              url : 'index.php/lab/module/view',
              async : true,
              type: 'POST',
              data : {
                searchData : searchData,
                masterData : masterData
              },
              success : function(response){
                alert(response);
              },
              error : function(response){
                alert(response);
              }
            });
          });
          mod_module.on('rowChange', function(){
            alert('rowChanged');
          });
          mod_module.show();
          mod_privilege.show();
          
          
          
      });

      Ext.EventManager.on(window, 'beforeunload', function() {
          Ext.destroy(mod_module);
          Ext.destroy(mod_privilege);
          Ext.destroy(this.el);
      });
      
  </script>
