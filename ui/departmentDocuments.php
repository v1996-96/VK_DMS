<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - {{ @_page_title }}</title>

    <link href="{{ @BASE }}/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

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
                    <h2>Документы отдела</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/styleru/dashboard">Главная</a>
                        </li>
                        <li>
                            <a href="/styleru/departments">Отделы</a>
                        </li>
                        <li>
                            <a href="/styleru/departments/4">Web разработка</a>
                        </li>
                        <li class="active">
                            <strong>Документы отдела</strong>
                        </li>
                    </ol>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox hidden" id="packageList">
                            <div class="ibox-content">
                                <h3>
                                    Пакеты документов
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-primary btn-xs">Добавить</a>
                                    </div>
                                </h3>

                                <p class="small"><i class="fa fa-hand-o-up"></i> Выберите пакет документов</p>

                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Внутренние пакеты
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                            <ul class="list-group">
                                                <a href="#" class="list-group-item">Cras justo odio<span class="badge">5</span></a>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingTwo">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Входящие пакеты
                                                </a>
                                                <span class="label label-success">NEW 5</span>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                            <ul class="list-group">
                                                <a href="#" class="list-group-item">Cras justo odio<span class="badge">5</span></a>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingThree">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    Исходяшие пакеты
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                            <ul class="list-group">
                                                <a href="#" class="list-group-item">Cras justo odio<span class="badge">5</span></a>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="ibox" id="packageDetail">
                            <div class="ibox-title">
                                <h5><a href="#"><i class="fa fa-arrow-left"></i> Назад</a></h5>
                                <div class="ibox-tools pull-right">
                                    <a href="#" class="btn btn-xs btn-white" style="color: #333;">История пакета</a>
                                    <a href="#" class="btn btn-xs btn-primary" style="color: #fff;">Изменить</a>
                                    <a href="#" class="btn btn-xs btn-danger" style="color: #fff;">Удалить</a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <h3>Заказ номер 1</h3>
                                <p>
                                    Пакет нужен для группировки файлов и последующего прикрепления к задачам.
                                </p>

                                <ul class="sortable-list connectList agile-list">
                                    <li class="primary-element">
                                        <strong>file_name.docx</strong>
                                        <div class="agile-detail">
                                            <i class="fa fa-clock-o"></i> 12.10.2015
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h3>
                                    Документы
                                    <div class="pull-right">
                                        <div class="btn-group">
                                            <a class="btn btn-white btn-xs">Все</a>
                                            <a class="btn btn-white btn-xs active">Свободные</a>
                                        </div>
                                    </div>
                                </h3>
                                <div class="clearfix"></div>
                                <p class="small"><i class="fa fa-hand-o-up"></i> Перемещайте файлы между списками</p>

                                <ul class="sortable-list connectList agile-list">
                                    <li class="success-element">
                                        <strong>file_name.docx</strong>
                                        <span class="label label-primary">NEW</span>
                                        <div class="agile-detail">
                                            <a href="#" class="pull-right btn btn-xs btn-danger">Удалить</a>
                                            <i class="fa fa-clock-o"></i> 12.10.2015
                                        </div>
                                    </li>
                                    <li class="primary-element">
                                        <strong>file_name.docx</strong>
                                        <div class="agile-detail">
                                            <a href="#" class="pull-right btn btn-xs btn-danger">Удалить</a>
                                            <i class="fa fa-clock-o"></i> 12.10.2015
                                        </div>
                                    </li>
                                    <li class="danger-element">
                                        <strong>file_name.docx</strong>
                                        <span class="label label-danger">DELETED</span>
                                        <div class="agile-detail">
                                            <a href="#" class="pull-right btn btn-xs btn-danger">Удалить</a>
                                            <i class="fa fa-clock-o"></i> 12.10.2015
                                        </div>
                                    </li>
                                    <li class="warning-element">
                                        <strong>file_name.docx</strong>
                                        <span class="label label-warning">CLASSIFIED</span>
                                        <div class="agile-detail">
                                            <a href="#" class="pull-right btn btn-xs btn-danger">Удалить</a>
                                            <a href="#" class="pull-right btn btn-xs btn-warning m-r-xs">Перейти к пакету</a>
                                            <i class="fa fa-clock-o"></i> 12.10.2015
                                        </div>
                                    </li>
                                </ul>
                            </div>
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


    <!-- Mainly scripts -->
    <script src="{{ @BASE }}/ui/js/jquery-2.1.1.js"></script>
    <script src="{{ @BASE }}/ui/js/jquery-ui-1.10.4.min.js"></script>
    <script src="{{ @BASE }}/ui/js/bootstrap.min.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ @BASE }}/ui/js/inspinia.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/pace/pace.min.js"></script>

    <script>
        $(document).ready(function(){

            $(".sortable-list").sortable({
                connectWith: ".connectList"
            }).disableSelection();

        });
    </script>

</body>


</html>
