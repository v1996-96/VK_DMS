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
                    <h2>Отделы</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/dashboard">Главная</a>
                        </li>
                        <li class="active">
                            <strong>Отделы</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-3">
                    <div class="title-action">
                        <a href="#addDepartmentModal" data-toggle="modal" class="btn btn-success pull-right">Добавить</a>
                        <!-- <div class="btn-group pull-right" style="margin-right: 10px;">
                            <button type="button" class="btn btn-white"><i class="fa fa-th-large"></i></button>
                            <button type="button" class="btn btn-white"><i class="fa fa-th-list"></i></button>
                        </div> -->
                    </div>
                </div>
            </div>


            <div class="wrapper wrapper-content">

                <?php if (isset($department_error)): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $department_error; ?>
                    </div>
                <?php endif; ?>
                
                <div class="row">
                    <?php foreach (($DepartmentList?:array()) as $department): ?>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/departments/<?php echo $department['DepartmentId']; ?>">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h3 class="text-center" style="margin-bottom: 20px;"><?php echo $department['Title']; ?></h3>
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <h2><?php echo $department['EmployeeCount']; ?></h2>
                                                <small>сотрудников</small>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <h2><?php echo $department['ProjectCount']; ?></h2>
                                                <small>проектов</small>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <h2><?php echo $department['TaskCount']; ?></h2>
                                                <small>задач</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>


            <!-- Footer -->
            <?php echo $this->render('templates/Footer.php',$this->mime,get_defined_vars(),0); ?>
        </div>


        <!-- RightSidebar -->
        <?php echo $this->render('templates/RightSidebar.php',$this->mime,get_defined_vars(),0); ?>


    </div>


    <div class="modal inmodal" id="addDepartmentModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <!-- <i class="fa fa-building-o modal-icon"></i> -->
                    <h4 class="modal-title">Создание отдела</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-9 block-center">
                            <form method="POST" id="createDepartmentForm">
                                <div class="form-group">
                                    <input type="text" name="Title" class="form-control" placeholder="Название">
                                </div>

                                <input type="hidden" name="action" value="create" />
                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <button type="submit" form="createDepartmentForm" name="action" value="create" class="btn btn-primary">Создать</button>
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

</body>


</html>
