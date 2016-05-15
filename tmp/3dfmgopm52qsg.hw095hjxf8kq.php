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


            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2>Сотрудники</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/styleru/dashboard">Главная</a>
                        </li>
                        <li class="active">
                            <strong>Сотрудники</strong>
                        </li>
                    </ol>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="contact-box text-center" style="padding-bottom: 10px;">
                            <a href="/styleru/employee/4">
                                <img alt="image" width="100" class="img-circle m-t-xs" src="<?php echo $BASE; ?>/ui/img/a2.jpg">
                                <h3 style="margin-top: 15px; margin-bottom: 0;">Трушин Виктор</h3>
                                <small>Web разработчик</small>
                                <p style="margin-top: 10px;"><i class="fa fa-cubes"></i> Отдел разработки</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="contact-box text-center" style="padding-bottom: 10px;">
                            <a href="profile.html">
                                <img alt="image" width="100" class="img-circle m-t-xs" src="<?php echo $BASE; ?>/ui/img/a2.jpg">
                                <h3 style="margin-top: 15px; margin-bottom: 0;">Трушин Виктор</h3>
                                <small>Web разработчик</small>
                                <p style="margin-top: 10px;"><i class="fa fa-cubes"></i> Отдел разработки</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="contact-box text-center" style="padding-bottom: 10px;">
                            <a href="profile.html">
                                <img alt="image" width="100" class="img-circle m-t-xs" src="<?php echo $BASE; ?>/ui/img/a2.jpg">
                                <h3 style="margin-top: 15px; margin-bottom: 0;">Трушин Виктор</h3>
                                <small>Web разработчик</small>
                                <p style="margin-top: 10px;"><i class="fa fa-cubes"></i> Отдел разработки</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="contact-box text-center" style="padding-bottom: 10px;">
                            <a href="profile.html">
                                <img alt="image" width="100" class="img-circle m-t-xs" src="<?php echo $BASE; ?>/ui/img/a2.jpg">
                                <h3 style="margin-top: 15px; margin-bottom: 0;">Трушин Виктор</h3>
                                <small>Web разработчик</small>
                                <p style="margin-top: 10px;"><i class="fa fa-cubes"></i> Отдел разработки</p>
                            </a>
                        </div>
                    </div>
                </div>

            </div>


            <!-- Footer -->
            <?php echo $this->render('templates/Footer.php',$this->mime,get_defined_vars(),0); ?>
        </div>


        <!-- RightSidebar -->
        <?php echo $this->render('templates/RightSidebar.php',$this->mime,get_defined_vars(),0); ?>


    </div>


    <!-- Mainly scripts -->
    <script src="<?php echo $BASE; ?>/ui/js/jquery-2.1.1.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/bootstrap.min.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo $BASE; ?>/ui/js/inspinia.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/pace/pace.min.js"></script>

</body>


</html>
