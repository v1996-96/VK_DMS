<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - {{ @_page_title }}</title>

    <include href="templates/Styles.php" />

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
                    <h2>{{ @EmployeeData.Name }} {{ @EmployeeData.Surname }}</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/dashboard">Главная</a>
                        </li>
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/employee">Сотрудники</a>
                        </li>
                        <li class="active">
                            <strong>{{ @EmployeeData.Name }} {{ @EmployeeData.Surname }}</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-3">
                    <check if="{{ @EmployeeRights_Edit }}">
                        <div class="title-action">
                            <a href="#editModal" class="btn btn-primary" data-toggle="modal">Редактировать</a>
                        </div>
                    </check>
                </div>
            </div>


            <div class="wrapper wrapper-content">

                <check if="{{ isset(@employee_error) }}">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ @employee_error }}
                    </div>
                </check>
                
                <div class="row m-b-lg m-t-lg">
                    <div class="col-md-4">

                        <div class="profile-image">
                            <img src="{{ @EmployeeData.VK_Avatar }}" class="img-circle circle-border m-b-md" alt="profile">
                        </div>
                        <div class="profile-info">
                            <h2 class="no-margins">
                                {{ @EmployeeData.Name }} {{ @EmployeeData.Surname }}
                            </h2>
                            <h5 class="m-b-xs">{{ @EmployeeData.EmployeeType }}</h5>
                            <div class="m-b-xs"><small>Добавлен: {{ date("m.d.Y", strtotime(@EmployeeData.DateRegistered)) }}</small></div>
                            <a href="http://vk.com/id{{ @EmployeeData.VK }}" target="_blank"><i class="fa fa-external-link"></i> Аккаунт Вконтакте</a>
                            <span class="clearfix"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <small>Отдел:</small>
                        <h3 class="no-margins">{{ @EmployeeData.DepartmentTitle }}</h3>
                        <br>
                        <small>Должность:</small>
                        <h3 class="no-margins">{{ @EmployeeData.DepartmentRole }}</h3>
                    </div>
                    <div class="col-md-3">
                        <!-- <small>Активность за последний месяц</small>
                        <h2 class="no-margins">206</h2>
                        <div id="sparkline1"></div> -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h3 style="margin-bottom: 20px;">Проекты</h3>
                                
                                <check if="{{ @ProjectList }}">
                                    <true>
                                        <table class="table table-hover">
                                            <tbody>
                                                <repeat group="{{ @ProjectList }}" value="{{ @project }}">
                                                    <tr>
                                                        <td class="project-title">
                                                            <a href="/{{ @PARAMS.CompanyUrl }}/projects/{{ @project.ProjectId }}">{{ @project.Title }}</a>
                                                            <br/>
                                                            <small>Дата создания: {{ @project.DateAdd }}</small>
                                                        </td>
                                                        <td class="project-actions">
                                                            <a href="/{{ @PARAMS.CompanyUrl }}/projects/{{ @project.ProjectId }}" class="btn btn-white btn-sm"> Перейти</a>
                                                        </td>
                                                    </tr>
                                                </repeat>
                                            </tbody>
                                        </table>
                                    </true>
                                    <false>
                                        <h4 class="text-center">Проекты отсутствуют</h4>
                                    </false>
                                </check>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h3 style="margin-bottom: 20px;">Задачи</h3>
                                
                                <check if="{{ @TaskList }}">
                                    <true>
                                        <ul class="todo-list m-t small-list">
                                            <repeat group="{{ @TaskList }}" value="{{ @task }}">
                                                <li>
                                                    <span>{{ @task.Title }}</span>
                                                    <check if="{{ @task.Deadline }}">
                                                        <span class="pull-right m-r-xs text-danger">{{ @task.Deadline }}</span>
                                                    </check>
                                                    <div class="m-t-xs">
                                                        Проект: <a href="/{{ @PARAMS.CompanyUrl }}/projects/{{ @task.ProjectId }}">{{ @task.ProjectTitle }}</a>
                                                    </div>
                                                </li>
                                            </repeat>
                                        </ul>
                                    </true>
                                    <false>
                                        <h4 class="text-center">Задачи отсутствуют</h4>
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

    <check if="{{ @EmployeeRights_Edit }}">
    <div class="modal inmodal" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Редактирование профиля</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-sm-7 block-center">
                            <form method="POST">
                                <check if="{{ @EmployeeRights_SetAdmin }}">
                                    <switch expr="{{ @EmployeeData.EmployeeType }}">
                                        <case value="{{ 'Администратор' }}" break="{{ true }}">
                                            <button type="submit" name="action" value="unsetAdmin" class="btn btn-primary btn-block">Сделать сотрудником</button><hr>
                                        </case>
                                        <default>
                                            <button type="submit" name="action" value="setAdmin" class="btn btn-primary btn-block">Сделать администратором</button><hr>
                                        </default>
                                    </switch>
                                </check>
                                <button type="submit" name="action" value="delete" class="btn btn-danger btn-block">Уволить</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </check>

    <include href="templates/Scripts.php" />

    <script src="{{ @BASE }}/ui/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <script src="{{ @BASE }}/ui/js/app/App.js" type="text/javascript"></script>

    <!--<script>
        $(document).ready(function() {


            $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 48], {
                type: 'line',
                width: '100%',
                height: '50',
                lineColor: '#1ab394',
                fillColor: "transparent"
            });


        });
    </script>-->

</body>


</html>
