<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - {{ @_page_title }}</title>

    <include href="templates/Styles.php" />
    
    <!-- Data Tables -->
    <link href="{{ @BASE }}/ui/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

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
                    <h2>{{ @DepartmentSummary.Title }}</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/dashboard">Главная</a>
                        </li>
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/departments">Отделы</a>
                        </li>
                        <li class="active">
                            <strong>{{ @DepartmentSummary.Title }}</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action text-right">
                        <check if="{{ @DepartmentRight_ViewDocs }}">
                            <a href="/{{ @PARAMS.CompanyUrl }}/departments/{{ @PARAMS.DepartmentId }}/documents" class="btn btn-primary">
                                <i class="fa fa-folder-open"></i> 
                                Документы 
                                <check if="{{ @DeletedDoucumentsCount > 0 }}">
                                    &nbsp;<span class="badge">{{ @DeletedDoucumentsCount }}</span>
                                </check>
                            </a>
                        </check>
                        <check if="{{ @DepartmentRight_Edit }}">
                            <a href="#editDepartmentModal" data-toggle="modal" class="btn btn-white"><i class="fa fa-cog"></i> Настройки</a>
                        </check>
                    </div>
                </div>
            </div>


            <div class="wrapper wrapper-content">

                <check if="{{ isset(@department_error) }}">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ @department_error }}
                    </div>
                </check>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h4>Пакеты документов</h4>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <h1 class="no-margins text-success">
                                            <i class="ion ion-ios-arrow-thin-down"></i> 
                                            {{ @DepartmentSummary.IncomingPackageCount }}
                                        </h1>
                                        <small>Входящие</small>
                                    </div>
                                    <div class="col-sm-6">
                                        <h1 class="no-margins text-success">
                                            <i class="ion ion-ios-arrow-thin-up"></i> 
                                            {{ @DepartmentSummary.OutcomingPackageCount }}
                                        </h1>
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
                                <h1 class="no-margins text-success">{{ @DepartmentSummary.ProjectCount }}</h1>
                                <br>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Задачи</h5>
                                <h1 class="no-margins text-success">{{ @DepartmentSummary.TaskCount }}</h1>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-b">
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#projectsTab"> Проекты</a></li>
                                <li><a data-toggle="tab" href="#employeeTab"> Сотрудники</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="projectsTab" class="tab-pane active">
                                    <div class="panel-body">

                                        <check if="{{ @DepartmentRight_AddProject }}">
                                            <a href="#addProjectModal" data-toggle="modal" class="btn btn-primary">Создать проект</a>
                                            <br><br>
                                        </check>

                                        <check if="{{ @ProjectList }}">
                                            <true>
                                                <table class="table table-hover no-margins">
                                                    <tbody>
                                                        <repeat group="{{ @ProjectList }}" value="{{ @project }}">
                                                            <tr>
                                                                <td class="project-status">
                                                                    <check if="{{ @project.Status == 1 }}">
                                                                        <true><span class="label label-primary">Активный</span></true>
                                                                        <false><span class="label label-default">Завершен</span></false>
                                                                    </check>
                                                                </td>
                                                                <td class="project-title">
                                                                    <a href="/{{ @PARAMS.CompanyUrl }}/projects/{{ @project.ProjectId }}">{{ @project.Title }}</a>
                                                                    <br/>
                                                                    <small>Дата создания: {{ @project.DateAdd }}</small>
                                                                </td>
                                                                <td class="project-completion">
                                                                    <small>Задач:</small><br>
                                                                    <h5 class="no-margins">{{ @project.TaskCount }}</h5>
                                                                </td>
                                                                <td class="project-completion">
                                                                    <small>Сотрудников:</small><br>
                                                                    <h5 class="no-margins">{{ @project.EmployeeCount }}</h5>
                                                                </td>
                                                                <td class="project-actions">
                                                                    <a href="/{{ @PARAMS.CompanyUrl }}/projects/{{ @project.ProjectId }}" class="btn btn-success btn-sm">Перейти</a>
                                                                </td>
                                                            </tr>
                                                        </repeat>
                                                    </tbody>
                                                </table>
                                            </true>
                                            <false>
                                                <h4 class="text-center">Проекты отсутствуют</h4>
                                            </false>
                                        </check>

                                    </div>
                                </div>

                                <div id="employeeTab" class="tab-pane">
                                    <div class="panel-body">

                                        <check if="{{ @DepartmentRight_AddManager }}">
                                            <a href="#addManagerModal" data-toggle="modal" class="btn btn-warning">Добавить руководителя</a>
                                        </check>
                                        <check if="{{ @DepartmentRight_AddEmployee }}">
                                            <a href="#addEmployeeModal" data-toggle="modal" class="btn btn-primary">Добавить сотрудника</a>
                                        </check>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>Руководители</h4>
                                                <table id="departmentEmployeeList" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ФИО</th>
                                                            <th>Должность</th>
                                                            <th>Действия</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <repeat group="{{ @ManagerList }}" value="{{ @manager }}">
                                                            <tr>
                                                                <td>{{ @manager.Name }} {{ @manager.Surname }}</td>
                                                                <td>{{ @manager.RoleDescription }}</td>
                                                                <td>
                                                                    <form method="POST">
                                                                        <input type="hidden" name="EmployeeId" value="{{ @manager.UserId }}" />
                                                                        <a href="/{{ @PARAMS.CompanyUrl }}/employee/{{ @manager.UserId }}" class="btn btn-xs btn-primary">Профиль</a>
                                                                        <check if="{{ @DepartmentRight_DeleteManager }}">
                                                                            <button type="submit" name="action" value="deleteEmployee" class="btn btn-xs btn-danger">Удалить</button>
                                                                        </check>
                                                                    </form>
                                                                </td>
                                                            </tr> 
                                                        </repeat>                                     
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-md-6">
                                                <h4>Сотрудники</h4>
                                                <table id="departmentManagerList" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ФИО</th>
                                                            <th>Должность</th>
                                                            <th>Действия</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <repeat group="{{ @EmployeeList }}" value="{{ @employee }}">
                                                            <tr>
                                                                <td>{{ @employee.Name }} {{ @employee.Surname }}</td>
                                                                <td>{{ @employee.RoleDescription }}</td>
                                                                <td>
                                                                    <form method="POST">
                                                                        <input type="hidden" name="EmployeeId" value="{{ @employee.UserId }}" />
                                                                        <a href="/{{ @PARAMS.CompanyUrl }}/employee/{{ @employee.UserId }}" class="btn btn-xs btn-primary">Профиль</a>
                                                                        <check if="{{ @DepartmentRight_DeleteEmployee }}">
                                                                            <button type="submit" name="action" value="deleteEmployee" class="btn btn-xs btn-danger">Удалить</button>
                                                                        </check>
                                                                    </form>
                                                                </td>
                                                            </tr> 
                                                        </repeat>                                     
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


    <check if="{{ @DepartmentRight_Edit }}">
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
                                <form method="POST">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="Title" class="form-control" placeholder="Название" value="{{ @DepartmentSummary.Title }}">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="submit" name="action" value="edit">Изменить</button>
                                            </span>
                                        </div>
                                    </div>

                                    <label>Список администрируемых групп ВК</label>
                                        <check if="{{ isset(@GroupList) && count(@GroupList) > 0 }}">
                                            <true>
                                                <ul class="list-group" style="background-color: #fff">
                                                    <repeat group="{{ @GroupList }}" value="{{ @group }}">
                                                        <li class="list-group-item">
                                                            <input type="radio" name="VKGroupId" class="i-checks" value="{{ @group.gid }}"
                                                                    {{ @DepartmentSummary.VKGroupId == @group.gid ? 'checked="checked"' : '' }} />
                                                            &nbsp; {{ @group.name }}
                                                        </li>
                                                    </repeat>
                                                </ul>
                                            </true>
                                            <false>
                                                <h4 class="text-center">Для создания отдела необходима группа ВК с правами модератора или выше</h4>
                                            </false>
                                        </check>
                                </form>
                            </div>

                            <check if="{{ @DepartmentRight_Delete }}">
                                <hr>
                                <div class="col-md-6 block-center">
                                    <form method="POST">
                                        <div class="form-group">
                                            <button type="submit" name="action" value="remove" class="btn btn-danger btn-block">Удалить отдел</button>
                                        </div>
                                    </form>
                                </div>
                            </check>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </check>

    <div class="modal inmodal" id="addProjectModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <!-- <i class="fa fa-building-o modal-icon"></i> -->
                    <h4 class="modal-title">Создание проекта</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-9 block-center">

                            <form method="POST">
                                <div class="form-group">
                                    <label>Название</label>
                                    <input type="text" name="Title" class="form-control" />
                                </div>

                                <div class="form-group">
                                    <label>Описание</label>
                                    <textarea name="Description" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <table id="newProjectEmployeeList" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Менеджер</th>
                                                <th>Сотрудник</th>
                                                <th>Имя</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <repeat group="{{ @EmployeeFullList }}" value="{{ @employee }}">
                                                <tr class="projectEmployeeRow">
                                                    <td><input data-type="manager" type="checkbox" name="managerList[]" value="{{ @employee.UserId }}" /></td>
                                                    <td><input data-type="employee" type="checkbox" name="employeeList[]" value="{{ @employee.UserId }}" /></td>
                                                    <td>{{ @employee.Name }} {{ @employee.Surname }}</td>
                                                </tr>
                                            </repeat>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" name="action" value="createProject" class="btn btn-primary">Создать проект</button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
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
                    
                    <form method="POST">
                        <div class="form-group">
                            <table id="freeCompanyEmployeeList" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Выбрать</th>
                                        <th>Имя</th>
                                        <th>Описание</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <repeat group="{{ @FreeCompanyEmployeeList }}" key="{{ @index }}" value="{{ @employee }}">
                                        <tr>
                                            <td><input class="i-checks" type="checkbox" name="employeeList[{{ @index }}]" value="{{ @employee.UserId }}" /></td>
                                            <td>{{ @employee.Name }} {{ @employee.Surname }}</td>
                                            <td><input type="text" class="form-control input-sm" name="roleDescription[{{ @index }}]" /></td>
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
                    <h4 class="modal-title">Добавление руководителя</h4>
                </div>
                <div class="modal-body">
                    
                    <form method="POST">
                        <div class="form-group">
                            <table id="freeCompanyEmployeeList" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Выбрать</th>
                                        <th>Имя</th>
                                        <th>Описание</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <repeat group="{{ @FreeCompanyEmployeeList }}" value="{{ @employee }}">
                                        <tr>
                                            <td><input class="i-checks" type="checkbox" name="employeeList[{{ @index }}]" value="{{ @employee.UserId }}" /></td>
                                            <td>{{ @employee.Name }} {{ @employee.Surname }}</td>
                                            <td><input type="text" class="form-control input-sm" name="roleDescription[{{ @index }}]" /></td>
                                        </tr>
                                    </repeat>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary" name="action" value="addManagers">Добавить руководителей</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>





    <include href="templates/Scripts.php" />

    <!-- Data Tables -->
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.tableTools.min.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/iCheck/icheck.min.js"></script>

    <!-- Sparkline -->
    <script src="{{ @BASE }}/ui/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <script src="{{ @BASE }}/ui/js/app/App.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {


            $("#sparkline1").sparkline({{ json_encode(@DepartmentActivity) }}, {
                type: 'line',
                width: '100%',
                height: '50',
                lineColor: '#1ab394',
                fillColor: "transparent"
            });


            $('#projectList, #departmentEmployeeList, #departmentManagerList').DataTable({
                lengthChange: false,
                searching: false
            });

            $("#newProjectEmployeeList, #freeCompanyEmployeeList").DataTable({
                lengthChange : false,
                searching : false,
                info : false
            });

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            $("#newProjectEmployeeList").on("click", ".projectEmployeeRow input[type='checkbox']", function(e){
                var current = $(this).attr("data-type");

                if (current == "manager" &&
                    $(this).parents("tr").find("[data-type='employee']").is(":checked")) {
                    e.preventDefault();
                    return false;
                }
                if (current == "employee" &&
                    $(this).parents("tr").find("[data-type='manager']").is(":checked")) {
                    e.preventDefault();
                    return false;
                }
            });


        });
    </script>

</body>


</html>
