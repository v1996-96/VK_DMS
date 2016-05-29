<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - {{ @_page_title }}</title>

    <link href="{{ @BASE }}/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/plugins/iCheck/custom.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="{{ @BASE }}/ui/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

    <link href="{{ @BASE }}/ui/css/animate.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/style.css" rel="stylesheet">

    <style type="text/css">
    .sort-toggle{
        font-size: 16px;
        float: left;
        letter-spacing: 3px;
        margin-right: 6px;
    }
    .task-item,
    .task-item:hover,
    .task-item:active{
        color: #333;
        outline: none;
    }
    </style>

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
                    <h2>{{ @ProjectInfo.Title }}</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/dashboard">Главная</a>
                        </li>
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/projects">Проекты</a>
                        </li>
                        <li class="active">
                            <strong>{{ @ProjectInfo.Title }}</strong>
                        </li>
                    </ol>
                </div>
            </div>


            <div class="wrapper wrapper-content">

                <check if="{{ @project_error }}">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ @project_error }}
                    </div>
                </check>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h2 class="m-t-none m-b">{{ @ProjectInfo.Title }}</h2>
                                <p>
                                    Статус: 
                                    <check if="{{ @ProjectInfo.Status == 1 }}">
                                        <true><span class="label label-primary">Активный</span></true>
                                        <false><span class="label label-default">Закрытый</span></false>
                                    </check>
                                </p>
                                <p>Отдел: {{ @ProjectInfo.DepartmentTitle }}</p>
                                <p>Дата создания: {{ @ProjectInfo.DateAdd }}</p>

                                <check if="{{ @ProjectInfo.Description }}">
                                    <p>{{ @ProjectInfo.Description }}</p>
                                </check>

                                <check if="{{ @ManagerList }}">
                                    <h4 style="margin: 20px 0 10px 0; border-bottom: 1px solid #787878; padding-bottom: 5px;">Менеджеры</h4>
                                    <div class="project_employee clearfix">
                                        <repeat group="{{ @ManagerList }}" value="{{ @manager }}">
                                            <a href="/{{ @PARAMS.CompanyUrl }}/employee/{{ @manager.UserId }}" 
                                                style="display: block; margin: 5px; float: left;"
                                                title="{{ @manager.Name }} {{ @manager.Surname }}">
                                                <img width="50" height="50" src="{{ @manager.VK_Avatar }}" class="img-circle" />
                                            </a>
                                        </repeat>
                                    </div>
                                </check>

                                <check if="{{ @EmployeeList }}">
                                    <h4 style="margin: 20px 0 10px 0; border-bottom: 1px solid #787878; padding-bottom: 5px;">Сотрудники</h4>
                                    <div class="project_employee clearfix">
                                        <repeat group="{{ @EmployeeList }}" value="{{ @employee }}">
                                            <a href="/{{ @PARAMS.CompanyUrl }}/employee/{{ @employee.UserId }}" 
                                                style="display: block; margin: 5px; float: left;"
                                                title="{{ @employee.Name }} {{ @employee.Surname }}">
                                                <img width="50" height="50" src="{{ @employee.VK_Avatar }}" class="img-circle" />
                                            </a>
                                        </repeat>
                                    </div>
                                </check>

                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tasksTab"> Задачи</a></li>
                                <li class=""><a data-toggle="tab" href="#employeeTab"> Исполнители</a></li>
                                <li class=""><a data-toggle="tab" href="#settingsTab"> Настройки</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tasksTab" class="tab-pane active">
                                    <div class="panel-body">

                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Наименование задачи">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button"><i class="fa fa-plus"></i></button>
                                            </span>
                                        </div>

                                        <ul class="todo-list m-t m-b">
                                            <li>
                                                <a href="#taskDescription" class="task-item" data-toggle="modal">
                                                    <span class="sort-toggle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>
                                                    <input type="checkbox" value="" name="" class="i-checks"/>
                                                    <span class="m-l-xs">Buy a milk</span>
                                                    <small class="pull-right"> 12/12/2012 12:05:00</small>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="task-item">
                                                    <span class="sort-toggle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>
                                                    <input type="checkbox" value="" name="" class="i-checks"/>
                                                    <span class="m-l-xs">Buy a milk</span>
                                                    <small class="pull-right"> 12/12/2012 12:05:00</small>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="task-item">
                                                    <span class="sort-toggle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>
                                                    <input type="checkbox" value="" name="" class="i-checks"/>
                                                    <span class="m-l-xs">Buy a milk</span>
                                                    <small class="pull-right"> 12/12/2012 12:05:00</small>
                                                </a>
                                            </li>
                                        </ul>

                                        <p class="text-center">
                                            <a class="btn btn-white btn-sm">Просмотреть завершенные (120)</a>
                                        </p>

                                    </div>
                                </div>

                                <div id="employeeTab" class="tab-pane">
                                    <div class="panel-body">
                                        <a href="#addManagerModal" data-toggle="modal" class="btn btn-warning">Добавить менеджера</a>
                                        <a href="#addEmployeeModal" data-toggle="modal" class="btn btn-primary">Добавить сотрудника</a>

                                        <h4 style="margin: 10px 0 10px 0; border-bottom: 1px solid #787878; padding-bottom: 5px;">Менеджеры</h4>
                                        <check if="{{ @ManagerList }}">
                                            <true>
                                                <table id="projectEmployeeList" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ФИО</th>
                                                            <th>Действия</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <repeat group="{{ @ManagerList }}" value="{{ @manager }}">
                                                            <tr>
                                                                <td>{{ @manager.Name }} {{ @manager.Surname }}</td>
                                                                <td>
                                                                    <form method="POST">
                                                                        <input type="hidden" name="UserId" value="{{ @manager.UserId }}" />
                                                                        <a href="/{{ @PARAMS.CompanyUrl }}/employee/{{ @manager.UserId }}" class="btn btn-xs btn-primary">Профиль</a>
                                                                        <button type="submit" name="action" value="deleteManager" class="btn btn-xs btn-danger">Удалить</button>
                                                                    </form>
                                                                </td>
                                                            </tr>   
                                                        </repeat>                                   
                                                    </tbody>
                                                </table>
                                            </true>
                                            <false>
                                                <p>Менеджеры отсутствуют</p>
                                            </false>
                                        </check>

                                        <h4 style="margin: 30px 0 10px 0; border-bottom: 1px solid #787878; padding-bottom: 5px;">Сотрудники</h4>
                                        <check if="{{ @EmployeeList }}">
                                            <true>
                                                <table id="projectManagerList" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ФИО</th>
                                                            <th>Действия</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <repeat group="{{ @EmployeeList }}" value="{{ @employee }}">
                                                            <tr>
                                                                <td>{{ @employee.Name }} {{ @employee.Surname }}</td>
                                                                <td>
                                                                    <form method="POST">
                                                                        <input type="hidden" name="UserId" value="{{ @employee.UserId }}" />
                                                                        <a href="/{{ @PARAMS.CompanyUrl }}/employee/{{ @employee.UserId }}" class="btn btn-xs btn-primary">Профиль</a>
                                                                        <button type="submit" name="action" value="deleteEmployee" class="btn btn-xs btn-danger">Удалить</button>
                                                                    </form>
                                                                </td>
                                                            </tr>   
                                                        </repeat>                                     
                                                    </tbody>
                                                </table>
                                            </true>
                                            <false>
                                                <p>Сотрудники отсутствуют</p>
                                            </false>
                                        </check>
                                    </div>
                                </div>

                                <div id="settingsTab" class="tab-pane">
                                    <div class="panel-body">
                                        
                                        <form class="form-horizontal" method="POST">
                                            <div class="form-group">
                                                <label for="titleInput" class="col-sm-2 control-label">Статус</label>
                                                <div class="col-sm-8" style="padding-top: 7px">
                                                    <label class="m-r-sm" style="font-weight: normal;">
                                                        <input type="radio" name="Status" value="1" 
                                                            {{ @ProjectInfo.Status ? 'checked="checked"' : "" ; }} /> Активный
                                                    </label>
                                                    <label class="m-r-sm" style="font-weight: normal;">
                                                        <input type="radio" name="Status" value="0" 
                                                            {{ @ProjectInfo.Status ? "" : 'checked="checked"' ; }} /> Закрытый
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Название</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="Title" value="{{ @ProjectInfo.Title }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Описание</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" name="Description">{{ @ProjectInfo.Description }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <button type="submit" name="action" value="editProject" class="btn btn-primary">Сохранить</button>
                                                </div>
                                            </div>
                                        </form>

                                        <hr>

                                        <form method="POST" class="text-center" style="padding: 10px 0; background-color: rgba(255, 0, 0, 0.25);">
                                            <button class="btn btn-danger" type="submit" name="action" value="deleteProject">Удалить проект</button>
                                        </form>

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



    <div class="modal inmodal" id="addEmployeeModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <!-- <i class="fa fa-building-o modal-icon"></i> -->
                    <h4 class="modal-title">Добавление сотрудников</h4>
                </div>
                <div class="modal-body">
                    
                    <form method="POST">
                        <div class="form-group">
                            <table class="departmentEmployeeList table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Выбрать</th>
                                        <th>Имя</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <repeat group="{{ @DepartmentEmployeeList }}" key="{{ @index }}" value="{{ @employee }}">
                                        <tr>
                                            <td><input class="i-checks" type="checkbox" name="employeeList[{{ @index }}]" value="{{ @employee.UserId }}" /></td>
                                            <td>{{ @employee.Name }} {{ @employee.Surname }}</td>
                                        </tr>
                                    </repeat>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary" name="action" value="addEmployees">Добавить сотрудников</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="modal inmodal" id="addManagerModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <!-- <i class="fa fa-building-o modal-icon"></i> -->
                    <h4 class="modal-title">Добавление менеджеров</h4>
                </div>
                <div class="modal-body">
                    
                    <form method="POST">
                        <div class="form-group">
                            <table class="departmentEmployeeList table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Выбрать</th>
                                        <th>Имя</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <repeat group="{{ @DepartmentEmployeeList }}" value="{{ @employee }}">
                                        <tr>
                                            <td><input class="i-checks" type="checkbox" name="employeeList[{{ @index }}]" value="{{ @employee.UserId }}" /></td>
                                            <td>{{ @employee.Name }} {{ @employee.Surname }}</td>
                                        </tr>
                                    </repeat>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary" name="action" value="addManagers">Добавить менеджеров</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="taskDescription" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Редактирование задачи</h4>
                </div>
                <div class="modal-body">
                    
                    <form>
                        <div class="form-group">
                            <label>Наименование</label>
                            <h2 class="no-margins">Задача 2</h2>
                            <input type="text" class="form-control hidden">
                        </div>

                        <div class="form-group">
                            <label>Описание</label>
                            <p>бла бла бла</p>
                            <input type="email" class="form-control hidden">
                        </div>

                        <div class="form-group">
                            <label>Дата завершения</label>
                            <p>12/12/2012 12:05:00</p>
                            <input type="email" class="form-control hidden">
                        </div>
                    </form>

                    

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

    <!-- Data Tables -->
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ @BASE }}/ui/js/inspinia.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/pace/pace.min.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/iCheck/icheck.min.js"></script>


    <script type="text/javascript">
        $(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            $(".departmentEmployeeList").DataTable({
                lengthChange : false,
                searching : false,
                info : false
            });
        });
    </script>

</body>


</html>
