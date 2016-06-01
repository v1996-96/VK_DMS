<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - {{ @_page_title }}</title>

    <link href="{{ @BASE }}/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/plugins/iCheck/custom.css" rel="stylesheet">

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
                    <h2>Отделы</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/dashboard">Главная</a>
                        </li>
                        <li class="active">
                            <strong>Отделы</strong>
                        </li>
                    </ol>
                </div>
                <check if="{{ @DepartmentRight_Add }}">
                    <div class="col-lg-3">
                        <div class="title-action">
                            <a href="#addDepartmentModal" data-toggle="modal" 
                                class="btn btn-success pull-right {{ isset(@department_add_error) ? 'disabled' : '' }}">Добавить</a>
                        </div>
                    </div>
                </check>
            </div>


            <div class="wrapper wrapper-content">

                <check if="{{ isset(@department_error) }}">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ @department_error }}
                    </div>
                </check>
                
                <div class="row">
                    <repeat group="{{ @DepartmentList }}" value="{{ @department }}">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <a href="/{{ @PARAMS.CompanyUrl }}/departments/{{ @department.DepartmentId }}">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h3 class="text-center" style="margin-bottom: 20px;">{{ @department.Title }}</h3>
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <h2>{{ @department.EmployeeCount }}</h2>
                                                <small>сотрудников</small>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <h2>{{ @department.ProjectCount }}</h2>
                                                <small>проектов</small>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <h2>{{ @department.TaskCount }}</h2>
                                                <small>задач</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </repeat>
                </div>

            </div>


            <!-- Footer -->
            <include href="templates/Footer.php" />
        </div>


        <!-- RightSidebar -->
        <include href="templates/RightSidebar.php" />


    </div>


    <check if="{{ @DepartmentRight_Add }}">
        <div class="modal inmodal" id="addDepartmentModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <!-- <i class="fa fa-building-o modal-icon"></i> -->
                        <h4 class="modal-title">Создание отдела</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-md-9 block-center">
                                <form method="POST" id="createDepartmentForm">
                                    <div class="form-group">
                                        <input type="text" name="Title" class="form-control" placeholder="Название">
                                    </div>

                                    <label>Список администрируемых групп ВК</label>
                                    <check if="{{ isset(@GroupList) && count(@GroupList) > 0 }}">
                                        <true>
                                            <ul class="list-group" style="background-color: #fff">
                                                <repeat group="{{ @GroupList }}" value="{{ @group }}">
                                                    <li class="list-group-item">
                                                        <input type="radio" name="VKGroupId" class="i-checks" value="{{ @group.gid }}" />
                                                        &nbsp; {{ @group.name }}
                                                    </li>
                                                </repeat>
                                            </ul>
                                        </true>
                                        <false>
                                            <h4 class="text-center">Для создания отдела необходима группа ВК с правами модератора или выше</h4>
                                        </false>
                                    </check>

                                    <input type="hidden" name="action" value="create" />
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                        <button type="submit" form="createDepartmentForm" name="action" value="create" class="btn btn-primary">Создать</button>
                    </div>
                </div>
            </div>
        </div>
    </check>


    <include href="templates/Scripts.php" />

    <script src="{{ @BASE }}/ui/js/plugins/iCheck/icheck.min.js"></script>
    <script src="{{ @BASE }}/ui/js/app/App.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
        });
    </script>

</body>


</html>
