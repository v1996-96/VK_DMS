<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - {{ @_page_title }}</title>

    <include href="templates/Styles.php" />

    <link href="{{ @BASE }}/ui/css/plugins/jsTree/style.min.css" rel="stylesheet">

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
        <include href="templates/Menu.php" />


        <div id="page-wrapper" class="gray-bg">

            <!-- TopLine -->
            <include href="templates/TopLine.php" />


            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2>{{ @ProjectInfo.Title }}</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/dashboard">Главная</a>
                        </li>
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/projects">Проекты</a>
                        </li>
                        <li class="active">
                            <strong>{{ @ProjectInfo.Title }}</strong>
                        </li>
                    </ol>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h2 class="m-t-none m-b">{{ @ProjectInfo.Title }}</h2>
                                <p>
                                    Статус: 
                                    <check if="{{ @ProjectInfo.Status == 1 }}">
                                        <true><span class="label label-primary">Активный</span></true>
                                        <false><span class="label label-default">Закрытый</span></false>
                                    </check>
                                </p>
                                <p>Отдел: <a href="/{{ @PARAMS.CompanyUrl }}/departments/{{ @ProjectInfo.DepartmentId }}">{{ @ProjectInfo.DepartmentTitle }}</a></p>
                                <p>Дата создания: {{ @ProjectInfo.DateAdd }}</p>

                                <check if="{{ @ProjectInfo.Description }}">
                                    <p>{{ @ProjectInfo.Description }}</p>
                                </check>

                                <check if="{{ @ManagerList }}">
                                    <h4 style="margin: 20px 0 10px 0; border-bottom: 1px solid #787878; padding-bottom: 5px;">Менеджеры</h4>
                                    <div class="project_employee clearfix">
                                        <repeat group="{{ @ManagerList }}" value="{{ @manager }}">
                                            <a href="/{{ @PARAMS.CompanyUrl }}/employee/{{ @manager.UserId }}" 
                                                style="display: block; margin: 5px; float: left;"
                                                title="{{ @manager.Name }} {{ @manager.Surname }}">
                                                <img width="50" height="50" src="{{ @manager.VK_Avatar }}" class="img-circle" />
                                            </a>
                                        </repeat>
                                    </div>
                                </check>

                                <check if="{{ @EmployeeList }}">
                                    <h4 style="margin: 20px 0 10px 0; border-bottom: 1px solid #787878; padding-bottom: 5px;">Сотрудники</h4>
                                    <div class="project_employee clearfix">
                                        <repeat group="{{ @EmployeeList }}" value="{{ @employee }}">
                                            <a href="/{{ @PARAMS.CompanyUrl }}/employee/{{ @employee.UserId }}" 
                                                style="display: block; margin: 5px; float: left;"
                                                title="{{ @employee.Name }} {{ @employee.Surname }}">
                                                <img width="50" height="50" src="{{ @employee.VK_Avatar }}" class="img-circle" />
                                            </a>
                                        </repeat>
                                    </div>
                                </check>

                                
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

    <script src="{{ @BASE }}/ui/js/app/App.js" type="text/javascript"></script>
    <script src="{{ @BASE }}/ui/js/app/pages/ProjectDashboard.js" type="text/javascript"></script>

    <check if="{{ isset(@project_error) }}">
    <script type="text/javascript">
        App.message.show("Ошибка", "{{ @project_error }}");
    </script>
    </check>

</body>


</html>
