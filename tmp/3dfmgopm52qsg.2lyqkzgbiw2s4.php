<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_TITLE; ?> - <?php echo $_page_title; ?></title>

    <?php echo $this->render('templates/Styles.php',$this->mime,get_defined_vars(),0); ?>

    <link href="<?php echo $BASE; ?>/ui/css/plugins/jsTree/style.min.css" rel="stylesheet">

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
    .loading{
        position: absolute;
        background: rgba(255, 255, 255, 0.7);
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 100;
        /*display: flex;*/
        display: none;
        justify-content: center;
        align-items: center;
    }
    .processing > .loading{
        display: flex;
    }
    .vakata-context{
        z-index: 10000;
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
                                <p>Отдел: <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/departments/<?php echo $ProjectInfo['DepartmentId']; ?>"><?php echo $ProjectInfo['DepartmentTitle']; ?></a></p>
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
                                <?php if ($ProjectRight_ManageEmployees): ?>
                                    <li class=""><a data-toggle="tab" href="#employeeTab"> Исполнители</a></li>
                                <?php endif; ?>
                                <?php if ($ProjectRight_Edit): ?>
                                    <li class=""><a data-toggle="tab" href="#settingsTab"> Настройки</a></li>
                                <?php endif; ?>
                            </ul>
                            <div class="tab-content">
                                <div id="tasksTab" class="tab-pane active">
                                    <div class="panel-body">

                                        <div class="loading"><span><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span></div>

                                        <?php if ($ProjectRight_AddTask): ?>
                                            <form method="POST">
                                                <div class="input-group">
                                                    <input type="text" name="Title" class="form-control" placeholder="Наименование задачи">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary" type="submit" name="action" value="addTask"><i class="fa fa-plus"></i></button>
                                                    </span>
                                                </div>
                                            </form>
                                        <?php endif; ?>

                                        <ul id="OpenTaskList" class="todo-list m-t m-b">
                                            <?php foreach (($TaskListOpen?:array()) as $task): ?>
                                                <li class="custom" data-id="<?php echo $task['TaskId']; ?>">
                                                    <a href="#taskDescription" data-id="<?php echo $task['TaskId']; ?>" class="task-item" data-toggle="modal">
                                                        <span class="sort-toggle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>
                                                        <?php if ($ProjectRight_CompleteTask): ?>
                                                            <input type="checkbox" name="IsClosed" class="i-checks"/>
                                                        <?php endif; ?>
                                                        <span class="m-l-xs"><?php echo $task['Title']; ?></span>
                                                        <?php if ($task['Deadline']): ?>
                                                            <small class="pull-right"><?php echo $task['Deadline']; ?></small>
                                                        <?php endif; ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>

                                        <p id="ShowClosedTaskList" class="text-center <?php echo count($TaskListClosed) > 0 ? '' : 'hidden'; ?>">
                                            <a href="#" id="toggleClosed" class="btn btn-white btn-sm">Просмотреть завершенные (<?php echo count($TaskListClosed); ?>)</a>
                                        </p>

                                        <ul id="ClosedTaskList" class="todo-list disabled m-t m-b hidden">
                                            <?php foreach (($TaskListClosed?:array()) as $task): ?>
                                                <li class="custom" data-id="<?php echo $task['TaskId']; ?>">
                                                    <a href="#taskDescription" data-id="<?php echo $task['TaskId']; ?>" class="task-item" data-toggle="modal">
                                                        <span class="sort-toggle hidden"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>
                                                        <?php if ($ProjectRight_CompleteTask): ?>
                                                            <input type="checkbox" name="IsClosed" class="i-checks" checked="checked" />
                                                        <?php endif; ?>
                                                        <span class="m-l-xs"><?php echo $task['Title']; ?></span>
                                                        <?php if ($task['Deadline']): ?>
                                                            <small class="pull-right"><?php echo $task['Deadline']; ?></small>
                                                        <?php endif; ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>

                                    </div>
                                </div>

                                <?php if ($ProjectRight_ManageEmployees): ?>
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
                                <?php endif; ?>

                                <?php if ($ProjectRight_Edit): ?>
                                    <div id="settingsTab" class="tab-pane">
                                        <div class="panel-body">
                                            
                                            <form class="form-horizontal" method="POST">
                                                <div class="form-group">
                                                    <label for="titleInput" class="col-sm-2 control-label">Статус</label>
                                                    <div class="col-sm-8" style="padding-top: 7px">
                                                        <label class="checkbox-inline">
                                                            <input class="i-checks" type="radio" name="Status" value="1"
                                                                <?php echo $ProjectInfo['Status'] ? 'checked="checked"' : "" ;; ?> />&nbsp;
                                                            <strong>Активный</strong>
                                                        </label>
                                                        <label class="checkbox-inline">
                                                            <input class="i-checks" type="radio" name="Status" value="0"
                                                                <?php echo $ProjectInfo['Status'] ? "" : 'checked="checked"' ;; ?> />&nbsp;
                                                            <strong>Закрытый</strong>
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

                                            <?php if ($ProjectRight_Delete): ?>
                                                <hr>
                                                <form method="POST" class="text-center" style="padding: 10px 0; background-color: rgba(255, 0, 0, 0.25);">
                                                    <button class="btn btn-danger" type="submit" name="action" value="deleteProject">Удалить проект</button>
                                                </form>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                <?php endif; ?>

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


    <?php if ($ProjectRight_ManageEmployees): ?>
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
    <?php endif; ?>


    <div class="modal inmodal" id="packageResolveModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Передача пакетов документов</h4>
                </div>
                <div class="modal-body">
                    
                    <form method="POST" id="resolveForm">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Пакет</th>
                                    <th>Отдел</th>
                                </tr>
                            </thead>
                            <tbody id="packageResolveList"></tbody>
                        </table>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <button type="submit" name="action" value="transferPackages" form="resolveForm" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="taskDescription" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    
                    <form class="hidden" id="TaskSummaryBlock" method="POST">
                        <div class="form-group">
                            <h2 class="no-margins" id="TaskTitle"></h2>
                        </div>

                        <div class="form-group">
                            <div class="hidden">Дата создания: 
                                <span id="DateAddBlock"></span>
                            </div>
                            <div class="hidden">Дата закрытия: 
                                <span id="DateClosedBlock"></span>
                            </div>
                            <div class="m-t-xs">
                                Статус: 
                                <span class="label label-primary hidden" id="TaskOpenedStatus">Открытая</span>
                                <span class="label label-default hidden" id="TaskClosedStatus">Завершенная</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <p id="TaskDescription"></p>
                        </div>

                        <div class="form-group">
                            <label>Крайний срок: </label>
                            <p id="TaskDeadline"></p>
                        </div>

                        <div class="form-group">
                            <label>Пакеты документов</label>
                            <div id="packageList"></div>
                            <p class="info-block hidden" id="packageListEmpty">Пакеты документов отсутствуют</p>
                        </div>
                    </form>

                    <?php if ($ProjectRight_EditTask): ?>
                    <form class="hidden form-horizontal" id="TaskEditForm" method="POST">
                        <div class="form-group">
                            <div class="col-sm-6 hidden">
                                <label>Дата создания</label>    
                                <p id="CreateDateField">2016-06-04 18:24:00</p>                            
                            </div>
                            <div class="col-sm-6 hidden">
                                <label>Дата закрытия</label>
                                <p id="ClosedDateField">2016-06-04 18:24:00</p>
                            </div>
                        </div>

                        <div class="form-group hidden">
                            <label for="TaskTitleField" class="col-sm-2 control-label">Статус</label>
                            <div class="col-sm-9">
                                <label class="checkbox-inline">
                                    <input id="TaskOpenedField" class="i-checks" type="radio" name="IsClosed" value="0" />&nbsp;
                                    <strong>Открытая</strong>
                                </label>
                                <label class="checkbox-inline">
                                    <input id="TaskClosedField" class="i-checks" type="radio" name="IsClosed" value="1" />&nbsp;
                                    <strong>Завершенная</strong>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="TaskTitleField" class="col-sm-2 control-label">Название</label>
                            <div class="col-sm-9">
                                <input name="Title" type="text" class="form-control" id="TaskTitleField">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="TaskDescriptionField" class="col-sm-2 control-label">Описание</label>
                            <div class="col-sm-9">
                                <textarea name="Description" class="form-control" id="TaskDescriptionField"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="TaskDeadlineField" class="col-sm-2 control-label">Крайний срок</label>
                            <div class="col-sm-9">
                                <input name="Deadline" type="text" class="form-control" id="TaskDeadlineField">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Пакеты документов</label>
                            <div class="col-sm-9" id="TaskPackagesWrap"></div>
                        </div>
                    </form>
                    <?php endif; ?>

                    <div class="hidden" id="TaskSummaryError">
                        <h3 class="text-center">Ошибка получения данных задачи</h3>
                    </div>

                </div>
                <div class="modal-footer">
                    <?php if ($ProjectRight_DeleteTask): ?>
                        <form method="POST" class="pull-left">
                            <input type="hidden" name="TaskId" id="TaskIdDeleteField" />
                            <button type="submit" name="action" value="deleteTask" class="btn btn-danger">Удалить</button>
                        </form>
                    <?php endif; ?>

                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <?php if ($ProjectRight_EditTask): ?>
                        <button type="button" class="btn btn-success" id="EditTask">Редактировать</button>
                    <?php endif; ?>
                    <button type="submit" name="action" value="editTask" class="btn btn-primary hidden" form="TaskEditForm" id="SaveTask">Сохранить</button>
                </div>
            </div>
        </div>
    </div>



    <?php echo $this->render('templates/Scripts.php',$this->mime,get_defined_vars(),0); ?>

    <script src="<?php echo $BASE; ?>/ui/js/jquery-ui-1.10.4.min.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/iCheck/icheck.min.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/jsTree/jstree.min.js"></script>

    <script src="<?php echo $BASE; ?>/ui/js/plugins/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>

    <script src="<?php echo $BASE; ?>/ui/js/app/App.js" type="text/javascript"></script>
    <script src="<?php echo $BASE; ?>/ui/js/app/pages/ProjectDashboard.js" type="text/javascript"></script>

    <?php if (isset($project_error)): ?>
    <script type="text/javascript">
        App.message.show("Ошибка", "<?php echo $project_error; ?>");
    </script>
    <?php endif; ?>

</body>


</html>
