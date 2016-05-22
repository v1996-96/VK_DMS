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

<body class="top-navigation">

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="/logOut">
                                <i class="fa fa-sign-out"></i> Выйти
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>Выберите компанию</h2>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                        <a href="#" data-toggle="modal" data-target="#addCompanyModal" class="btn btn-success">Создать новую</a>
                    </div>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row">

                    <?php foreach (($CompanyList?:array()) as $Company): ?>
                        <div class="col-md-3">
                            <a href="/<?php echo $Company['Url']; ?>/dashboard">
                                <div class="ibox">
                                    <div class="ibox-content product-box">
                                        <div class="company-logo" <?php echo $Company['Logo'] != '' ? 'style="background-image: url(../'.$Company['Logo'].')"' : ''; ?>>
                                            <?php echo $Company['Logo'] == '' ? '[ Логотип ]' : ''; ?>
                                        </div>
                                        <div class="product-desc">
                                            <span class="product-price blue-bg">
                                                <?php echo $Company['CompanyRole']; ?>
                                            </span>
                                            <span class="product-name"><?php echo $Company['Title']; ?></span>
                                            <div class="small m-t-xs">
                                                <?php echo $Company['Slogan']; ?>
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
    </div>


    <div class="modal inmodal" id="addCompanyModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Создание компании</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-9 block-center">
                            <form method="POST" id="companyAddForm">
                                <div class="form-group">
                                    <div id="companyLogo" <?php echo isset($FieldLogo) ? 'style="background-image: url('.$FieldLogo.')"' : ''; ?> 
                                        class="companyLogo" data-toggle="tooltip" data-placement="bottom" 
                                        title="Нажмите, чтобы добавить логотип">
                                        <a href="#" id="imageUpload"></a>
                                    </div>
                                </div>

                                <input type="hidden" name="Logo" value="<?php echo isset($FieldLogo) ? $FieldLogo : ''; ?>" id="companyLogoInput" />

                                <?php if (isset($companyAddError)): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <?php echo $companyAddError; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <input type="text" id="titleField" name="Title" value="<?php echo isset($FieldTitle) ? $FieldTitle : ''; ?>" class="form-control" placeholder="Название">
                                </div>

                                <div class="form-group">
                                    <input type="text" id="urlField" name="Url" value="<?php echo isset($FieldUrl) ? $FieldUrl : ''; ?>" class="form-control" placeholder="Ссылка">
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control" name="Slogan" rows="3" placeholder="Слоган"><?php echo isset($FieldSlogan) ? $FieldSlogan : ''; ?></textarea>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <button type="submit" form="companyAddForm" name="action" value="create" class="btn btn-primary">Создать</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <?php echo $this->render('templates/Scripts.php',$this->mime,get_defined_vars(),0); ?>

    <script src="<?php echo $BASE; ?>/ui/js/ajax_upload.js"></script>
    <script src="<?php echo $BASE; ?>/ui/js/jquery.liTranslit.js"></script>

    <?php if (isset($companyAddError)): ?>
        <script type="text/javascript">
            $(function() {
                $("#addCompanyModal").modal('show');
            });
        </script>
    <?php endif; ?>


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
