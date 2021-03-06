<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_TITLE; ?> - <?php echo $_page_title; ?></title>

    <?php echo $this->render('templates/Styles.php',$this->mime,get_defined_vars(),0); ?>

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
                    <h2><?php echo $EmployeeData['Name']; ?> <?php echo $EmployeeData['Surname']; ?></h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/dashboard">Главная</a>
                        </li>
                        <li>
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/employee">Сотрудники</a>
                        </li>
                        <li class="active">
                            <strong><?php echo $EmployeeData['Name']; ?> <?php echo $EmployeeData['Surname']; ?></strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-3">
                    <?php if ($EmployeeRights_Edit): ?>
                        <div class="title-action">
                            <a href="#editModal" class="btn btn-primary" data-toggle="modal">Редактировать</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


            <div class="wrapper wrapper-content">

                <?php if (isset($employee_error)): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $employee_error; ?>
                    </div>
                <?php endif; ?>
                
                <div class="row m-b-lg m-t-lg">
                    <div class="col-md-4">

                        <div class="profile-image">
                            <img src="<?php echo $EmployeeData['VK_Avatar']; ?>" class="img-circle circle-border m-b-md" alt="profile">
                        </div>
                        <div class="profile-info">
                            <h2 class="no-margins">
                                <?php echo $EmployeeData['Name']; ?> <?php echo $EmployeeData['Surname']; ?>
                            </h2>
                            <h5 class="m-b-xs"><?php echo $EmployeeData['EmployeeType']; ?></h5>
                            <div class="m-b-xs"><small>Добавлен: <?php echo date("m.d.Y", strtotime($EmployeeData['DateRegistered'])); ?></small></div>
                            <a href="http://vk.com/id<?php echo $EmployeeData['VK']; ?>" target="_blank"><i class="fa fa-external-link"></i> Аккаунт Вконтакте</a>
                            <span class="clearfix"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <small>Отдел:</small>
                        <h3 class="no-margins"><?php echo $EmployeeData['DepartmentTitle']; ?></h3>
                        <br>
                        <small>Должность:</small>
                        <h3 class="no-margins"><?php echo $EmployeeData['DepartmentRole']; ?></h3>
                    </div>
                    <div class="col-md-3">
                        <!-- <small>Активность за последний месяц</small>
                        <h2 class="no-margins">206</h2>
                        <div id="sparkline1"></div> -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h3 style="margin-bottom: 20px;">Проекты</h3>
                                
                                <?php if ($ProjectList): ?>
                                    
                                        <table class="table table-hover">
                                            <tbody>
                                                <?php foreach (($ProjectList?:array()) as $project): ?>
                                                    <tr>
                                                        <td class="project-title">
                                                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/projects/<?php echo $project['ProjectId']; ?>"><?php echo $project['Title']; ?></a>
                                                            <br/>
                                                            <small>Дата создания: <?php echo $project['DateAdd']; ?></small>
                                                        </td>
                                                        <td class="project-actions">
                                                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/projects/<?php echo $project['ProjectId']; ?>" class="btn btn-white btn-sm"> Перейти</a>
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
                    </div>

                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h3 style="margin-bottom: 20px;">Задачи</h3>
                                
                                <?php if ($TaskList): ?>
                                    
                                        <ul class="todo-list m-t small-list">
                                            <?php foreach (($TaskList?:array()) as $task): ?>
                                                <li>
                                                    <span><?php echo $task['Title']; ?></span>
                                                    <?php if ($task['Deadline']): ?>
                                                        <span class="pull-right m-r-xs text-danger"><?php echo $task['Deadline']; ?></span>
                                                    <?php endif; ?>
                                                    <div class="m-t-xs">
                                                        Проект: <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/projects/<?php echo $task['ProjectId']; ?>"><?php echo $task['ProjectTitle']; ?></a>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    
                                    <?php else: ?>
                                        <h4 class="text-center">Задачи отсутствуют</h4>
                                    
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

    <?php if ($EmployeeRights_Edit): ?>
    <div class="modal inmodal" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Редактирование профиля</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-sm-7 block-center">
                            <form method="POST">
                                <?php if ($EmployeeRights_SetAdmin): ?>
                                    <?php switch ($EmployeeData['EmployeeType']): ?><?php case 'Администратор': ?>
                                            <button type="submit" name="action" value="unsetAdmin" class="btn btn-primary btn-block">Сделать сотрудником</button><hr>
                                        <?php if (true) break; ?><?php default: ?>
                                            <button type="submit" name="action" value="setAdmin" class="btn btn-primary btn-block">Сделать администратором</button><hr>
                                        <?php break; ?><?php endswitch; ?>
                                <?php endif; ?>
                                <button type="submit" name="action" value="delete" class="btn btn-danger btn-block">Уволить</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php echo $this->render('templates/Scripts.php',$this->mime,get_defined_vars(),0); ?>

    <script src="<?php echo $BASE; ?>/ui/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <script src="<?php echo $BASE; ?>/ui/js/app/App.js" type="text/javascript"></script>

    <!--<script>
        $(document).ready(function() {


            $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 48], {
                type: 'line',
                width: '100%',
                height: '50',
                lineColor: '#1ab394',
                fillColor: "transparent"
            });


        });
    </script>-->

</body>


</html>
