<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_TITLE; ?> - <?php echo $_page_title; ?></title>

    <link href="<?php echo $BASE; ?>/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $BASE; ?>/ui/font-awesome/css/font-awesome.css" rel="stylesheet">

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
                    <h2>Редактирование компании</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/dashboard">Главная</a>
                        </li>
                        <li class="active">
                            <strong>Редактирование компании</strong>
                        </li>
                    </ol>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row m-t m-b">
                    <div class="col-md-6 block-center">
                        <div class="ibox">
                            <div class="ibox-content">
                                
                                <form method="POST">
                                    <div class="form-group">
                                        <div id="companyLogo" <?php echo isset($FieldLogo) ? 'style="background-image: url('.$FieldLogo.')"' : ''; ?> 
                                            class="companyLogo" data-toggle="tooltip" data-placement="bottom" 
                                            title="Нажмите, чтобы добавить логотип">
                                            <a href="#" id="imageUpload"></a>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Название</label>
                                        <input id="titleField" type="text" class="form-control">
                                    </div> 

                                    <div class="form-group">
                                        <label>Ссылка</label>
                                        <input id="urlField" type="text" class="form-control">
                                    </div> 

                                    <div class="form-group">
                                        <label>Слоган</label>
                                        <textarea class="form-control"></textarea>
                                    </div>

                                    <div class="form-group text-center">
                                        <a href="#" class="btn btn-primary">Сохранить изменения</a>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="ibox">
                            <div class="ibox-content" style="background-color: rgba(255, 0, 0, 0.25);">
                                <div class="text-center">
                                    <a href="#" class="btn btn-danger">Удалить компанию</a>
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


    <!-- Mainly scripts -->
    <script src="<?php echo $BASE; ?>/ui/js/jquery-2.1.1.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/bootstrap.min.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo $BASE; ?>/ui/js/inspinia.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/plugins/pace/pace.min.js"></script>

    <script src="<?php echo $BASE; ?>/ui/js/ajax_upload.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/jquery.liTranslit.js"></script>

    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $("#titleField").liTranslit({
                elAlias : $("#urlField")
            });

            $.ajax_upload($("#imageUpload"), {
                action: "",
                name: "image",
                data: {
                    action: "imageUpload"
                },
                onSubmit: function(file, ext){
                    this.disable();
                },
                onComplete: function(file, response){
                    this.enable();
                    
                    if (response !== "error") {
                        $("#companyLogo").css("background-image", "url(http://<?php echo $_SERVER['HTTP_HOST']; ?>/"+response+")");
                        $("#companyLogoInput").val( response );
                    }
                }
            });

        })
    </script>

</body>


</html>
