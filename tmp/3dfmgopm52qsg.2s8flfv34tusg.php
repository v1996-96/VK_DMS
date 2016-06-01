<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_TITLE; ?> - <?php echo $_page_title; ?></title>

    <link href="<?php echo $BASE; ?>/ui/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="<?php echo $BASE; ?>/ui/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="<?php echo $BASE; ?>/ui/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

    <link href="<?php echo $BASE; ?>/ui/css/plugins/iCheck/custom.css" rel="stylesheet">

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
                <div class="col-lg-8">
                    <h2><?php echo $DepartmentSummary['Title']; ?></h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/dashboard">Главная</a>
                        </li>
                        <li>
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/departments">Отделы</a>
                        </li>
                        <li class="active">
                            <strong><?php echo $DepartmentSummary['Title']; ?></strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action text-right">
                        <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/departments/<?php echo $PARAMS['DepartmentId']; ?>/documents" class="btn btn-primary"><i class="fa fa-folder-open"></i> Документы &nbsp; <span class="badge">5</span></a>
                        <?php if ($DepartmentRight_Edit): ?>
                            <a href="#editDepartmentModal" data-toggle="modal" class="btn btn-white"><i class="fa fa-cog"></i> Настройки</a>
                        <?php endif; ?>
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
                    <div class="col-md-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h4>Пакеты документов</h4>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <h1 class="no-margins text-success">
                                            <i class="ion ion-ios-arrow-thin-down"></i> 
                                            <?php echo $DepartmentSummary['IncomingPackageCount']; ?>
                                        </h1>
                                        <small>Входящие</small>
                                    </div>
                                    <div class="col-sm-6">
                                        <h1 class="no-margins text-success">
                                            <i class="ion ion-ios-arrow-thin-up"></i> 
                                            <?php echo $DepartmentSummary['OutcomingPackageCount']; ?>
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
                                <h1 class="no-margins text-success"><?php echo $DepartmentSummary['ProjectCount']; ?></h1>
                                <br>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Сотрудники</h5>
                                <h1 class="no-margins text-success"><?php echo $DepartmentSummary['TaskCount']; ?></h1>
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

                                        <?php if ($DepartmentRight_AddProject): ?>
                                            <a href="#addProjectModal" data-toggle="modal" class="btn btn-primary">Создать проект</a>
                                            <br><br>
                                        <?php endif; ?>

                                        <?php if ($ProjectList): ?>
                                            
                                                <table class="table table-hover no-margins">
                                                    <tbody>
                                                        <?php foreach (($ProjectList?:array()) as $project): ?>
                                                            <tr>
                                                                <td class="project-status">
                                                                    <?php if ($project['Status'] == 1): ?>
                                                                        <span class="label label-primary">Активный</span>
                                                                        <?php else: ?><span class="label label-default">Завершен</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td class="project-title">
                                                                    <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/projects/<?php echo $project['ProjectId']; ?>"><?php echo $project['Title']; ?></a>
                                                                    <br/>
                                                                    <small>Дата создания: <?php echo $project['DateAdd']; ?></small>
                                                                </td>
                                                                <td class="project-completion">
                                                                    <small>Задач:</small><br>
                                                                    <h5 class="no-margins"><?php echo $project['TaskCount']; ?></h5>
                                                                </td>
                                                                <td class="project-completion">
                                                                    <small>Сотрудников:</small><br>
                                                                    <h5 class="no-margins"><?php echo $project['EmployeeCount']; ?></h5>
                                                                </td>
                                                                <td class="project-actions">
                                                                    <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/projects/<?php echo $project['ProjectId']; ?>" class="btn btn-success btn-sm">Перейти</a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            
                                            <?php else: ?>
                                                <h4 class="text-center">Проекты отсутствуют</h4>
                                            
                                        <?php endif; ?>

                                    </div>
                                </div>

                                <div id="employeeTab" class="tab-pane">
                                    <div class="panel-body">

                                        <?php if ($DepartmentRight_AddManager): ?>
                                            <a href="#addManagerModal" data-toggle="modal" class="btn btn-warning">Добавить руководителя</a>
                                        <?php endif; ?>
                                        <?php if ($DepartmentRight_AddEmployee): ?>
                                            <a href="#addEmployeeModal" data-toggle="modal" class="btn btn-primary">Добавить сотрудника</a>
                                        <?php endif; ?>

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
                                                        <?php foreach (($ManagerList?:array()) as $manager): ?>
                                                            <tr>
                                                                <td><?php echo $manager['Name']; ?> <?php echo $manager['Surname']; ?></td>
                                                                <td><?php echo $manager['RoleDescription']; ?></td>
                                                                <td>
                                                                    <form method="POST">
                                                                        <input type="hidden" name="EmployeeId" value="<?php echo $manager['UserId']; ?>" />
                                                                        <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/employee/<?php echo $manager['UserId']; ?>" class="btn btn-xs btn-primary">Профиль</a>
                                                                        <?php if ($DepartmentRight_DeleteManager): ?>
                                                                            <button type="submit" name="action" value="deleteEmployee" class="btn btn-xs btn-danger">Удалить</button>
                                                                        <?php endif; ?>
                                                                    </form>
                                                                </td>
                                                            </tr> 
                                                        <?php endforeach; ?>                                     
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
                                                        <?php foreach (($EmployeeList?:array()) as $employee): ?>
                                                            <tr>
                                                                <td><?php echo $employee['Name']; ?> <?php echo $employee['Surname']; ?></td>
                                                                <td><?php echo $employee['RoleDescription']; ?></td>
                                                                <td>
                                                                    <form method="POST">
                                                                        <input type="hidden" name="EmployeeId" value="<?php echo $employee['UserId']; ?>" />
                                                                        <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/employee/<?php echo $employee['UserId']; ?>" class="btn btn-xs btn-primary">Профиль</a>
                                                                        <?php if ($DepartmentRight_DeleteEmployee): ?>
                                                                            <button type="submit" name="action" value="deleteEmployee" class="btn btn-xs btn-danger">Удалить</button>
                                                                        <?php endif; ?>
                                                                    </form>
                                                                </td>
                                                            </tr> 
                                                        <?php endforeach; ?>                                     
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
            <?php echo $this->render('templates/Footer.php',$this->mime,get_defined_vars(),0); ?>
        </div>


        <!-- RightSidebar -->
        <?php echo $this->render('templates/RightSidebar.php',$this->mime,get_defined_vars(),0); ?>


    </div>


    <?php if ($DepartmentRight_Edit): ?>
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
                                            <input type="text" name="Title" class="form-control" placeholder="Название" value="<?php echo $DepartmentSummary['Title']; ?>">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="submit" name="action" value="edit">Изменить</button>
                                            </span>
                                        </div>
                                    </div>

                                    <label>Список администрируемых групп ВК</label>
                                        <?php if (isset($GroupList) && count($GroupList) > 0): ?>
                                            
                                                <ul class="list-group" style="background-color: #fff">
                                                    <?php foreach (($GroupList?:array()) as $group): ?>
                                                        <li class="list-group-item">
                                                            <input type="radio" name="VKGroupId" class="i-checks" value="<?php echo $group['gid']; ?>"
                                                                    <?php echo $DepartmentSummary['VKGroupId'] == $group['gid'] ? 'checked="checked"' : ''; ?> />
                                                            &nbsp; <?php echo $group['name']; ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            
                                            <?php else: ?>
                                                <h4 class="text-center">Для создания отдела необходима группа ВК с правами модератора или выше</h4>
                                            
                                        <?php endif; ?>
                                </form>
                            </div>

                            <?php if ($DepartmentRight_Delete): ?>
                                <hr>
                                <div class="col-md-6 block-center">
                                    <form method="POST">
                                        <div class="form-group">
                                            <button type="submit" name="action" value="remove" class="btn btn-danger btn-block">Удалить отдел</button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

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
                                            <?php foreach (($EmployeeFullList?:array()) as $employee): ?>
                                                <tr class="projectEmployeeRow">
                                                    <td><input data-type="manager" type="checkbox" name="managerList[]" value="<?php echo $employee['UserId']; ?>" /></td>
                                                    <td><input data-type="employee" type="checkbox" name="employeeList[]" value="<?php echo $employee['UserId']; ?>" /></td>
                                                    <td><?php echo $employee['Name']; ?> <?php echo $employee['Surname']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
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
                                    <?php foreach (($FreeCompanyEmployeeList?:array()) as $index=>$employee): ?>
                                        <tr>
                                            <td><input class="i-checks" type="checkbox" name="employeeList[<?php echo $index; ?>]" value="<?php echo $employee['UserId']; ?>" /></td>
                                            <td><?php echo $employee['Name']; ?> <?php echo $employee['Surname']; ?></td>
                                            <td><input type="text" class="form-control input-sm" name="roleDescription[<?php echo $index; ?>]" /></td>
                                        </tr>
                                    <?php endforeach; ?>
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
                                    <?php foreach (($FreeCompanyEmployeeList?:array()) as $employee): ?>
                                        <tr>
                                            <td><input class="i-checks" type="checkbox" name="employeeList[<?php echo $index; ?>]" value="<?php echo $employee['UserId']; ?>" /></td>
                                            <td><?php echo $employee['Name']; ?> <?php echo $employee['Surname']; ?></td>
                                            <td><input type="text" class="form-control input-sm" name="roleDescription[<?php echo $index; ?>]" /></td>
                                        </tr>
                                    <?php endforeach; ?>
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





    <?php echo $this->render('templates/Scripts.php',$this->mime,get_defined_vars(),0); ?>

    <!-- Data Tables -->
    <script src="<?php echo $BASE; ?>/ui/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/dataTables/dataTables.tableTools.min.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/iCheck/icheck.min.js"></script>

    <!-- Sparkline -->
    <script src="<?php echo $BASE; ?>/ui/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <script src="<?php echo $BASE; ?>/ui/js/app/App.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {


            $("#sparkline1").sparkline(<?php echo json_encode($DepartmentActivity); ?>, {
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
