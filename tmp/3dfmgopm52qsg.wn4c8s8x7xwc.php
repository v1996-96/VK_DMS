<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_TITLE; ?> - <?php echo $_page_title; ?></title>

    <?php echo $this->render('templates/Styles.php',$this->mime,get_defined_vars(),0); ?>

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
        <?php echo $this->render('templates/Menu.php',$this->mime,get_defined_vars(),0); ?>


        <div id="page-wrapper" class="gray-bg">

            <!-- TopLine -->
            <?php echo $this->render('templates/TopLine.php',$this->mime,get_defined_vars(),0); ?>


            <div class="wrapper wrapper-content">
                
                <!-- Summary -->
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Отделы</h5>
                                <h1 class="no-margins text-success"><?php echo $DepartmentsCount; ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Проекты</h5>
                                <h1 class="no-margins text-success"><?php echo $ProjectsCount; ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Активность</h5>
                                <h1 class="no-margins text-warning"><?php echo $Activity; ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Сотрудники</h5>
                                <h1 class="no-margins text-success"><?php echo $EmployeeCount; ?></h1>
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
            <?php echo $this->render('templates/Footer.php',$this->mime,get_defined_vars(),0); ?>
        </div>


        <!-- RightSidebar -->
        <?php echo $this->render('templates/RightSidebar.php',$this->mime,get_defined_vars(),0); ?>


    </div>


    <?php echo $this->render('templates/Scripts.php',$this->mime,get_defined_vars(),0); ?>

    <!-- Flot -->
    <script src="<?php echo $BASE; ?>/ui/js/plugins/flot/jquery.flot.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/flot/jquery.flot.time.js"></script>


    <script src="<?php echo $BASE; ?>/ui/js/app/App.js" type="text/javascript"></script>
    <script src="<?php echo $BASE; ?>/ui/js/app/pages/CompanyDashboard.js" type="text/javascript"></script>


</body>
</html>