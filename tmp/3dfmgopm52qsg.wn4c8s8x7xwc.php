<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_TITLE; ?> - <?php echo $_page_title; ?></title>

    <link href="<?php echo $BASE; ?>/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo $BASE; ?>/ui/css/animate.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/css/style.css" rel="stylesheet">

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
                                <h5>Трафик пакетов документов</h5>
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-xs btn-white active">Today</button>
                                        <button type="button" class="btn btn-xs btn-white">Monthly</button>
                                        <button type="button" class="btn btn-xs btn-white">Annual</button>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                <div class="col-lg-9">
                                    <div class="flot-chart">
                                        <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <ul class="stat-list">
                                        <li>
                                            <h2 class="no-margins">2,346</h2>
                                            <small>Total orders in period</small>
                                            <div class="stat-percent">48% <i class="fa fa-level-up text-navy"></i></div>
                                            <div class="progress progress-mini">
                                                <div style="width: 48%;" class="progress-bar"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <h2 class="no-margins ">4,422</h2>
                                            <small>Orders in last month</small>
                                            <div class="stat-percent">60% <i class="fa fa-level-down text-navy"></i></div>
                                            <div class="progress progress-mini">
                                                <div style="width: 60%;" class="progress-bar"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <h2 class="no-margins ">9,180</h2>
                                            <small>Monthly income from orders</small>
                                            <div class="stat-percent">22% <i class="fa fa-bolt text-navy"></i></div>
                                            <div class="progress progress-mini">
                                                <div style="width: 22%;" class="progress-bar"></div>
                                            </div>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                                </div>

                            </div>
                        </div>
                </div><!-- /Chart -->


                <!-- Widgets -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <h2>Текщие задачи</h2>

                                <ul class="todo-list m-t small-list">
                                    <li>
                                        <a href="#" class="check-link"><i class="fa fa-check-square"></i> </a>
                                        <span class="m-l-xs todo-completed">Buy a milk</span>

                                    </li>
                                    <li>
                                        <a href="#" class="check-link"><i class="fa fa-check-square"></i> </a>
                                        <span class="m-l-xs  todo-completed">Go to shop and find some products.</span>

                                    </li>
                                    <li>
                                        <a href="#" class="check-link"><i class="fa fa-square-o"></i> </a>
                                        <span class="m-l-xs">Send documents to Mike</span>
                                        <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 mins</small>
                                    </li>
                                    <li>
                                        <a href="#" class="check-link"><i class="fa fa-square-o"></i> </a>
                                        <span class="m-l-xs">Go to the doctor dr Smith</span>
                                    </li>
                                    <li>
                                        <a href="#" class="check-link"><i class="fa fa-square-o"></i> </a>
                                        <span class="m-l-xs">Plan vacation</span>
                                    </li>
                                </ul>

                                <br>

                                <a class="btn btn-primary btn-block">Посмотреть все</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <h2>Текщие проекты</h2>

                                <div class="project-list">

                                    <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td class="project-title">
                                                    <a href="project_detail.html">Contract with Zender Company</a>
                                                    <br/>
                                                    <small>Created 14.08.2014</small>
                                                </td>
                                                <td class="project-actions">
                                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="project-title">
                                                    <a href="project_detail.html">Contract with Zender Company</a>
                                                    <br/>
                                                    <small>Created 14.08.2014</small>
                                                </td>
                                                <td class="project-actions">
                                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <a class="btn btn-primary btn-block">Посмотреть все</a>
                            </div>
                        </div>
                    </div>
                </div><!-- /Widgets -->


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