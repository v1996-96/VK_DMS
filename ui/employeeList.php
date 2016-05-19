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
                <div class="col-lg-3">
                    <div class="title-action">
                        <a href="#addEmployeeModal" data-toggle="modal" class="btn btn-success pull-right">Добавить</a>
                        <div class="btn-group pull-right" style="margin-right: 10px;">
                            <button type="button" class="btn btn-white"><i class="fa fa-th-large"></i></button>
                            <button type="button" class="btn btn-white"><i class="fa fa-th-list"></i></button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="contact-box text-center" style="padding-bottom: 10px;">
                            <a href="/styleru/employee/4">
                                <img alt="image" width="100" class="img-circle m-t-xs" src="{{ @BASE }}/ui/img/a2.jpg">
                                <h3 style="margin-top: 15px; margin-bottom: 0;">Трушин Виктор</h3>
                                <small>Web разработчик</small>
                                <p style="margin-top: 10px;"><i class="fa fa-cubes"></i> Отдел разработки</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="contact-box text-center" style="padding-bottom: 10px;">
                            <a href="profile.html">
                                <img alt="image" width="100" class="img-circle m-t-xs" src="{{ @BASE }}/ui/img/a2.jpg">
                                <h3 style="margin-top: 15px; margin-bottom: 0;">Трушин Виктор</h3>
                                <small>Web разработчик</small>
                                <p style="margin-top: 10px;"><i class="fa fa-cubes"></i> Отдел разработки</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="contact-box text-center" style="padding-bottom: 10px;">
                            <a href="profile.html">
                                <img alt="image" width="100" class="img-circle m-t-xs" src="{{ @BASE }}/ui/img/a2.jpg">
                                <h3 style="margin-top: 15px; margin-bottom: 0;">Трушин Виктор</h3>
                                <small>Web разработчик</small>
                                <p style="margin-top: 10px;"><i class="fa fa-cubes"></i> Отдел разработки</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="contact-box text-center" style="padding-bottom: 10px;">
                            <a href="profile.html">
                                <img alt="image" width="100" class="img-circle m-t-xs" src="{{ @BASE }}/ui/img/a2.jpg">
                                <h3 style="margin-top: 15px; margin-bottom: 0;">Трушин Виктор</h3>
                                <small>Web разработчик</small>
                                <p style="margin-top: 10px;"><i class="fa fa-cubes"></i> Отдел разработки</p>
                            </a>
                        </div>
                    </div>
                </div>

            </div>


            <!-- Footer -->
            <include href="templates/Footer.php" />
        </div>


        <!-- RightSidebar -->
        <include href="templates/RightSidebar.php" />


    </div>



    <div class="modal inmodal" id="addEmployeeModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <!-- <i class="fa fa-building-o modal-icon"></i> -->
                    <h4 class="modal-title">Добавление сотрудника</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-9 block-center">
                            <form>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="vk_id">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary">Добавить</button>
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