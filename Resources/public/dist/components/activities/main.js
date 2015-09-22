define(["text!suluactivity/components/activities/activity.form.html","widget-groups","suluactivity/model/activity","config","sulucontact/model/contact","sulucontact/model/account"],function(a,b,c,d,e,f){"use strict";var g={overlayId:"activitiesOverlay",activityListSelector:"#activities-list",activityFormSelector:"#acitivity-form",activitiesURL:"/admin/api/activities/"},h=function(){return[{id:"add",icon:"plus-circle","class":"highlight",title:"add",position:10,callback:this.addOrEditActivity.bind(this)},{id:"settings",icon:"gear",dropdownItems:[{id:"delete",title:this.sandbox.translate("contact.activities.remove"),callback:function(){this.sandbox.emit("husky.datagrid.items.get-selected",function(a){a.length>0&&this.removeActivities(a)}.bind(this))}.bind(this),disabled:!0}]}]};return{view:!0,layout:function(){return{content:{width:"fixed"},sidebar:{width:"max",cssClasses:"sidebar-padding-50"}}},templates:["/admin/activity/template/contact/activities"],initialize:function(){this.getSystemMembers().then(function(){this.initTypeDependentVariables(this.options.type),this.dfdEntityLoaded=this.sandbox.data.deferred(),this.loadEntity(),this.sandbox.dom.when(this.dfdEntityLoaded).then(function(){this.bindCustomEvents(),this.render(),b.exists(this.options.widgetGroup)&&this.initSidebar(this.options.widgetGroup,this.options.id)}.bind(this))}.bind(this))},loadEntity:function(){this.entity.fetch({success:function(a){this.model=a.toJSON(),this.dfdEntityLoaded.resolve()}.bind(this),error:function(){this.sandbox.logger.log("error while fetching "+this.options.type),this.dfdEntityLoaded.reject()}.bind(this)})},initTypeDependentVariables:function(a){switch(a){case"contact":this.breadcrumb=d.get("sulucontact.breadcrumb.contact"),this.entity=new e({id:this.options.id}),this.routeToList=d.get("sulucontact.routeToList.contact");break;case"account":this.breadcrumb=d.get("sulucontact.breadcrumb.account"),this.entity=new f({id:this.options.id}),this.routeToList=d.get("sulucontact.routeToList.account")}},getSystemMembers:function(){return this.sandbox.util.load("api/contacts?bySystem=true").then(function(a){this.responsiblePersons=a._embedded.contacts}.bind(this)).fail(function(a,b){this.sandbox.logger.error(a,b)}.bind(this))},initSidebar:function(a,b){this.sandbox.emit("sulu.sidebar.set-widget","/admin/widget-groups/"+a+"?"+this.options.type+"="+b)},bindCustomEvents:function(){this.sandbox.once("sulu_activity.activities.set-defaults",function(a){var b,c;for(b in a)if(a.hasOwnProperty(b))for(c in a[b])a[b].hasOwnProperty(c)&&(a[b][c].translation=this.sandbox.translate(a[b][c].name));this.activityDefaults=a},this),this.sandbox.on("husky.datagrid.item.click",function(a){this.loadActivity(a)},this),this.sandbox.on("sulu.header.back",function(){this.sandbox.emit("sulu.router.navigate",this.routeToList)},this),this.sandbox.on("husky.overlay.activity-add-edit.opened",function(){this.sandbox.start(g.activityFormSelector);var a=this.sandbox.form.create(g.activityFormSelector);a.initialized.then(function(){this.sandbox.form.setData(g.activityFormSelector,this.overlayData)}.bind(this))}.bind(this)),this.sandbox.on("husky.datagrid.number.selections",function(a){a>0?this.sandbox.emit("husky.toolbar.activities.item.enable","delete",!1):this.sandbox.emit("husky.toolbar.activities.item.disable","delete",!1)}.bind(this))},loadActivity:function(a){a?(this.activity=c.findOrCreate({id:a}),this.activity.fetch({success:function(a){this.activity=a,this.startOverlay(a.toJSON())}.bind(this),error:function(a,b){this.sandbox.logger.log("error while fetching activity",a,b)}.bind(this)})):this.sandbox.logger.warn("no id given to load activity")},setTitle:function(){var a=this.sandbox.translate("contact.contacts.title"),b=this.breadcrumb;if(this.options.id){switch(this.options.type){case"contact":a=this.model.fullName;break;case"account":a=this.model.name}b.push({title:"#"+this.options.id})}this.sandbox.emit("sulu.header.set-title",a),this.sandbox.emit("sulu.header.set-breadcrumb",b)},addOrEditActivity:function(a){a?this.loadActivity(a):this.startOverlay(null)},startOverlay:function(b){var c,d,e,f;this.sandbox.dom.remove("#"+g.overlayId),e=this.sandbox.dom.createElement('<div id="'+g.overlayId+'"></div>'),this.sandbox.dom.append(g.activityListSelector,e),this.overlayData=b,c=b&&b.id?this.sandbox.translate("contact.contacts.activities.edit"):this.sandbox.translate("contact.contacts.activities.add"),f={activityType:b&&b.activityType?b.activityType.id:"",activityStatus:b&&b.activityStatus?b.activityStatus.id:"",activityPriority:b&&b.activityPriority?b.activityPriority.id:"",assignedContact:b&&b.assignedContact?b.assignedContact.id:"",activityTypes:this.activityDefaults.activityTypes,activityPriorities:this.activityDefaults.activityPriorities,activityStatuses:this.activityDefaults.activityStatuses,responsiblePersons:this.responsiblePersons,translate:this.sandbox.translate},d=this.sandbox.util.template(a,f),this.sandbox.start([{name:"overlay@husky",options:{el:e,title:c,openOnStart:!0,removeOnClose:!0,instanceName:"activity-add-edit",data:d,skin:"wide",okCallback:this.editAddOkClicked.bind(this),closeCallback:this.stopOverlayComponents.bind(this)}}])},stopOverlayComponents:function(){this.sandbox.stop(g.activityFormSelector)},editAddOkClicked:function(){if(!this.sandbox.form.validate(g.activityFormSelector,!0))return!1;var a=this.sandbox.form.getData(g.activityFormSelector);this.isContact()&&!a.contact&&(a.contact={id:this.options.id}),this.isAccount()&&!a.account&&(a.account={id:this.options.id}),a.id||delete a.id,this.save(a),this.stopOverlayComponents()},save:function(a){var b=!0;a.id&&(b=!1),this.activity=c.findOrCreate({id:a.id}),this.activity.set(a),this.activity.save(null,{success:function(a){this.activity=this.flattenActivityObjects(a.toJSON()),this.activity.assignedContact=this.activity.assignedContact.fullName,b?this.sandbox.emit("husky.datagrid.record.add",this.activity):this.sandbox.emit("husky.datagrid.records.change",this.activity)}.bind(this),error:function(){this.sandbox.logger.log("error while saving activity")}.bind(this)})},flattenActivityObjects:function(a){return a.activityStatus&&(a.activityStatus=this.sandbox.translate(a.activityStatus.name)),a.activityType&&(a.activityType=this.sandbox.translate(a.activityType.name)),a.activityPriority&&(a.activityPriority=this.sandbox.translate(a.activityPriority.name)),a},render:function(){var a;this.sandbox.dom.html(this.$el,this.renderTemplate("/admin/activity/template/contact/activities")),this.setTitle(),a="/admin/api/activities?sortBy=dueDate&sortOrder=asc&flat=true&"+this.options.type+"="+this.options.id,this.sandbox.sulu.initListToolbarAndList.call(this,"activitiesContactsFields","/admin/api/activities/fields",{el:this.$find("#list-toolbar-container"),instanceName:"activities",inHeader:!0,template:h.call(this)},{el:this.sandbox.dom.find("#activities-list",this.$el),url:a,searchInstanceName:"activities",searchFields:["subject"],resultKey:"activities",viewOptions:{table:{selectItem:{type:"checkbox"},removeRow:!1}}})},removeActivities:function(a){this.confirmDeleteDialog(function(b){if(b){var d;this.sandbox.util.foreach(a,function(a){d=c.findOrCreate({id:a}),d.destroy({success:function(){this.sandbox.emit("husky.datagrid.record.remove",a)}.bind(this),error:function(){this.sandbox.logger.log("error while deleting activity")}.bind(this)})}.bind(this))}}.bind(this))},isAccount:function(){return"account"===this.options.type},isContact:function(){return"contact"===this.options.type},confirmDeleteDialog:function(a){if(a&&"function"!=typeof a)throw"callback is not a function";this.sandbox.emit("sulu.overlay.show-warning","sulu.overlay.be-careful","sulu.overlay.delete-desc",function(){a(!1)}.bind(this),function(){a(!0)}.bind(this))}}});