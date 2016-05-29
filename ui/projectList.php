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
                    <h2>Проекты</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/dashboard">Главная</a>
                        </li>
                        <li class="active">
                            <strong>Проекты</strong>
                        </li>
                    </ol>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row">
                    <div class="col-xs-12">
                        
                        <div class="ibox">
                            <div class="ibox-content">

                                <div class="row m-b">
                                    <div class="col-md-6">
                                        <h2 class="no-margins">Количество: {{ count(@ProjectList) }}</h2>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Поиск...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-white" type="button"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <check if="{{ @ProjectList }}">
                                    <true>
                                        <table class="table table-hover no-margins">
                                            <tbody>
                                                <repeat group="{{ @ProjectList }}" value="{{ @project }}">
                                                    <tr>
                                                        <td class="project-status">
                                                            <check if="{{ @project.Status == 1 }}">
                                                                <true>
                                                                    <span class="label label-primary">Активный</span>
                                                                </true>
                                                                <false>
                                                                    <span class="label label-default">Закрытый</span>
                                                                </false>
                                                            </check>
                                                        </td>
                                                        <td class="project-title">
                                                            <a href="/{{ @PARAMS.CompanyUrl }}/projects/{{ @project.ProjectId }}">{{ @project.Title }}</a>
                                                            <br/>
                                                            <small>Дата создания: {{ @project.DateAdd }}</small>
                                                        </td>
                                                        <td class="project-completion">
                                                            <small>Отдел:</small><br>
                                                            <h5 class="no-margins">{{ @project.DepartmentTitle }}</h5>
                                                        </td>
                                                        <td class="project-completion">
                                                            <small>Задач:</small><br>
                                                            <h5 class="no-margins">{{ @project.TaskCount }}</h5>
                                                        </td>
                                                        <td class="project-completion">
                                                            <small>Сотрудников:</small><br>
                                                            <h5 class="no-margins">{{ @project.EmployeeCount }}</h5>
                                                        </td>
                                                        <td class="project-actions">
                                                            <a href="/{{ @PARAMS.CompanyUrl }}/projects/{{ @project.ProjectId }}" class="btn btn-success btn-sm">Перейти</a>
                                                        </td>
                                                    </tr>
                                                </repeat>
                                            </tbody>
                                        </table>
                                    </true>
                                    <false>
                                        <h4 class="text-center" style="padding-top: 10px;">Проекты отсутствуют</h4>
                                    </false>
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


    <!-- Mainly scripts -->
    <script src="{{ @BASE }}/ui/js/jquery-2.1.1.js"></script>
    <script src="{{ @BASE }}/ui/js/bootstrap.min.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ @BASE }}/ui/js/inspinia.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/pace/pace.min.js"></script>

</body>


</html>
