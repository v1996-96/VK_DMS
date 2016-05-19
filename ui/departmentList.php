<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - {{ @_page_title }}</title>

    <link href="{{ @BASE }}/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="{{ @BASE }}/ui/css/animate.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/style.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <!-- Menu -->
        <include href="templates/Menu.php" />


        <div id="page-wrapper" class="gray-bg">

            <!-- TopLine -->
            <include href="templates/TopLine.php" />


            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2>Отделы</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/styleru/dashboard">Главная</a>
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
                
                <div class="wrap">
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <a href="/styleru/departments/5">
                            <div class="ibox">
                                <div class="ibox-content">
                                    <h3 class="text-center" style="margin-bottom: 20px;">WEB development</h3>
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                            <h2>50</h2>
                                            <small>сотрудников</small>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <h2>50</h2>
                                            <small>сотрудников</small>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <h2>12</h2>
                                            <small>задач</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <a href="#">
                            <div class="ibox">
                                <div class="ibox-content">
                                    <h3 class="text-center" style="margin-bottom: 20px;">WEB development</h3>
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                            <h2>50</h2>
                                            <small>сотрудников</small>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <h2>50</h2>
                                            <small>сотрудников</small>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <h2>12</h2>
                                            <small>задач</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <a href="#">
                            <div class="ibox">
                                <div class="ibox-content">
                                    <h3 class="text-center" style="margin-bottom: 20px;">WEB development</h3>
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                            <h2>50</h2>
                                            <small>сотрудников</small>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <h2>50</h2>
                                            <small>сотрудников</small>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <h2>12</h2>
                                            <small>задач</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>


            <!-- Footer -->
            <include href="templates/Footer.php" />
        </div>


        <!-- RightSidebar -->
        <include href="templates/RightSidebar.php" />


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
                            <form>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Название">
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
    <script src="{{ @BASE }}/ui/js/jquery-2.1.1.js"></script>
    <script src="{{ @BASE }}/ui/js/bootstrap.min.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ @BASE }}/ui/js/inspinia.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/pace/pace.min.js"></script>

</body>


</html>
