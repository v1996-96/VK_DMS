<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - {{ @_page_title }}</title>

    <link href="{{ @BASE }}/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="{{ @BASE }}/ui/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

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
                    <h2>Сотрудники</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="/{{ @PARAMS.CompanyUrl }}/dashboard">Главная</a>
                        </li>
                        <li class="active">
                            <strong>Сотрудники</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-3">
                    <div class="title-action pull-right">
                        <a href="#addEmployeeModal" data-toggle="modal" class="btn btn-success">
                            Пригласить 
                            {{ count(@InviteList) > 0 ? '<span class="badge">'.count(@InviteList).'</span>' : '' }}
                        </a>
                    </div>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <div class="row">
                    <div class="col-xs-12">
                        
                        <div class="ibox">
                            <div class="ibox-content">

                                <div class="row m-b">
                                    <div class="col-md-6">
                                        <h2 class="no-margins">Количество: {{ count(@UserList) }}</h2>
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

                                <table class="table table-hover no-margins">
                                    <tbody>
                                        <repeat group="{{ @UserList }}" value="{{ @user }}">
                                            <tr>
                                                <td>
                                                    <img alt="image" width="40" height="40" class="img-circle" src="{{ @user.VK_Avatar }}" />
                                                </td>
                                                <td>
                                                    <a href="/{{ @PARAMS.CompanyUrl }}/employee/{{ @user.id }}">{{ @user.Name }} {{ @user.Surname }}</a>
                                                    <br/>
                                                    <small>Добавлен {{ @user.DateRegistered }}</small>
                                                </td>
                                                <td>
                                                    <small>Тип:</small><br>
                                                    <h5 class="no-margins">{{ @user.Position }}</h5>
                                                </td> 
                                                <td>
                                                    <small>Отдел:</small><br>
                                                    <h5 class="no-margins">{{ @user.DepartmentTitle }}</h5>
                                                </td> 
                                                <td>
                                                    <small>Должность:</small><br>
                                                    <h5 class="no-margins">{{ @user.DepartmentRole }}</h5>
                                                </td> 
                                                <td class="text-right">
                                                    <a href="http://vk.com/id{{ @user.VK }}" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-external-link"></i> &nbsp; VK </a>
                                                    <a href="/{{ @PARAMS.CompanyUrl }}/employee/{{ @user.id }}" class="btn btn-primary btn-sm"> Профиль </a>
                                                </td>
                                            </tr>
                                        </repeat>

                                    </tbody>
                                </table>

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



    <div class="modal inmodal" id="addEmployeeModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <!-- <i class="fa fa-building-o modal-icon"></i> -->
                    <h4 class="modal-title">Добавление сотрудника</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-9 block-center">
                            <check if="{{ isset(@invite_error) }}">
                                <div class="alert alert-danger">
                                    {{ @invite_error }}
                                </div>
                            </check>

                            <form method="POST">
                                <div class="input-group">
                                    <input type="text" name="VK" class="form-control" placeholder="VK ID">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" name="action" value="inviteEmployee" type="submit">Добавить</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                    <h4 class="text-center">Список приглашений</h4>
                    
                    <table id="inviteListTable" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>VK ID</th>
                                <th>Дата отправления</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <repeat group="{{ @InviteList }}" value="{{ @invite }}">
                                <tr>
                                    <td>
                                        <a href="http://vk.com/id{{ @invite.VK }}" target="_blank">id{{ @invite.VK }} <i class="fa fa-external-link"></i></a>
                                    </td>
                                    <td>{{ date("H:i:s d-m-Y", strtotime(@invite.DateAdd)) }}</td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="id" value="{{ @invite.id }}" />

                                            <a href="http://{{ $_SERVER['HTTP_HOST'] }}/invite/{{ @invite.RegistrationToken }}" target="_blank" class="btn btn-warning btn-xs">Перейти</a>
                                            <button name="action" value="deleteInvite" class="btn btn-danger btn-xs">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            </repeat>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


    <include href="templates/Scripts.php" />

    <!-- Data Tables -->
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <script src="{{ @BASE }}/ui/js/app/App.js" type="text/javascript"></script>

    <check if="{{ isset(@invite_error) }}">
        <script type="text/javascript">
            $(function(){
                $("#addEmployeeModal").modal();
            });
        </script>
    </check>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#inviteListTable').DataTable({
                lengthChange: false,
                searching: false,
                info: false
            });
        });
    </script>

</body>


</html>
