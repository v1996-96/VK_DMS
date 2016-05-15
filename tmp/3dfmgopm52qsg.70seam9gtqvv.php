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

<body class="top-navigation">

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <ul class="nav navbar-top-links navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                            </a>
                            <ul class="dropdown-menu dropdown-alerts">
                                <li>
                                    <a href="mailbox.html">
                                        <div>
                                            <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                            <span class="pull-right text-muted small">4 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="profile.html">
                                        <div>
                                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                            <span class="pull-right text-muted small">12 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="grid_options.html">
                                        <div>
                                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                            <span class="pull-right text-muted small">4 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a href="notifications.html">
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>


                        <li>
                            <a href="/logOut">
                                <i class="fa fa-sign-out"></i> Выйти
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>Выберите компанию</h2>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                        <a href="#" data-toggle="modal" data-target="#addCompanyModal" class="btn btn-success">Создать новую</a>
                    </div>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row">
                    <div class="col-md-3">
                        <a href="/styleru/dashboard">
                            <div class="ibox">
                                <div class="ibox-content product-box">
                                    <div class="product-imitation">
                                        [ Картинка ]
                                    </div>
                                    <div class="product-desc">
                                        <span class="product-price blue-bg">
                                            Директор
                                        </span>
                                        <span class="product-name">Styleru</span>
                                        <div class="small m-t-xs">
                                            Many desktop publishing packages and web page editors now.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>


            <!-- Footer -->
            <?php echo $this->render('templates/Footer.php',$this->mime,get_defined_vars(),0); ?>

        </div>
    </div>


    <div class="modal inmodal" id="addCompanyModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-building-o modal-icon"></i>
                    <h4 class="modal-title">Создание компании</h4>
                    <small>Это не займет много времени :)</small>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-9 block-center">
                            <form>
                                <div class="form-group">
                                    <div class="companyLogo" data-toggle="tooltip" data-placement="bottom" title="Нажмите, чтобы добавить логотип">
                                        <a href="#"></a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Название">
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control" rows="3" placeholder="Слоган"></textarea>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary">Создать</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Mainly scripts -->
    <script src="<?php echo $BASE; ?>/ui/js/jquery-2.1.1.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/bootstrap.min.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo $BASE; ?>/ui/js/inspinia.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/pace/pace.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>


</body>


</html>
