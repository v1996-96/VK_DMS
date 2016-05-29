<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_TITLE; ?> - <?php echo $_page_title; ?></title>

    <link href="<?php echo $BASE; ?>/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/css/plugins/iCheck/custom.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="<?php echo $BASE; ?>/ui/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

    <link href="<?php echo $BASE; ?>/ui/css/animate.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/css/style.css" rel="stylesheet">

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
        <?php echo $this->render('templates/Menu.php',$this->mime,get_defined_vars(),0); ?>


        <div id="page-wrapper" class="gray-bg">

            <!-- TopLine -->
            <?php echo $this->render('templates/TopLine.php',$this->mime,get_defined_vars(),0); ?>


            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2><?php echo $ProjectInfo['Title']; ?></h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/dashboard">Главная</a>
                        </li>
                        <li>
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/projects">Проекты</a>
                        </li>
                        <li class="active">
                            <strong><?php echo $ProjectInfo['Title']; ?></strong>
                        </li>
                    </ol>
                </div>
            </div>


            <div class="wrapper wrapper-content">

                <?php if ($project_error): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $project_error; ?>
                    </div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h2 class="m-t-none m-b"><?php echo $ProjectInfo['Title']; ?></h2>
                                <p>
                                    Статус: 
                                    <?php if ($ProjectInfo['Status'] == 1): ?>
                                        <span class="label label-primary">Активный</span>
                                        <?php else: ?><span class="label label-default">Закрытый</span>
                                    <?php endif; ?>
                                </p>
                                <p>Отдел: <?php echo $ProjectInfo['DepartmentTitle']; ?></p>
                                <p>Дата создания: <?php echo $ProjectInfo['DateAdd']; ?></p>

                                <?php if ($ProjectInfo['Description']): ?>
                                    <p><?php echo $ProjectInfo['Description']; ?></p>
                                <?php endif; ?>

                                <?php if ($ManagerList): ?>
                                    <h4 style="margin: 20px 0 10px 0; border-bottom: 1px solid #787878; padding-bottom: 5px;">Менеджеры</h4>
                                    <div class="project_employee clearfix">
                                        <?php foreach (($ManagerList?:array()) as $manager): ?>
                                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/employee/<?php echo $manager['UserId']; ?>" 
                                                style="display: block; margin: 5px; float: left;"
                                                title="<?php echo $manager['Name']; ?> <?php echo $manager['Surname']; ?>">
                                                <img width="50" height="50" src="<?php echo $manager['VK_Avatar']; ?>" class="img-circle" />
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($EmployeeList): ?>
                                    <h4 style="margin: 20px 0 10px 0; border-bottom: 1px solid #787878; padding-bottom: 5px;">Сотрудники</h4>
                                    <div class="project_employee clearfix">
                                        <?php foreach (($EmployeeList?:array()) as $employee): ?>
                                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/employee/<?php echo $employee['UserId']; ?>" 
                                                style="display: block; margin: 5px; float: left;"
                                                title="<?php echo $employee['Name']; ?> <?php echo $employee['Surname']; ?>">
                                                <img width="50" height="50" src="<?php echo $employee['VK_Avatar']; ?>" class="img-circle" />
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                
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
                                        <?php if ($ManagerList): ?>
                                            
                                                <table id="projectEmployeeList" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ФИО</th>
                                                            <th>Действия</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach (($ManagerList?:array()) as $manager): ?>
                                                            <tr>
                                                                <td><?php echo $manager['Name']; ?> <?php echo $manager['Surname']; ?></td>
                                                                <td>
                                                                    <form method="POST">
                                                                        <input type="hidden" name="UserId" value="<?php echo $manager['UserId']; ?>" />
                                                                        <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/employee/<?php echo $manager['UserId']; ?>" class="btn btn-xs btn-primary">Профиль</a>
                                                                        <button type="submit" name="action" value="deleteManager" class="btn btn-xs btn-danger">Удалить</button>
                                                                    </form>
                                                                </td>
                                                            </tr>   
                                                        <?php endforeach; ?>                                   
                                                    </tbody>
                                                </table>
                                            
                                            <?php else: ?>
                                                <p>Менеджеры отсутствуют</p>
                                            
                                        <?php endif; ?>

                                        <h4 style="margin: 30px 0 10px 0; border-bottom: 1px solid #787878; padding-bottom: 5px;">Сотрудники</h4>
                                        <?php if ($EmployeeList): ?>
                                            
                                                <table id="projectManagerList" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ФИО</th>
                                                            <th>Действия</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach (($EmployeeList?:array()) as $employee): ?>
                                                            <tr>
                                                                <td><?php echo $employee['Name']; ?> <?php echo $employee['Surname']; ?></td>
                                                                <td>
                                                                    <form method="POST">
                                                                        <input type="hidden" name="UserId" value="<?php echo $employee['UserId']; ?>" />
                                                                        <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/employee/<?php echo $employee['UserId']; ?>" class="btn btn-xs btn-primary">Профиль</a>
                                                                        <button type="submit" name="action" value="deleteEmployee" class="btn btn-xs btn-danger">Удалить</button>
                                                                    </form>
                                                                </td>
                                                            </tr>   
                                                        <?php endforeach; ?>                                     
                                                    </tbody>
                                                </table>
                                            
                                            <?php else: ?>
                                                <p>Сотрудники отсутствуют</p>
                                            
                                        <?php endif; ?>
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
                                                            <?php echo $ProjectInfo['Status'] ? 'checked="checked"' : "" ;; ?> /> Активный
                                                    </label>
                                                    <label class="m-r-sm" style="font-weight: normal;">
                                                        <input type="radio" name="Status" value="0" 
                                                            <?php echo $ProjectInfo['Status'] ? "" : 'checked="checked"' ;; ?> /> Закрытый
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Название</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="Title" value="<?php echo $ProjectInfo['Title']; ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Описание</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" name="Description"><?php echo $ProjectInfo['Description']; ?></textarea>
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
            <?php echo $this->render('templates/Footer.php',$this->mime,get_defined_vars(),0); ?>
        </div>


        <!-- RightSidebar -->
        <?php echo $this->render('templates/RightSidebar.php',$this->mime,get_defined_vars(),0); ?>


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
                                    <?php foreach (($DepartmentEmployeeList?:array()) as $index=>$employee): ?>
                                        <tr>
                                            <td><input class="i-checks" type="checkbox" name="employeeList[<?php echo $index; ?>]" value="<?php echo $employee['UserId']; ?>" /></td>
                                            <td><?php echo $employee['Name']; ?> <?php echo $employee['Surname']; ?></td>
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
                                    <?php foreach (($DepartmentEmployeeList?:array()) as $employee): ?>
                                        <tr>
                                            <td><input class="i-checks" type="checkbox" name="employeeList[<?php echo $index; ?>]" value="<?php echo $employee['UserId']; ?>" /></td>
                                            <td><?php echo $employee['Name']; ?> <?php echo $employee['Surname']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
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
    <script src="<?php echo $BASE; ?>/ui/js/jquery-2.1.1.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/bootstrap.min.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Data Tables -->
    <script src="<?php echo $BASE; ?>/ui/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo $BASE; ?>/ui/js/inspinia.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/pace/pace.min.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/iCheck/icheck.min.js"></script>


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
