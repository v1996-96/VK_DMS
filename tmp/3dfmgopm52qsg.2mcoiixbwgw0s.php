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
                    <div class="col-md-6 col-md-offset-3">
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

                </div>

            </div>


            <!-- Footer -->
            <?php echo $this->render('templates/Footer.php',$this->mime,get_defined_vars(),0); ?>
        </div>


        <!-- RightSidebar -->
        <?php echo $this->render('templates/RightSidebar.php',$this->mime,get_defined_vars(),0); ?>


    </div>



    <?php echo $this->render('templates/Scripts.php',$this->mime,get_defined_vars(),0); ?>

    <script src="<?php echo $BASE; ?>/ui/js/app/App.js" type="text/javascript"></script>
    <script src="<?php echo $BASE; ?>/ui/js/app/pages/ProjectDashboard.js" type="text/javascript"></script>

    <?php if (isset($project_error)): ?>
    <script type="text/javascript">
        App.message.show("Ошибка", "<?php echo $project_error; ?>");
    </script>
    <?php endif; ?>

</body>


</html>
