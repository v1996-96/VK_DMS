<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - {{ @_page_title }}</title>

    <include href="templates/Styles.php" />

    <link href="{{ @BASE }}/ui/css/plugins/jsTree/style.min.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <!-- Menu -->
        <include href="templates/Menu.php" />


        <div id="page-wrapper" class="gray-bg">

            <!-- TopLine -->
            <include href="templates/TopLine.php" />


            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-6">
                    <h2>Документы отдела</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/dashboard">Главная</a>
                        </li>
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/departments">Отделы</a>
                        </li>
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/departments/4">Web разработка</a>
                        </li>
                        <li class="active">
                            <strong>Документы отдела</strong>
                        </li>
                    </ol>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h3>
                                    Пакеты документов
                                </h3>

                                <div id="managedDocuments"></div>

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


    <include href="templates/Scripts.php" />

    <script src="{{ @BASE }}/ui/js/jquery-ui-1.10.4.min.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/jsTree/jstree.min.js"></script>

    <script src="{{ @BASE }}/ui/js/app/App.js" type="text/javascript"></script>
    <script src="{{ @BASE }}/ui/js/app/pages/DepartmentDocumentsView.js" type="text/javascript"></script>

    <check if="{{ isset(@documents_error) }}">
    <script type="text/javascript">
        App.message.show("Ошибка", "{{ @documents_error }}");
    </script>
    </check>

</body>


</html>
