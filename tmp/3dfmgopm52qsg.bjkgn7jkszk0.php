<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_TITLE; ?> - <?php echo $_page_title; ?></title>

    <?php echo $this->render('templates/Styles.php',$this->mime,get_defined_vars(),0); ?>

    <link href="<?php echo $BASE; ?>/ui/css/plugins/jsTree/style.min.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <!-- Menu -->
        <?php echo $this->render('templates/Menu.php',$this->mime,get_defined_vars(),0); ?>


        <div id="page-wrapper" class="gray-bg">

            <!-- TopLine -->
            <?php echo $this->render('templates/TopLine.php',$this->mime,get_defined_vars(),0); ?>


            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-6">
                    <h2>Документы отдела</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/dashboard">Главная</a>
                        </li>
                        <li>
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/departments">Отделы</a>
                        </li>
                        <li>
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/departments/4">Web разработка</a>
                        </li>
                        <li class="active">
                            <strong>Документы отдела</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-6">
                    <div class="title-action">
                        <a href="#" id="syncDocuments" data-group-id="<?php echo $DepartmentInfo['VKGroupId']; ?>" class="btn btn-white">
                            <i class="fa fa-refresh"></i>&nbsp;
                            Синхронизировать
                        </a>
                    </div>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h3>
                                    Пакеты документов
                                    <div class="pull-right">
                                        <a href="#" id="addPackageBtn" class="btn btn-primary btn-xs">Добавить</a>
                                    </div>
                                </h3>

                                <!-- <div class="m-t m-b package_info hidden">
                                    <a href="#" id="showPackHistory" class="btn btn-primary btn-xs">История пакета</a>
                                    <a href="#" id="deletePack" class="btn btn-danger btn-xs">Удалить пакет</a>
                                </div>

                                <div class="m-t m-b file_info hidden">
                                    <a href="#" id="deleteDocFromPack" class="btn btn-warning btn-xs">Удалить из пакета</a>
                                </div> -->

                                <div id="managedDocuments"></div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h3>
                                    Документы
                                </h3>

                                <div id="notmanagedDocuments"></div>

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

    <script src="<?php echo $BASE; ?>/ui/js/jquery-ui-1.10.4.min.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/jsTree/jstree.min.js"></script>

    <script src="<?php echo $BASE; ?>/ui/js/app/App.js" type="text/javascript"></script>
    <script src="<?php echo $BASE; ?>/ui/js/app/pages/DepartmentDocuments.js" type="text/javascript"></script>

    <?php if (isset($documents_error)): ?>
    <script type="text/javascript">
        App.message.show("Ошибка", "<?php echo $documents_error; ?>");
    </script>
    <?php endif; ?>

</body>


</html>
