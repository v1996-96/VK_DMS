/**
 * Project dashboard script
 */

var ProjectDashboard = {
	lock : false,

	init : function() {
		this.handlers.parent = this;
		this.actions.parent = this;
		this.interface.parent = this;
		this.interface.init();

		this.handlers.closedStateChanged();
		this.handlers.showClosed();
		this.handlers.showTaskDetails();
		this.handlers.editTask();
		this.handlers.saveTaskEdit();
	},

	handlers : {
		parent : null,

		closedStateChanged : function() {
			var that = this;

			$(document).on("ifToggled", "#tasksTab .i-checks", function(e){
				e.stopPropagation();

				var item = $(e.target).parents("li");
				var id = $(e.target).parents("a").attr("data-id");
				var state = $(e.target).is(":checked");

				that.parent.interface.blockList();

				that.parent.actions.toggleClosedState(id, state, function(response){
					that.parent.interface.releaseList();

					if (typeof response.success !== "undefined") {
						var list = state ? "closed" : "open";
						that.parent.interface.moveTask(item, list);
					}

					if (typeof response.transfer !== "undefined" &&
						typeof response.packages !== "undefined") {
						that.parent.interface.showPackageResolve( response.packages );
					}
				});
			});
		},

		showClosed : function() {
			$("#toggleClosed").on("click", function(e) {
				e.preventDefault();

				$("#ClosedTaskList").toggleClass("hidden");
			});
		},

		showTaskDetails : function() {
			var that = this;

			$("#taskDescription").on("show.bs.modal", function(e){

				var id = $(e.relatedTarget).attr("data-id");

				$("#TaskSummaryError").addClass("hidden");
				$("#TaskSummaryBlock").addClass("hidden");
				$("#TaskEditForm").addClass("hidden");
				$("#SaveTask").addClass("hidden");

				if (typeof id !== "undefined") {
					that.parent.actions.getTaskSummary(id, function(response) {
						if (typeof response.summary !== "undefined" &&
							typeof response.packages !== "undefined") {

							$("#TaskSummaryError").addClass("hidden");
							$("#TaskSummaryBlock").removeClass("hidden");

							that.parent.interface.showTaskSummary( response );
						} else {
							App.message.show("Ошибка", "Ошибка отображения задачи");
							$("#TaskSummaryError").removeClass("hidden");
							$("#TaskSummaryBlock").addClass("hidden");
						}
					}, function() {
						$("#TaskSummaryError").removeClass("hidden");
						$("#TaskSummaryBlock").addClass("hidden");
					});

					$("#SaveTask").attr("data-id", id);

					that.parent.actions.getAvailablePackageList(id, function(response) {
						if (typeof response.packages !== "undefined") {
							that.parent.interface.showAvailablePackages( response.packages );
						} else {
							App.message.show("Ошибка", "Ошибка отображения задачи");							
						}
					});
				}
			});
		},

		editTask : function() {
			var that = this;

			$("#EditTask").on("click", function(e) {
				e.preventDefault();

				if ($("#TaskSummaryError").hasClass("hidden")) {
					$("#TaskEditForm").toggleClass("hidden");
					$("#TaskSummaryBlock").toggleClass("hidden");

					if ($("#TaskEditForm").hasClass("hidden")) {
						$("#SaveTask").addClass("hidden");
					} else {
						$("#SaveTask").removeClass("hidden");
					}
				}

			});
		},

		saveTaskEdit : function() {
			var that = this;

			$("#TaskEditForm").on("submit", function(e) {
				e.preventDefault();

				var data = {
					IsClosed : $("#TaskClosedField").is(":checked") ? 1 : 0,
					Title : $("#TaskTitleField").val(),
					Description : $("#TaskDescriptionField").val()
				}

				if ($("#TaskDeadlineField").inputmask("isComplete")) {
					data.Deadline = $("#TaskDeadlineField").val()
				}

				var i = 0;
				$("#TaskPackagesWrap .i-checks").each(function(n, el){
					if ($(el).is(":checked")) {
						data["Package["+i+"]"] = $(el).val();
						i++;
					}
				});

				if (i == 0) {
					data["Package"] = "delete_all";
				}

				var id = $("#SaveTask").attr("data-id");

				if (typeof id == "undefined") 
					return false;

				that.parent.actions.saveTaskEdit(id, data, function(response){
					App.message.show("Успех", "Изменения сохранены", "info");

					if (typeof response.transfer !== "undefined" &&
						typeof response.packages !== "undefined") {
						that.parent.interface.showPackageResolve( response.packages );
					}
				});
			});
		}
	},

	actions : {
		parent : null,

		toggleClosedState : function (id, state, callback) {
			this.sendRequest({
				"action" : "editTask",
				"TaskId" : id,
				"IsClosed" : state ? 1 : 0
			}, callback);
		},

		getTaskSummary : function(id, callback, errorCallback) {
			this.sendRequest({
				"action" : "taskSummary",
				"TaskId" : id
			}, callback, errorCallback);
		},

		getAvailablePackageList : function(id, callback) {
			this.sendRequest({
				"action" : "getAvailablePackagesList",
				"TaskId" : id
			}, callback);
		},

		saveTaskEdit : function(id, data, callback) {
			this.sendRequest(
				$.extend({
					"action" : "editTask",
					"TaskId" : id
				}, data), callback);
		},

		getDepartments : function(callback) {
			this.sendRequest({
				"action" : "getDepartments"
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

		init : function() {
			$('.i-checks').iCheck({
			    checkboxClass: 'icheckbox_square-green',
			    radioClass: 'iradio_square-green'
			});

			$(".todo-list:not(.disabled)").sortable({
				handle : ".sort-toggle"
			});

			$("#TaskDeadlineField").inputmask({
				mask : "y-m-d h:s:s"
			});

			$.jstree.defaults.core.check_callback = true;
			$.jstree.defaults.core.multiple = false;
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

            $("#packageList").jstree({ core : { data : [] }	});
		},

		blockList : function () {
			$("#tasksTab .panel-body")
				.addClass("processing");
		},

		releaseList : function () {
			$("#tasksTab .panel-body")
				.removeClass("processing");
		},

		moveTask : function (task, list) {
			switch (list) {
				case "open":
					$(task).find(".sort-toggle").removeClass("hidden");
					$(task).appendTo( $("#OpenTaskList") );
					var length = $("#ClosedTaskList > li").length;
					if (length == 0) {
						$("#ShowClosedTaskList").addClass("hidden")
					}

					$("#toggleClosed").text("Просмотреть завершенные ("+length+")");
					break;

				case "closed":
					$(task).find(".sort-toggle").addClass("hidden");
					$(task).appendTo( $("#ClosedTaskList") );
					var length = $("#ClosedTaskList > li").length;
					if (length > 0) {
						$("#ShowClosedTaskList").removeClass("hidden")
					}

					$("#toggleClosed").text("Просмотреть завершенные ("+length+")");
					break;

				default: return;
			}
		},

		showTaskSummary : function(response) {

			// Preview information
			function SetViewValue(view, value) {
				$( view ).html( value );
					if (value == null || value == "") 
						$( view ).parent().addClass("hidden");
					else
						$( view ).parent().removeClass("hidden");
			}

			SetViewValue("#DateClosedBlock", response.summary.DateClosed);

			if (response.summary.IsClosed == 1) {
				$("#TaskOpenedStatus").addClass("hidden");
				$("#TaskClosedStatus").removeClass("hidden");
				$("#DateClosedBlock").parent().removeClass("hidden");
			} else {
				console.log($("#DateClosedBlock").parent());
				$("#TaskOpenedStatus").removeClass("hidden");
				$("#TaskClosedStatus").addClass("hidden");
				$("#DateClosedBlock").parent().addClass("hidden");
			}

			SetViewValue("#DateAddBlock", response.summary.DateAdd);
			SetViewValue("#TaskTitle", response.summary.Title);
			SetViewValue("#TaskDescription", response.summary.Description);
			SetViewValue("#TaskDeadline", response.summary.Deadline);

			if (response.packages.length == 0) {
				$("#packageListEmpty").removeClass("hidden");
			} else {
				$("#packageListEmpty").addClass("hidden");
			}


			// Form information
			SetViewValue("#CreateDateField", response.summary.DateAdd);
			SetViewValue("#ClosedDateField", response.summary.DateClosed);

			if (response.summary.IsClosed == 1) {
				$("#TaskClosedField").iCheck("check");
			} else {
				$("#TaskOpenedField").iCheck("check");
				$("#ClosedDateField").parent().addClass("hidden");
			}

			$("#TaskTitleField").val( response.summary.Title );
			$("#TaskDescriptionField").val( response.summary.Description );
			$("#TaskDeadlineField").val( response.summary.Deadline );

			$("#packageList").jstree(true).settings.core.data = response.packages;
			$("#packageList").jstree(true).refresh(true);
		},

		showAvailablePackages : function(packages) {
			var parent = $("#TaskPackagesWrap");

			if (packages.length == 0) {
				parent.html("<strong>Нет доступных пакетов</strong>");
				return;
			}

			var list = $("<ul></ul>").addClass("list-group");

			for (var i = 0; i < packages.length; i++) {
				var item = $("<li></li>").addClass("list-group-item").css("padding", "5px 10px");
				var checkbox = $("<input />").attr({
					"type" : "checkbox", "name" : "Package[]",
					"value" : packages[i].PackageId, "class" : "i-checks"
				});
				if (packages[i].IsLinked == 1) checkbox.attr("checked", "checked");
				checkbox.appendTo( item );
				item.append( "&nbsp;" + packages[i].Title );
				item.appendTo( list );
			}

			parent.html("");
			parent.append( list );

			parent.find(".i-checks").iCheck({
			    checkboxClass: 'icheckbox_square-green',
			    radioClass: 'iradio_square-green'
			});
		},

		showPackageResolve : function(packages) {
			this.parent.actions.getDepartments(function(response) {
				if (typeof response.departments == "undefined") return;

				var list = response.departments;

				$("#packageResolveList").html("");

				var select = $("<select></select>").addClass("form-control");
				$("<option></option>").val( -1 ).html( "Передать обратно в текущий отдел" ).appendTo( select );
				$("<option></option>").val( 0 ).html( "Не откреплять от задачи" ).appendTo( select );
				for (var i = 0; i < list.length; i++) {
					$("<option></option>")
						.val( list[i].DepartmentId )
						.html( list[i].Title )
						.appendTo( select );
				}

				for (var i = 0; i < packages.length; i++) {
					var tr = $("<tr></tr>");
					var td1 = $("<td></td>").html( packages[i].Title ).appendTo(tr);
					$("<input />").attr({
						type : "hidden", name : "PackageId["+i+"]", value : packages[i].PackageId
					}).appendTo(td1)
					var td2 = $("<td></td>").appendTo( tr );
					select.clone().attr("name", "DepartmentId["+i+"]").appendTo(td2);
					tr.appendTo( $("#packageResolveList") );
				}

				$("#packageResolveModal").modal();
			});
		}
	}
}



$(document).ready(function(){

	ProjectDashboard.init();

});