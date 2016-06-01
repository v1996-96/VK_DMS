<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - {{ @_page_title }}</title>

    <link href="{{ @BASE }}/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="{{ @BASE }}/ui/css/plugins/jsTree/style.min.css" rel="stylesheet">

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
                    <h2>Документы</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/dashboard">Главная</a>
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
            <include href="templates/Footer.php" />
        </div>


        <!-- RightSidebar -->
        <include href="templates/RightSidebar.php" />


    </div>


    <include href="templates/Scripts.php" />

    <script src="{{ @BASE }}/ui/js/plugins/jsTree/jstree.min.js"></script>

    <script src="{{ @BASE }}/ui/js/app/App.js" type="text/javascript"></script>

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
