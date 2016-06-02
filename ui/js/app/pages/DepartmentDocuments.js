/**
 * Department documents scripts
 */

var Documents = {
	init : function () {
		this.handlers.parent = this;
		this.actions.parent = this;
		this.interface.parent = this;

		this.interface.runJsTree();
		this.handlers.setSyncHandler();
		this.handlers.setAddPackageHandler();
		this.handlers.setRenamePackageHandler();
		this.handlers.setDocumentMoveHandler();
		this.handlers.setDeleteHandler();
		this.handlers.setDeleteNotmanagedHandler();
		// this.handlers.setControlsShowHandlers();
		// this.handlers.setControlsHandlers();

		this.actions.getDocuments();
		this.actions.getPackages();
	},


	documentMove : {
		node : null,
		node_parent : null
	},

	
	handlers : {
		parent : null,

		setSyncHandler : function () {
			var that = this;

			$("#syncDocuments").on("click", function(e){
				e.preventDefault();

				var groupId = $(this).attr("data-group-id");

				App.getDocumentList(groupId, that.syncHandler);
			});
		},

		setAddPackageHandler : function () {
			var that = this;

			$("#addPackageBtn").on("click", function(e){
				e.preventDefault();

				var tree = $("#managedDocuments").jstree(true);
				var newNode = tree.create_node(null, {
					"text" : "Новый пакет документов",
					"type" : "package"
				}, "last", that.parent.actions.createPackage);
			});
		},

		setRenamePackageHandler : function () {
			var that = this;

			$("#managedDocuments").on("rename_node.jstree", function(e, obj) {
				that.parent.actions.editPackage(obj.node);
			});
		},

		setDocumentMoveHandler : function () {
			var that = this;

			$(document).on("dnd_stop.vakata", function(e, obj) {

				var node = that.parent.documentMove.node;
				var node_parent = that.parent.documentMove.node_parent;

				if (node !== null &&
					node_parent !== null &&
					node_parent.type == "package" &&
					node.id == obj.data.obj[0].id) {

					$("#managedDocuments").jstree(true).set_type(node, "file");
					$("#managedDocuments").jstree(true).refresh_node(node);
					$("#managedDocuments").jstree(true).open_node(node_parent);

					that.parent.actions.moveDocument(node.id, node_parent.id);
				}
			});
		},

		setDeleteHandler : function () {
			var that = this;

			$("#managedDocuments").on("delete_node.jstree", function(e, obj) {
				
				if (obj.node.type == "package") {
					for (var i = 0; i < obj.node.children.length; i++) {
						var node = $("#managedDocuments").jstree(true).get_node(obj.node.children[i]);
						$("#notmanagedDocuments").jstree(true).create_node("#", node);
					}

					that.parent.actions.deletePackage(obj.node);
				}

				if (obj.node.type == "" ||
					obj.node.type == "file" ||
					obj.node.type == "new" ||
					obj.node.type == "deleted" ||
					obj.node.type == "unknown") {

					$("#notmanagedDocuments").jstree(true).create_node("#", obj.node);
					that.parent.actions.deleteFile(obj.node);
				}
			});
		},

		setDeleteNotmanagedHandler : function () {
			var that = this;

			$("#notmanagedDocuments").on("delete_node.jstree", function(e, obj) {
				if (obj.node.type == "deleted") {
					that.parent.actions.clearDeletedDocument( obj.node );
				} else return false;
			});
		},

		setControlsShowHandlers : function () {
			$("#managedDocuments").on("select_node.jstree", function(e, obj) {
				if (obj.node.type == "package") {
					$(".package_info").removeClass("hidden");
				}

				if (obj.node.type == 'file' ||
					obj.node.type == 'new' ||
					obj.node.type == 'deleted' ||
					obj.node.type == 'unknown') {
					$(".file_info").removeClass("hidden");
				}

			});

			$("#managedDocuments").on("deselect_node.jstree", function(e, obj) {
				if (obj.node.type == "package") {
					$(".package_info").addClass("hidden");
				}

				if (obj.node.type == "package" ||
					obj.node.type == 'file' ||
					obj.node.type == 'new' ||
					obj.node.type == 'deleted' ||
					obj.node.type == 'unknown') {
					$(".file_info").addClass("hidden");
				}
			});
		},

		setControlsHandlers : function () {
			$("#deletePack").on("click", function(e){
				e.preventDefault();

				var target = $("#managedDocuments").jstree(true);
				var node = target.get_selected();
				console.log(node);

				// $("#managedDocuments").jstree(true).delete_node(node);
			});

			$("#deleteDocFromPack").on("click", function(e){
				e.preventDefault();

				var target = $("#managedDocuments").jstree(true);
				var node = target.get_selected();
				console.log(node);

				// $("#managedDocuments").jstree(true).delete_node(node);
			});
		},

		syncHandler : function (data) {
			if (typeof data.error !== "undefined") {
				App.message.show("Ошибка", data.error.error_msg, "error");
				return;
			}

			if (typeof data.response == "undefined") {
				App.message.show("Ошибка", "Ошибка синхронизации документов", "error");
				return;
			}

			$.ajax({
				type : "POST",
				url : "",
				data : {
					action : "sync",
					documents : JSON.stringify(data.response)
				},
				success : function (data) {
					try {
						var response = JSON.parse(data);
						
						if (typeof response.error !== "undefined" ) {
							console.log(response.error);
							throw {};
						}

						if (typeof response.documents == "undefined" ) throw {};
						if (typeof response.packages == "undefined" ) throw {};

						$("#managedDocuments").jstree(true).settings.core.data = response.packages;
						$("#managedDocuments").jstree(true).refresh(true);

						$("#notmanagedDocuments").jstree(true).settings.core.data = response.documents;
						$("#notmanagedDocuments").jstree(true).refresh(true);
					} catch(e) {
						App.message.show("Ошибка", "Ошибка синхронизации документов", "error");
					}

					App.message.show("Успех", "Синхронизация прошла успешно", "info");
				},
				error : function (data) {
					App.message.show("Ошибка", "Ошибка синхронизации документов", "error");
				}
			});
		}
	},


	actions : {
		parent : null,

		getDocuments : function () {
			var that = this;

			$.ajax({
				type : "POST", url : "",
				data : {
					action : "getDocuments"
				},
				success : function (data) {
					try {
						var response = JSON.parse(data);
						if (typeof response.error !== "undefined" ) {
							console.log(response.error);
							throw {};
						}

						if (typeof response.documents == "undefined" ) throw {};

						that.parent.interface.renderDocumentsList( response.documents );
					} catch(e) {
						App.message.show("Ошибка", "Ошибка получения документов", "error");
					}
				},
				error : function (data) {
					App.message.show("Ошибка", "Ошибка получения документов", "error");
				}
			});
		},

		getPackages : function () {
			var that = this;

			$.ajax({
				type : "POST", url : "",
				data : {
					action : "getPackages"
				},
				success : function (data) {
					try {
						var response = JSON.parse(data);
						if (typeof response.error !== "undefined" ) {
							console.log(response.error);
							throw {};
						}

						if (typeof response.packages == "undefined" ) throw {};

						that.parent.interface.renderPackageList( response.packages );
					} catch(e) {
						App.message.show("Ошибка", "Ошибка получения пакетов", "error");
					}
				},
				error : function (data) {
					App.message.show("Ошибка", "Ошибка получения пакетов", "error");
				}
			});
		},

		createPackage : function (item) {
			var that = this;

			$.ajax({
				type : "POST", url : "",
				data : {
					action : "createPackage",
					Title : item.text
				},
				success : function (data) {
					try {
						var response = JSON.parse(data);
						if (typeof response.error !== "undefined" ) {
							console.log(response.error);
							throw {};
						}

						if (typeof response.id == "undefined" ) throw {};

						$("#managedDocuments").jstree(true).set_id(item, response.id);
						$("#managedDocuments").jstree(true).edit(item);
					} catch(e) {
						App.message.show("Ошибка", "Ошибка получения пакетов", "error");
					}
				},
				error : function (data) {
					App.message.show("Ошибка", "Ошибка создания пакета", "error");
				}
			});
		},

		editPackage : function (item) {
			var that = this;

			$.ajax({
				type : "POST", url : "",
				data : {
					action : "editPackage",
					Title : item.text,
					PackageId : item.id.substr(5)
				},
				success : function (data) {
					try {
						var response = JSON.parse(data);
						if (typeof response.error !== "undefined" ) {
							console.log(response.error);
							throw {};
						}
					} catch(e) {
						App.message.show("Ошибка", "Ошибка получения пакетов", "error");
					}
				},
				error : function (data) {
					App.message.show("Ошибка", "Ошибка создания пакета", "error");
				}
			});
		},

		deletePackage : function (item) {
			var that = this;

			$.ajax({
				type : "POST", url : "",
				data : {
					action : "deletePackage",
					PackageId : item.id.substr(5)
				},
				success : function (data) {
					try {
						var response = JSON.parse(data);
						if (typeof response.error !== "undefined" ) {
							console.log(response.error);
							throw {};
						}
					} catch(e) {
						App.message.show("Ошибка", "Ошибка получения пакетов", "error");
					}
				},
				error : function (data) {
					App.message.show("Ошибка", "Ошибка создания пакета", "error");
				}
			});
		},

		deleteFile : function (item) {
			var that = this;

			$.ajax({
				type : "POST", url : "",
				data : {
					action : "deleteDocumentFromPackage",
					DocumentId : item.id.substr(4)
				},
				success : function (data) {
					try {
						var response = JSON.parse(data);
						if (typeof response.error !== "undefined" ) {
							console.log(response.error);
							throw {};
						}
					} catch(e) {
						App.message.show("Ошибка", "Ошибка получения пакетов", "error");
					}
				},
				error : function (data) {
					App.message.show("Ошибка", "Ошибка создания пакета", "error");
				}
			});
		},

		moveDocument : function(docId, packId) {
			var that = this;

			$.ajax({
				type : "POST", url : "",
				data : {
					action : "addDocumentToPackage",
					DocumentId : docId.substr(4),
					PackageId : packId.substr(5)
				},
				success : function (data) {
					try {
						var response = JSON.parse(data);
						if (typeof response.error !== "undefined" ) {
							console.log(response.error);
							throw {};
						}
					} catch(e) {
						App.message.show("Ошибка", "Ошибка получения пакетов", "error");
					}
				},
				error : function (data) {
					App.message.show("Ошибка", "Ошибка создания пакета", "error");
				}
			});
		},

		clearDeletedDocument : function(item) {
			var that = this;

			$.ajax({
				type : "POST", url : "",
				data : {
					action : "clearDeletedDocument",
					DocumentId : item.id.substr(4)
				},
				success : function (data) {
					try {
						var response = JSON.parse(data);
						if (typeof response.error !== "undefined" ) {
							console.log(response.error);
							throw {};
						}
					} catch(e) {
						App.message.show("Ошибка", "Ошибка получения пакетов", "error");
					}
				},
				error : function (data) {
					App.message.show("Ошибка", "Ошибка создания пакета", "error");
				}
			});
		}
	},


	interface : {
		parent : null,

		runJsTree : function () {
			if (typeof $.jstree == "undefined") {
				App.message.show("Ошибка", "Ошибка отображения списка документов");
				return;
			}

			var that = this;

			$.jstree.defaults.core.check_callback = function (operation, node, node_parent, node_position, more) {
	            if (operation == "move_node") {
	            	if (node.type == "package" ||
            			node.type == "department" ||
            			node.type == "unknown" ||
            			node.type == "deleted") 
            			return false;

            		if (node_parent.type == "#" ||
            			node_parent.type == "file" ||
            			node_parent.type == "deleted" ||
            			node_parent.type == "new") 
            			return false;

            		that.parent.documentMove.node = node;
            		that.parent.documentMove.node_parent = node_parent;
	            }

	            return true;
	        };
			$.jstree.defaults.core.multiple = false;
			$.jstree.defaults.plugins = [ "dnd", "search", "types", "contextmenu" ];
			$.jstree.defaults.types = {
                'department' : { 'icon' : 'fa fa-cubes' },
                'package' : { 'icon' : 'fa fa-folder' },
                'file' : { 'icon' : 'fa fa-file-o' },
                'new' : { 'icon' : 'fa fa-plus' },
                'deleted' : { 'icon' : 'fa fa-minus' },
                'unknown' : { 'icon' : '' }
            }

            $.jstree.defaults.dnd.copy = false;
            $.jstree.defaults.dnd.drag_selection = false;
            $.jstree.defaults.dnd.is_draggable = function(e) {
            	for (var i = e.length - 1; i >= 0; i--) {
            		if (e[i].type == "package" ||
            			e[i].type == "department" ||
            			e[i].type == "unknown") 
            			return false;
            	}

            	return true;
            }
		},

		renderDocumentsList : function ( data ) {
			$("#notmanagedDocuments").jstree({
				core : {
					data : data
				}
			});
		},

		renderPackageList : function (data) {
			$("#managedDocuments").jstree({
				core : {
					data : data
				}
			});
		}
	}
}

$(function(){

	Documents.init();

});