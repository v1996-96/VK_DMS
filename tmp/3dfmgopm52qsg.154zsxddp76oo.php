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
                    <h2>Отделы</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/dashboard">Главная</a>
                        </li>
                        <li class="active">
                            <strong>Отделы</strong>
                        </li>
                    </ol>
                </div>
                <?php if ($DepartmentRight_Add): ?>
                    <div class="col-lg-3">
                        <div class="title-action">
                            <a href="#addDepartmentModal" data-toggle="modal" 
                                class="btn btn-success pull-right <?php echo isset($department_add_error) ? 'disabled' : ''; ?>">Добавить</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>


            <div class="wrapper wrapper-content">

                <?php if (isset($department_error)): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $department_error; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($department_add_error)): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $department_add_error; ?>
                    </div>
                <?php endif; ?>
                
                <div class="row">
                    <?php foreach (($DepartmentList?:array()) as $department): ?>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/departments/<?php echo $department['DepartmentId']; ?>">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h3 class="text-center" style="margin-bottom: 20px;"><?php echo $department['Title']; ?></h3>
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <h2><?php echo $department['EmployeeCount']; ?></h2>
                                                <small>сотрудников</small>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <h2><?php echo $department['ProjectCount']; ?></h2>
                                                <small>проектов</small>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <h2><?php echo $department['TaskCount']; ?></h2>
                                                <small>задач</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>


            <!-- Footer -->
            <?php echo $this->render('templates/Footer.php',$this->mime,get_defined_vars(),0); ?>
        </div>


        <!-- RightSidebar -->
        <?php echo $this->render('templates/RightSidebar.php',$this->mime,get_defined_vars(),0); ?>


    </div>


    <?php if ($DepartmentRight_Add): ?>
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
                                <form method="POST" id="createDepartmentForm">
                                    <div class="form-group">
                                        <input type="text" name="Title" class="form-control" placeholder="Название">
                                    </div>

                                    <label>Список администрируемых групп ВК</label>
                                    <?php if (isset($GroupList) && count($GroupList) > 0): ?>
                                        
                                            <ul class="list-group" style="background-color: #fff">
                                                <?php foreach (($GroupList?:array()) as $group): ?>
                                                    <li class="list-group-item">
                                                        <input type="radio" name="VKGroupId" class="i-checks" value="<?php echo $group['gid']; ?>" />
                                                        &nbsp; <?php echo $group['name']; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        
                                        <?php else: ?>
                                            <h4 class="text-center">Для создания отдела необходима группа ВК с правами модератора или выше</h4>
                                        
                                    <?php endif; ?>

                                    <input type="hidden" name="action" value="create" />
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                        <button type="submit" form="createDepartmentForm" name="action" value="create" class="btn btn-primary">Создать</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php echo $this->render('templates/Scripts.php',$this->mime,get_defined_vars(),0); ?>

    <script src="<?php echo $BASE; ?>/ui/js/plugins/iCheck/icheck.min.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/app/App.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
        });
    </script>

</body>


</html>
