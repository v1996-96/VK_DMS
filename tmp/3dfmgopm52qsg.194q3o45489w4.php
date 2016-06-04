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

                <?php if ($company_error): ?> 
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $company_error; ?>
                    </div>
                <?php endif; ?>
                
                <div class="row m-t m-b">
                    <div class="col-md-6 block-center">
                        <div class="ibox">
                            <div class="ibox-content">
                                
                                <form method="POST">
                                    <div class="form-group">
                                        <div id="companyLogo" <?php echo isset($FieldLogo) ? 'style="background-image: url(../'.$FieldLogo.')"' : ''; ?> 
                                            class="companyLogo" data-toggle="tooltip" data-placement="bottom" 
                                            title="Нажмите, чтобы добавить логотип">
                                            <a href="#" id="imageUpload"></a>
                                        </div>
                                    </div>

                                    <input type="hidden" name="Logo" id="companyLogoInput" value="<?php echo $FieldLogo; ?>" />

                                    <div class="form-group">
                                        <label>Название</label>
                                        <input id="titleField" name="Title" value="<?php echo $FieldTitle; ?>" type="text" class="form-control">
                                    </div> 

                                    <div class="form-group">
                                        <label>Ссылка</label>
                                        <input id="urlField" name="Url" value="<?php echo $FieldUrl; ?>" type="text" class="form-control">
                                    </div> 

                                    <div class="form-group">
                                        <label>Слоган</label>
                                        <textarea name="Slogan" class="form-control"><?php echo $FieldSlogan; ?></textarea>
                                    </div>

                                    <div class="form-group text-center">
                                        <button type="submit" name="action" value="edit" class="btn btn-primary">Сохранить изменения</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="ibox">
                            <div class="ibox-content" style="background-color: rgba(255, 0, 0, 0.25);">
                                <div class="text-center">
                                    <form method="POST">
                                        <button name="action" value="remove" class="btn btn-danger">Удалить компанию</button>
                                    </form>
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


    <?php echo $this->render('templates/Scripts.php',$this->mime,get_defined_vars(),0); ?>

    <script src="<?php echo $BASE; ?>/ui/js/ajax_upload.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/jquery.liTranslit.js"></script>

    <script src="<?php echo $BASE; ?>/ui/js/app/App.js" type="text/javascript"></script>

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
