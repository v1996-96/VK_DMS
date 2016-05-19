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
                    <h2>Проекты</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/styleru/dashboard">Главная</a>
                        </li>
                        <li class="active">
                            <strong>Проекты</strong>
                        </li>
                    </ol>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row">
                    <div class="col-xs-12">
                        
                        <div class="ibox">
                            <div class="ibox-content">

                                <div class="row m-b">
                                    <div class="col-md-6">
                                        <h2 class="no-margins">Количество: 201</h2>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Поиск...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-white" type="button"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-hover no-margins">
                                    <tbody>
                                        <tr>
                                            <td class="project-status">
                                                <span class="label label-primary">Active</span>
                                            </td>
                                            <td class="project-title">
                                                <a href="project_detail.html">Contract with Zender Company</a>
                                                <br/>
                                                <small>Created 14.08.2014</small>
                                            </td>
                                            <td class="project-completion">
                                                <small>Отдел:</small><br>
                                                <h5 class="no-margins">Web разработка</h5>
                                            </td>
                                            <td class="project-completion">
                                                <small>Задач:</small><br>
                                                <h5 class="no-margins">12</h5>
                                            </td>
                                            <td class="project-completion">
                                                <small>Сотрудников:</small><br>
                                                <h5 class="no-margins">15</h5>
                                            </td>
                                            <td class="project-actions">
                                                <a href="/styleru/projects/5" class="btn btn-success btn-sm">Перейти</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="project-status">
                                                <span class="label label-warning">Closed</span>
                                            </td>
                                            <td class="project-title">
                                                <a href="project_detail.html">Contract with Zender Company</a>
                                                <br/>
                                                <small>Created 14.08.2014</small>
                                            </td>
                                            <td class="project-completion">
                                                <small>Отдел:</small><br>
                                                <h5 class="no-margins">Web разработка</h5>
                                            </td>
                                            <td class="project-completion">
                                                <small>Задач:</small><br>
                                                <h5 class="no-margins">12</h5>
                                            </td>
                                            <td class="project-completion">
                                                <small>Сотрудников:</small><br>
                                                <h5 class="no-margins">15</h5>
                                            </td>
                                            <td class="project-actions">
                                                <a href="#" class="btn btn-success btn-sm">Перейти</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
