<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - {{ @_page_title }}</title>

    <link href="{{ @BASE }}/ui/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="{{ @BASE }}/ui/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="{{ @BASE }}/ui/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

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
                <div class="col-lg-8">
                    <h2>Web разработка</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/styleru/dashboard">Главная</a>
                        </li>
                        <li>
                            <a href="/styleru/departments">Отделы</a>
                        </li>
                        <li class="active">
                            <strong>Web разработка</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action text-right">
                        <a href="/styleru/departments/5/documents" class="btn btn-primary"><i class="fa fa-folder-open"></i> Документы &nbsp; <span class="badge">5</span></a>
                        <a href="#editDepartmentModal" data-toggle="modal" class="btn btn-white"><i class="fa fa-cog"></i> Настройки</a>
                    </div>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h4>Пакеты документов</h4>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <h1 class="no-margins text-success"><i class="ion ion-ios-arrow-thin-down"></i> 4</h1>
                                        <small>Входящие</small>
                                    </div>
                                    <div class="col-sm-6">
                                        <h1 class="no-margins text-success"><i class="ion ion-ios-arrow-thin-up"></i> 4</h1>
                                        <small>Исходящие</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h4>Активность</h4>
                                <div id="sparkline1"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Проекты</h5>
                                <h1 class="no-margins text-success">21</h1>
                                <br>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Сотрудники</h5>
                                <h1 class="no-margins text-success">81</h1>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#projectsTab"> Проекты</a></li>
                                <li><a data-toggle="tab" href="#employeeTab"> Сотрудники</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="projectsTab" class="tab-pane active">
                                    <div class="panel-body">

                                        <a href="#" class="btn btn-primary">Создать проект</a>

                                        <hr>

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

                                        <table id="projectList" class="hidden table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Название</th>
                                                    <th>Дата создания</th>
                                                    <th>Сотрудники</th>
                                                    <th>Задачи</th>
                                                    <th>Действия</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Курсовая работа</td>
                                                    <td>12/12/2012 20:15:00</td>
                                                    <td>25</td>
                                                    <td>12</td>
                                                    <td>
                                                        <a href="#" class="btn btn-success btn-xs">Перейти</a>
                                                    </td>
                                                </tr>                                                    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div id="employeeTab" class="tab-pane">
                                    <div class="panel-body">

                                        <a href="#" class="btn btn-primary">Добавить сотрудника</a>
                                        <a href="#" class="btn btn-warning">Добавить руководителя</a>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Руководители</h4>
                                                <table id="departmentEmployeeList" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ФИО</th>
                                                            <th>Действия</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Трушин Виктор</td>
                                                            <td>
                                                                <a href="#" class="btn btn-xs btn-primary">Профиль</a>
                                                                <a href="#" class="btn btn-xs btn-danger">Удалить</a>
                                                            </td>
                                                        </tr>                                      
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-md-6">
                                                <h4>Сотрудники</h4>
                                                <table id="departmentManagerList" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ФИО</th>
                                                            <th>Действия</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Трушин Виктор</td>
                                                            <td>
                                                                <a href="#" class="btn btn-xs btn-primary">Профиль</a>
                                                                <a href="#" class="btn btn-xs btn-danger">Удалить</a>
                                                            </td>
                                                        </tr>                                      
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
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


    <div class="modal inmodal" id="editDepartmentModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <!-- <i class="fa fa-building-o modal-icon"></i> -->
                    <h4 class="modal-title">Редактироваание отдела</h4>
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
                    <button type="button" class="btn btn-primary">Сохранить</button>
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

    <!-- Data Tables -->
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Sparkline -->
    <script src="{{ @BASE }}/ui/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <script>
        $(document).ready(function() {


            $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 48], {
                type: 'line',
                width: '100%',
                height: '50',
                lineColor: '#1ab394',
                fillColor: "transparent"
            });


            $('#projectList').DataTable({
                lengthChange: false,
                searching: false
            });

            $('#departmentEmployeeList').DataTable({
                lengthChange: false,
                searching: false
            });

            $('#departmentManagerList').DataTable({
                lengthChange: false,
                searching: false
            });


        });
    </script>

</body>


</html>
