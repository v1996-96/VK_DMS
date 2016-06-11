
var Documents = {
	init : function () {
		var that = this;

		this.handlers.parent = this;
		this.actions.parent = this;
		this.interface.parent = this;

		this.interface.initJstree();

		this.actions.getTreeData(function(data) {
			if (typeof data.error == "undefined" &&
				typeof data.data !== "undefined") {
				that.interface.setTreeData(data.data);
			} else {
				App.message.show("Ошибка", "Ошибка построения дерева документов");
			}
		});

		this.handlers.setRenameHandler();
		this.handlers.setDeleteHandler();
		this.handlers.setMoveHandler();
	},


	moveBuffer : {
		node : null,
		node_parent : null
	},


	handlers : {
		parent : null,

		setRenameHandler : function () {
			var that = this;

			$("#companyList").on("rename_node.jstree", function(e, obj) {
				that.parent.actions.editPackage(obj.node.id.substr(5), obj.node.text, function (response){
					console.log(response);
				});
			});
		},

		setDeleteHandler : function () {
			var that = this;

			$("#companyList").on("delete_node.jstree", function(e, obj) {
				if (obj.node.type == "package_incoming" ||
            		obj.node.type == "package_managing") {
					
					that.parent.actions.deletePackage(obj.node.id.substr(5), function(response) {

					});
				} else return false;
			});
		},

		setMoveHandler : function () {
			var that = this;

			$(document).on("dnd_stop.vakata", function(e, obj) {
				console.log(obj);
			});
		}
	},

	actions : {
		parent : null,

		getTreeData : function (callback) {
			this.sendRequest({
				"action" : "getTreeData"
			}, callback);
		},

		createPackage : function (text, parentId, callback) {			
			this.sendRequest({
				"action" : "createPackage",
				"Title" : text,
				"DepartmentId" : parentId
			}, callback);
		},

		editPackage : function (id, text, callback) {
			this.sendRequest({
				"action" : "editPackage",
				"PackageId" : id,
				"Title" : text
			}, callback);
		},

		deletePackage : function (id, callback) {
			this.sendRequest({
				"action" : "deletePackage",
				"PackageId" : id
			}, callback);
		},

		sendRequest : function(requestData, callback, errorCallback) {
			var errorCallback = errorCallback || function(){};

			$.ajax({
				type : "POST", url : "",
				data : requestData,
				success : function (data) {
					try {
						var response = JSON.parse(data);
						if (typeof response.error !== "undefined" ) {
							console.log(response.error);
							throw {};
						}

						callback(response);
					} catch(e) {
						console.log(e);
						App.message.show("Ошибка", "Ошибка обработки запроса", "error");
						errorCallback(data);
					}
				},
				error : function (data) {
					App.message.show("Ошибка", "Ошибка обработки запроса", "error");
					errorCallback(data);
				}
			});
		}
	},

	interface : {
		parent : null,

		initJstree : function () {

			var that = this;

			$.jstree.defaults.core.check_callback = function (operation, node, node_parent, node_position, more) {
				if (operation == "move_node") {
					return false;

					// Rules for packages
					if ((node.type == "package_incoming" ||
						node.type == "package_managing") && 
						(node_parent.type == "package_managing_list" ||
						node_parent.type == "package_incoming_list")) {

						that.parent.moveBuffer.node = node;
						that.parent.moveBuffer.node_parent = node_parent;
						return true;
					}

					// Rules for documents
					if ((node.type == "file" ||
						node.type == "new") && 
						(node_parent.type == "package_incoming" ||
						node_parent.type == "package_managing")) {

						that.parent.moveBuffer.node = node;
						that.parent.moveBuffer.node_parent = node_parent;
						return true;
					}

					return false;
				}

				return true;
			}
			$.jstree.defaults.core.multiple = false;
			$.jstree.defaults.plugins = [ "dnd", "search", "types", "contextmenu" ];
			$.jstree.defaults.types = {
                'department' : { 'icon' : 'fa fa-cubes' },

                'package_managing_list' : { 'icon' : 'fa fa-folder' },
                'package_incoming_list' : { 'icon' : 'fa fa-download' },
                'files_unmanaged_list' : { 'icon' : 'fa fa-database' },

                'package_incoming' : { 'icon' : 'fa fa-download' },
                'package_managing' : { 'icon' : 'fa fa-folder' },

                'file' : { 'icon' : 'fa fa-file-o' },
                'new' : { 'icon' : 'fa fa-plus' },
                'deleted' : { 'icon' : 'fa fa-minus' },

                'unknown' : { 'icon' : '' }
            }

            /* DND plugin */
            $.jstree.defaults.dnd.copy = false;
            $.jstree.defaults.dnd.drag_selection = false;
            $.jstree.defaults.dnd.is_draggable = function(elements) {
            	for (var i = 0; i < elements.length; i++) {
            		if (elements[i].type == "department" ||
            			elements[i].type == "package_managing_list" ||
            			elements[i].type == "package_incoming_list" ||
            			elements[i].type == "files_unmanaged_list" ||
            			elements[i].type == "unknown") {
            			return false;
            		}
            	}

            	return true;
            }

            /* Contextmenu plugin */
            $.jstree.defaults.contextmenu.items = function( node ) {
            	var items = {};
            	
            	if (node.type == "package_managing_list") {
            		items.add = {
						"label"	 : "Создать пакет документов",
						"action" : function (data) {
							var inst = $.jstree.reference(data.reference),
								obj = inst.get_node(data.reference);
							inst.create_node(obj, {
								"text" : "Новый пакет документов",
								"type" : "package_managing"
							}, "last", function (item) {
								that.parent.actions.createPackage(
									item.text, obj.id.substr(16), 
									function (response) {
										if (typeof response.id !== "undefined") {
											$("#companyList").jstree(true).set_id(item, response.id);
										}
									}
								);
								return true;
							});
						}
            		};
            	}

            	if (node.type == "package_incoming" ||
            		node.type == "package_managing") {
            		items.rename = {
						"label"				: "Переименовать",
						"action"			: function (data) {
							var inst = $.jstree.reference(data.reference),
								obj = inst.get_node(data.reference);
							inst.edit(obj);
						}
            		}
            		items.delete = {
            			"label"	 : "Удалить",
						"action" : function (data) {
							var inst = $.jstree.reference(data.reference),
								obj = inst.get_node(data.reference);
							if(inst.is_selected(obj)) {
								inst.delete_node(inst.get_selected());
							} else {
								inst.delete_node(obj);
							}
						}
            		};
            	}

            	if ((node.type == "file" ||
            		node.type == "new" ||
            		node.type == "deleted") &&
            		node.parents[0].indexOf("files_unmanaged") < 0) {
            		items.delete = {
            			"label"	 : "Удалить из пакета",
						"action" : function (data) {
							var inst = $.jstree.reference(data.reference),
								obj = inst.get_node(data.reference);
							
						}
            		}
            	}

            	if (node.type == "deleted") {
            		items.deleteFull = {
            			"label"	 : "Удалить из базы",
						"action" : function (data) {
							var inst = $.jstree.reference(data.reference),
								obj = inst.get_node(data.reference);
							
						}
            		};
            	}

            	if (node.type == "file" ||
            		node.type == "new") {
            		items.download = {
						"label"	 : "Скачать",
						"action" : function (data) {
							var inst = $.jstree.reference(data.reference),
								obj = inst.get_node(data.reference);
							
							if (typeof obj.li_attr["data-url"] !== "undefined") 
								window.open(obj.li_attr["data-url"], "_blank");
						}
            		};
            	}

            	return items;
            }

			$("#companyList").jstree();
		},

		setTreeData : function (data) {
			var instance = $("#companyList").jstree(true);
			instance.settings.core.data = data;
			instance.refresh(true);
		}
	}
}



$(document).ready(function() {

	Documents.init();

});