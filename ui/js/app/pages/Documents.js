
var Documents = {
	init : function () {
		var that = this;

		this.handlers.parent = null;
		this.actions.parent = null;
		this.interface.parent = null;

		this.interface.initJstree();

		this.actions.getTreeData(function(data) {
			console.log(data);

			if (typeof data.error == "undefined" &&
				typeof data.data !== "undefined") {
				that.interface.setTreeData(data.data);
			} else {
				App.message.show("Ошибка", "Ошибка построения дерева документов");
			}
		});
	},


	handlers : {
		parent : null
	},

	actions : {
		parent : null,

		getTreeData : function (callback) {
			this.sendRequest({
				"action" : "getTreeData"
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
					// Rules for packages
					if ((node.type == "package_incoming" ||
						node.type == "package_managing") && 
						(node_parent.type == "package_managing_list" ||
						node_parent.type == "package_incoming_list")) {
						return true;
					}

					// Rules for documents
					if ((node.type == "file" ||
						node.type == "new") && 
						(node_parent.type == "package_incoming" ||
						node_parent.type == "package_managing")) {
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
							
						}
            		};
            	}

            	if (node.type == "package_incoming" ||
            		node.type == "package_managing") {
            		items.delete = {
            			"label"	 : "Удалить",
						"action" : function (data) {
							var inst = $.jstree.reference(data.reference),
								obj = inst.get_node(data.reference);
							
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