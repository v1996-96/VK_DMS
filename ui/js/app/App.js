var App = (function($) {

	var parent = this;


	// Methods for working with vk
	this.vkFactory = {
		appid : 5469551,

		init : function() {
			var that = this;
			


			// Start vk 
			VK.init({
				apiId: that.appid
			});

			// Authorize user
			VK.Auth.getLoginStatus(this.loginStatusHandler);
		},

		loginStatusHandler : function (response) {
			if (response.session) {
				console.log('user: '+response.session.mid);

				this.getGroups();
			} else {
				console.log('not auth');

				VK.Auth.login(this.loginHandler);
			}
		},

		loginHandler : function (response) {
			if (response.session) { 
				console.log("vk login success");

				this.getGroups();
			} else { 
				console.log("vk login error");
			} 
		}

	}


	// App start point
	this.initialize = function () {
		// this.vkFactory.init();

		$('.tooltipToggle').tooltip();
	}


	// Runs app after document is ready
	$(document).ready(function () {
		parent.initialize();
	});


	// Public API
	return {};

})(jQuery);