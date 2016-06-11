<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - {{ @_page_title }}</title>

    <include href="templates/Styles.php" />

    <style type="text/css">
    .loading{
        position: absolute;
        background: rgba(255, 255, 255, 0.7);
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 100;
        /*display: flex;*/
        display: none;
        justify-content: center;
        align-items: center;
    }
    .processing > .loading{
        display: flex;
    }
    </style>

</head>

<body>

    <div id="wrapper">

        <!-- Menu -->
        <include href="templates/Menu.php" />


        <div id="page-wrapper" class="gray-bg">

            <!-- TopLine -->
            <include href="templates/TopLine.php" />


            <div class="wrapper wrapper-content">
                
                <!-- Summary -->
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Отделы</h5>
                                <h1 class="no-margins text-success">{{ @DepartmentsCount }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Проекты</h5>
                                <h1 class="no-margins text-success">{{ @ProjectsCount }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Активность</h5>
                                <h1 class="no-margins text-warning">{{ @Activity }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Сотрудники</h5>
                                <h1 class="no-margins text-success">{{ @EmployeeCount }}</h1>
                            </div>
                        </div>
                    </div>
                </div><!-- /Summary -->


                <!-- Chart -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Активность компании</h5>
                                <div class="pull-right">
                                    <div class="btn-group" data-toggle="buttons">
                                      <label class="btn btn-white btn-xs active">
                                        <input type="radio" name="options" id="activityByDay" autocomplete="off"> День
                                      </label>
                                      <label class="btn btn-white btn-xs">
                                        <input type="radio" name="options" id="activityByMonth" autocomplete="off"> Месяц
                                      </label>
                                      <label class="btn btn-white btn-xs">
                                        <input type="radio" name="options" id="activityByYear" autocomplete="off"> Год
                                      </label>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content" id="chartWrap">
                                <div class="loading"><span><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span></div>

                                <div class="row">
                                    <div class="col-lg-9">
                                        <div class="flot-chart">
                                            <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="flot-chart">
                                            <div class="flot-chart-content" id="flot-dashboard-pie"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div><!-- /Chart -->


            </div>


            <!-- Footer -->
            <include href="templates/Footer.php" />
        </div>


        <!-- RightSidebar -->
        <include href="templates/RightSidebar.php" />


    </div>


    <include href="templates/Scripts.php" />

    <!-- Flot -->
    <script src="{{ @BASE }}/ui/js/plugins/flot/jquery.flot.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/flot/jquery.flot.time.js"></script>


    <script src="{{ @BASE }}/ui/js/app/App.js" type="text/javascript"></script>
    <script src="{{ @BASE }}/ui/js/app/pages/CompanyDashboard.js" type="text/javascript"></script>


</body>
</html>