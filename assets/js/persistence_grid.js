Ext.define('Seed.PersistenceGrid',{
    extend      : 'Ext.Window',
    
    //Dari parent
    alias       : 'seedgrid',
    height      : 200,
    width       : 700,
    border      : false,
    draggable   : false,
    closable    : false,
    resizable   : false,
    layout      : {
        type        : 'hbox',
        align       : 'stretch'
    },    

    //Konfigurasi punya sendiri (private)
    keyValue    : '',
    masterValue : new Array(),
    mode        : 0, // 0 ga ngapa2in, 1 insert, 2 update
    pageSize    : 25,
    
    //Konfigurasi punya sendiri (read only, diatur via config)
    panelWidth      : 300,
    defaultLabelWidth : 100,
    keyColumn       : 'id',
    masterColumn    : new Array(),
    detailGrids     : new Array(),

    data            : null, //harus didefinisikan oleh developer
    editor          : null, //harus didefinisikan oleh developer
    proxy           : null,
    proxyType       : 'memory', //atau ajax
    proxyUrl        : 'data.json',
    proxyRoot       : 'data',
    proxyTotalProperty  : 'total',


    //private functions
    getSearchColumnName : function(){
        var items = this.getEditor();
        var result = new Array();
        var index = 0;
        for(var i=0; i<items.length; i++){
            if(items[i].search){
                result[index] = items[i].dataIndex;
                index++;
            }
        }
        return result;
    },
    getAddColumnName : function(){
        var items = this.getEditor();
        var result = new Array();
        var index = 0;
        for(var i=0; i<items.length; i++){
            if(items[i].add){
                result[index] = items[i].dataIndex;
                index++;
            }
        }
        return result;
    },
    getEditColumnName : function(){
        var items = this.getEditor();
        var result = new Array();
        var index = 0;
        for(var i=0; i<items.length; i++){
            if(items[i].edit){
                result[index] = items[i].dataIndex;
                index++;
            }
        }
        return result;
    },
    buildFields : function(){
        var items = this.getEditor();
        var result = new Array();
        for (var i = 0; i<items.length; i++){
            result[i] = items[i].dataIndex;
        }
        return result;
    },
    buildEditorForSearch : function(){
        var items = this.getEditor();
        var result = new Array();
        var index = 0;
        for (var i = 0; i<items.length; i++){
            if(items[i].search == 1){
                result[3*index] = new Object();
                result[3*index].fieldLabel = "";
                result[3*index].checked = true;
                result[3*index].itemId = "filterby_"+items[i].dataIndex;
                result[3*index].name = "filterby_"+items[i].dataIndex;
                result[3*index].xtype = "checkbox";
                
                result[3*index+1] = new Object();
                result[3*index+1].fieldLabel = items[i].header;
                result[3*index+1].itemId = "filter_"+items[i].dataIndex;
                result[3*index+1].name = "filter_"+items[i].dataIndex;
                result[3*index+1].xtype = items[i].xtype;

                result[3*index+2] = new Object();
                result[3*index+2].xtype = "tbspacer";
                result[3*index+2].height = 10;
                
                index++;
            }
        }
        return result;
    },
    buildEditorForAdd : function(){
        var items = this.getEditor();
        var result = new Array();
        var index = 0;
        for (var i = 0; i<items.length; i++){
            if(items[i].add == 1){
                result[index] = new Object();
                result[index].fieldLabel = items[i].header;
                result[index].itemId = "add_"+items[i].dataIndex;
                result[index].name = "add_"+items[i].dataIndex;
                result[index].xtype = items[i].xtype;
                index++;
            }
        }
        return result;
    },
    buildEditorForEdit : function(){
        var items = this.getEditor();
        var result = new Array();
        var index = 0;
        for (var i = 0; i<items.length; i++){
            if(items[i].edit == 1){
                result[index] = new Object();
                result[index].fieldLabel = items[i].header;
                result[index].itemId = "edit_"+items[i].dataIndex;
                result[index].name = "edit_"+items[i].dataIndex;
                result[index].xtype = items[i].xtype;
                index++;
            }
        }
        return result;
    },
    buildColumns : function(){
        var items = this.getEditor();
        var result = new Array();
        var index = 0;
        for (var i = 0; i<items.length; i++){
            if(items[i].view == 1){
                result[index] = new Object();
                result[index].header = items[i].header;
                result[index].dataIndex = items[i].dataIndex;
                result[index].width = items[i].width;
                result[index].renderer = items[i].renderer;
                result[index].flex = items[i].flex;
                index++;
            }
        }
        return result;
    },
    buildTabItems : function(){
        return [
            {
                xtype       : 'form',
                title       : 'Edit',
                itemId      : 'panelEdit',
                defaultType : 'textfield',
                padding     : 10,
                items       : this.buildEditorForEdit(),
                defaults    : {
                    anchor      : '-10',
                    labelWidth  : this.getDefaultLabelWidth()
                }                
            },
            {
                xtype       : 'form',
                title       : 'Add',
                itemId      : 'panelAdd',
                defaultType : 'textfield',
                padding     : 10,
                items       : this.buildEditorForAdd(),
                defaults    : {
                    anchor      : '-10',
                    labelWidth  : this.getDefaultLabelWidth()
                }                
            },
            {
                xtype       : 'panel',
                title       : 'Search',
                itemId      : 'panelSearch',
                defaultType : 'textfield',
                padding     : 10,
                items       : this.buildEditorForSearch(),
                defaults    : {
                    anchor      : '-10',
                    labelWidth  : this.getDefaultLabelWidth()
                }
            }
        ];
    },    
    buildStore : function(){
        return Ext.create('Ext.data.Store', {
            id          : 'store',
            autoLoad    : false,
            fields      : this.buildFields(),
            pageSize    : this.pageSize, // items per page
            data        : this.getData(),
            proxy       : this.getProxy()
        });
    },
    buildItems : function(){
        var theStore = this.buildStore();
        return [
            {
                xtype       : 'grid',
                flex        : 1,
                itemId      : 'dataGrid',
                features    : [{
                    ftype       : 'grouping'
                }],
                store       : theStore,
                columns     : this.buildColumns(),
                listeners   : {
                    scope     : this
                },
                bbar: new Ext.PagingToolbar({
                    pageSize: this.pageSize,
                    store: theStore
                })
            },
            {
                xtype       : 'tabpanel',
                itemId      : 'tabPanel',
                items       : this.buildTabItems(),
                width       : this.getPanelWidth(),
                activeTab   : 1,
                listeners   : {
                    scope       : this,
                    tabchange   : this.onTabChange
                }                
            }
        ];
    },
    buildButtons : function(){
        return [
            {
                text    : 'Save',
                scope   : this,
                handler : this.onSaveClick
            },
            {
                text    : 'New',
                scope   : this,
                handler : this.onNewClick
            },
            {
                text    : 'Refresh',
                scope   : this,
                handler : this.onRefreshClick
            },
            {xtype: 'tbspacer', width : 30},
            {
                text    : 'Delete',
                scope   : this,
                handler : this.onDeleteClick
            }
        ];
    },
    constructor: function(){        
        this.callParent(arguments);
    },
    initComponent : function(){
        this.items = this.buildItems();
        this.buttons = this.buildButtons();

        this.callParent();

        this.getComponent('dataGrid').getSelectionModel().on('selectionchange',
            this.onSelectionChange, this);

        //EVENT tambahan
        this.addEvents('viewData', 'addData', 'editData', 'deleteData', 'rowChange');
    },
    locate : function (name, value) {
        var dataGrid = this.getComponent('dataGrid');
        dataGrid.getSelectionModel().select(dataGrid.getStore().find(name, value));
        
        this.fireEvent('rowChange',this);
    },
    onTabChange: function(tabPanel, newCard, oldCard){
        //alert('tabChange');
        var panelId = tabPanel.getActiveTab().getItemId();
        if(panelId == 'panelEdit' ){
            if(this.keyValue == '' || this.keyValue == null || typeof(this.keyValue) == 'undefined'){
                tabPanel.setActiveTab(1);
            }
            else{
                this.mode = 2;
            }
        }
        else if (panelId == 'panelAdd'){
            this.mode = 1;
        }
        else if (panelId == 'panelSearch'){
            this.mode = 0;
        }
    },
    onSelectionChange : function(sm, selected){
        if(selected.length>0){
            var tabPanel = this.getComponent('tabPanel');
            var panelEdit = tabPanel.getComponent('panelEdit');
            //panelEdit.loadRecord(selected[0]);
            var editColumnName = this.getEditColumnName();
            for(var i=0; i<editColumnName.length; i++){
                var value = selected[0].data[editColumnName[i]];
                var editor = panelEdit.getComponent('edit_'+editColumnName[i]);
                editor.setValue(value);
            }

            //ubah keyColumn
            var rec = selected[0].data
            this.keyValue = rec[this.getKeyColumn()];
            
            this.fireEvent('rowChange',this);
            
            //arahkan ke tab ke panelEdit
           tabPanel.setActiveTab(0);
        }
    },
    onSaveClick : function(){
        if(this.mode == 0){
            //alert('no change');
        }
        else if(this.mode == 1){
            this.fireEvent('addData', this.getAddData(), this.getMaster());
            this.onRefreshClick();
        }
        else if(this.mode == 2){
            this.fireEvent('editData', this.keyValue, this.getEditData(), this.getMaster());
            this.onRefreshClick();
        }
    },
    onDeleteClick : function(){
        //alert('delete '+this.keyValue);
        this.fireEvent('deleteData', this.keyValue);
        this.onRefreshClick();
    },
    onRefreshClick : function(){
        //reload the data        
        var dataGrid = this.getComponent('dataGrid');
        var store = dataGrid.getStore();
        store.load({
            scope   : this,
            //method : 'POST',            
            params  : {
                "request" : "coba"
            },
            callback: function(records, operation, success) {
                this.locate(this.getKeyColumn(), this.keyValue);
            }
        });
        
    },
    onNewClick : function(){
        var tabPanel = this.getComponent('tabPanel');
        tabPanel.setActiveTab(1);
    },
    getPanelWidth      : function(){return this.panelWidth},
    getDefaultLabelWidth : function(){return this.defaultLabelWidth},
    getKeyColumn       : function(){return this.keyColumn},
    getData            : function(){return this.data},
    getEditor          : function(){return this.editor},
    getProxy           : function(){
        if(typeof(this.proxy) == 'undefined'){
            if(this.proxyType == 'ajax'){
                this.proxy = {
                    type        : 'ajax',
                    url         : this.proxyUrl,  // url that will load data with respect to start and limit params
                    reader      : {
                        type            : 'json',
                        root            : this.proxyRoot,
                        totalProperty   : this.proxyTotalProperty
                    }
                }
            }else{
                this.proxy = {
                    itemId          : 'proxy',
                    type            : 'memory',
                    reader          : {
                        type            : 'json',
                        root            : 'data'
                    }
                }
            }
            
        }
        return this.proxy
    },
    getSearchData : function(){
        var tabPanel = this.getComponent('tabPanel');
        var panelSearch = tabPanel.getComponent('panelSearch');
        var searchColumnName = this.getSearchColumnName();
        var result = new Object();
        for(var i=0; i<searchColumnName.length; i++){
            var checkbox = panelSearch.getComponent("filterby_"+
                searchColumnName[i]);
            if(checkbox.getValue()){
                var editor = panelSearch.getComponent("filter_"+
                    searchColumnName[i]);
                result[searchColumnName[i]] = editor.getValue();
            }
        }
        return result;
    },
    getAddData : function(){
        var tabPanel = this.getComponent('tabPanel');
        var panelAdd = tabPanel.getComponent('panelAdd');
        var addColumnName = this.getAddColumnName();
        var result = new Object();
        for(var i=0; i<addColumnName.length; i++){
            var editor = panelAdd.getComponent("add_"+
                addColumnName[i]);
            result[addColumnName[i]] = editor.getValue();
        }
        return result;
    },
    getEditData : function(){
        var tabPanel = this.getComponent('tabPanel');
        var panelEdit = tabPanel.getComponent('panelEdit');
        var editColumnName = this.getEditColumnName();
        var result = new Object();
        for(var i=0; i<editColumnName.length; i++){
            var editor = panelEdit.getComponent("edit_"+
                editColumnName[i]);
            result[editColumnName[i]] = editor.getValue();
        }
        return result;
    },
    getMaster : function(){
        return this.masterValue;
    },
    setMasterValue : function(masterColumn, value){
        this.masterValue[masterColumn] = value;
    },
    addDetailGrid : function(grid){
        this.detailGrids[detailGrids.length] = grid;
    },
    setDetailGrid : function(grids){
        this.detailGrids = grids;
    }


});

/**
 * getData :
 *  filter, master
 * addData :
 *  new, master
 * editData :
 *  key, new, master
 * deleteData :
 *  key
 */