var App = (function($) {

	var parent = this;

	this.message = {
		show : function (title, message, type) {
			var title = title || "Default title";
			var message = message || "Default message";
			var type = type || "error";

			if (typeof toastr == "undefined") {
				alert( message );
				return;
			}

			toastr.options.closeButton = true;

			switch (type) {
				case "info": toastr.info(message, title); break;
				case "success": toastr.success(message, title); break;
				case "warning": toastr.warning(message, title); break;
				case "error": toastr.error(message, title); break;
				default: toastr.error(message, title); break;
			}
		}
	}


	// Methods for working with vk
	this.vkFactory = {
		appid : 5469551,

		init : function() {
			var that = this;
			
			VK.init({
				apiId: that.appid
			});
		},

		getDocumentList : function (groupId, callback) {
			VK.Api.call("docs.get", {
				"owner_id" : -1*groupId
			}, callback);
		}

	}


	// App start point
	this.initialize = function () {
		this.vkFactory.init();
	}


	// Runs app after document is ready
	$(document).ready(function () {
		parent.initialize();
	});


	// Public API
	return {
		message : {
			show : function (title, message, type) {
				parent.message.show(title, message, type);
			}
		},

		getDocumentList : function (groupId, callback) {
			parent.vkFactory.getDocumentList(groupId, callback);
		}
	};

})(jQuery);