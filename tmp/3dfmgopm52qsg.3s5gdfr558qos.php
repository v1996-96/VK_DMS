<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_TITLE; ?> - <?php echo $_page_title; ?></title>

    <link href="<?php echo $BASE; ?>/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo $BASE; ?>/ui/css/plugins/jsTree/style.min.css" rel="stylesheet">

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
                <div class="col-lg-9">
                    <h2>Документы</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/styleru/dashboard">Главная</a>
                        </li>
                        <li class="active">
                            <strong>Документы</strong>
                        </li>
                    </ol>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">

                                <h3>Внутренние документы</h3>
                                <div id="managedDocuments"></div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">

                                <h3>Не обработанные документы</h3>
                                <div id="unmanagedDocuments"></div>

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


    <!-- Mainly scripts -->
    <script src="<?php echo $BASE; ?>/ui/js/jquery-2.1.1.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/bootstrap.min.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo $BASE; ?>/ui/js/inspinia.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/pace/pace.min.js"></script>

    <script src="<?php echo $BASE; ?>/ui/js/plugins/jsTree/jstree.min.js"></script>

    <script type="text/javascript">
        $(function(){
            $("#managedDocuments").jstree({
                'core' : {
                    'check_callback' : true,
                    'data' : [
                        { 
                            'text' : 'Web development', 
                            'type' : 'department',
                            'state' : { 'opened' : true },
                            'children' : [
                                { 
                                    'text' : 'Package1', 
                                    'type' : 'package',
                                    'state' : { 'opened' : true },
                                    'children' : [
                                        {
                                            'text' : 'File1', 
                                            'type' : 'file'
                                        }
                                    ]
                                }
                            ]
                        },
                        { 'text' : 'Web development1', 'type' : 'department' }
                    ]
                },
                'plugins' : [ "dnd", "search", "types" ],
                'types' : {
                    'department' : {
                        'icon' : 'fa fa-cubes'
                    },
                    'package' : {
                        'icon' : 'fa fa-folder'
                    },
                    'file' : {
                        'icon' : 'fa fa-file-o'
                    }

                }
            });
        });
    </script>

</body>


</html>
