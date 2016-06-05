
var Documents = {
	init : function() {
		this.handlers.parent = this;
		this.actions.parent = this;
		this.interface.parent = this;

		this.interface.runJsTree();

		this.actions.getPackages();
	},

	handlers : {
		parent : null
	},

	actions : {
		parent : null,

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

			$.jstree.defaults.core.check_callback = true;
			$.jstree.defaults.plugins = [ "types" ];
			$.jstree.defaults.types = {
                'department' : { 'icon' : 'fa fa-cubes' },
                'package' : { 'icon' : 'fa fa-folder' },
                'package_incoming' : { 'icon' : 'fa fa-download' },
                'file' : { 'icon' : 'fa fa-file-o' },
                'new' : { 'icon' : 'fa fa-plus' },
                'deleted' : { 'icon' : 'fa fa-minus' },
                'unknown' : { 'icon' : '' }
            }
		},

		renderPackageList : function (data) {
			console.log(data);
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