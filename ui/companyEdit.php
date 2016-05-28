<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - {{ @_page_title }}</title>

    <link href="{{ @BASE }}/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="{{ @BASE }}/ui/css/animate.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/style.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <!-- Menu -->
        <include href="templates/Menu.php" />


        <div id="page-wrapper" class="gray-bg">

            <!-- TopLine -->
            <include href="templates/TopLine.php" />


            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2>Редактирование компании</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/dashboard">Главная</a>
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
                                        <div id="companyLogo" {{ isset(@FieldLogo) ? 'style="background-image: url('.@FieldLogo.')"' : '' }} 
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
            <include href="templates/Footer.php" />
        </div>


        <!-- RightSidebar -->
        <include href="templates/RightSidebar.php" />


    </div>


    <!-- Mainly scripts -->
    <script src="{{ @BASE }}/ui/js/jquery-2.1.1.js"></script>
    <script src="{{ @BASE }}/ui/js/bootstrap.min.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ @BASE }}/ui/js/inspinia.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/pace/pace.min.js"></script>

    <script src="{{ @BASE }}/ui/js/ajax_upload.js"></script>
    <script src="{{ @BASE }}/ui/js/jquery.liTranslit.js"></script>

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
                        $("#companyLogo").css("background-image", "url(http://{{ @_SERVER['HTTP_HOST'] }}/"+response+")");
                        $("#companyLogoInput").val( response );
                    }
                }
            });

        })
    </script>

</body>


</html>
