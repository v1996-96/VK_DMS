
var Dashboard = {
    init : function () {
        var that = this;

        this.handlers.parent = this;
        this.actions.parent = this;
        this.interface.parent = this;

        this.interface.blockChart();

        this.actions.getActivityByMonth(function(response) {
            that.interface.releaseChart();

            that.interface.btnSwitch("month");

            if (typeof response.data !== "undefined") {
                that.interface.initChart(response.data, "month");
            }
        });

        this.handlers.setSwitchHandler();
    },


    handlers : {
        parent : null,

        setSwitchHandler : function () {
            var that = this;

            $("#activityByDay").parent().on("click", function(e) {
                e.preventDefault();

                that.parent.interface.blockChart();

                that.parent.actions.getActivityByDay(function(response) {
                    that.parent.interface.releaseChart();

                    that.parent.interface.btnSwitch("day");

                    if (typeof response.data !== "undefined") {
                        that.parent.interface.initChart(response.data, "day");
                    }
                });
            });


            $("#activityByMonth").parent().on("click", function(e) {
                e.preventDefault();

                that.parent.interface.blockChart();

                that.parent.actions.getActivityByMonth(function(response) {
                    that.parent.interface.releaseChart();

                    that.parent.interface.btnSwitch("month");

                    if (typeof response.data !== "undefined") {
                        that.parent.interface.initChart(response.data, "month");
                    }
                });
            });


            $("#activityByYear").parent().on("click", function(e) {
                e.preventDefault();

                that.parent.interface.blockChart();

                that.parent.actions.getActivityByYear(function(response) {
                    that.parent.interface.releaseChart();

                    that.parent.interface.btnSwitch("year");

                    if (typeof response.data !== "undefined") {
                        that.parent.interface.initChart(response.data, "year");
                    }
                });
            });


        }
    },


    actions : {
        parent : null,

        getActivityByDay : function (callback) {
            this.sendRequest({
                "action" : "getActivityByDay"
            }, callback);
        },

        getActivityByMonth : function (callback) {
            this.sendRequest({
                "action" : "getActivityByMonth"
            }, callback);
        },

        getActivityByYear : function (callback) {
            this.sendRequest({
                "action" : "getActivityByYear"
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

        btnSwitch : function (type) {
            $("#activityByDay").parent().removeClass("active");
            $("#activityByMonth").parent().removeClass("active");
            $("#activityByYear").parent().removeClass("active");

            switch (type) {
                case "day":
                    $("#activityByDay").parent().addClass("active");
                    break;

                case "month":
                    $("#activityByMonth").parent().addClass("active");
                    break;

                case "year":
                    $("#activityByYear").parent().addClass("active");
                    break;

                default:
                    $("#activityByDay").parent().addClass("active");
                    break;
            }
        },

        blockChart : function () {
            $("#chartWrap")
                .addClass("processing");
        },

        releaseChart : function () {
            $("#chartWrap")
                .removeClass("processing");
        },

        initChart : function (data, type) {
            var options = {
                grid: {
                    hoverable: true,
                    borderColor: "#f3f3f3",
                    borderWidth: 1,
                    tickColor: "#f3f3f3"
                },
                series: {
                    shadowSize: 0,
                    lines: {
                        show: true
                    },
                    points: {
                        show: true
                    }
                },
                lines: {
                    fill: false,
                    color: ["#3c8dbc", "#f56954"]
                },
                yaxis: {
                    show: true,
                },
                xaxis: {
                    show: true,
                    mode: "time",
                    timeformat: "%Y/%m/%d"
                }
            }

            switch (type) {
                case "day":
                    options.xaxis.timeformat = "%H";
                    options.xaxis.tickSize = [1, "hour"];
                    break;

                case "month":
                    options.xaxis.timeformat = "%d";
                    options.xaxis.tickSize = [1, "day"];
                    break;

                case "year":
                    options.xaxis.timeformat = "%m";
                    options.xaxis.tickSize = [1, "month"];
                    break;

                default:
                    options.xaxis.timeformat = "%Y/%m/%d";
                    break;
            }

            $("#flot-dashboard-chart").plot(
                [
                    {
                        color : "blue",
                        data : data
                    }
                ], options);
        }
    }
}


$(function(){

    Dashboard.init();

});