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
                            <a href="/styleru/dashboard">Главная</a>
                        </li>
                        <li class="active">
                            <strong>Сотрудники</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-3">
                    <div class="title-action">
                        <a href="#addEmployeeModal" data-toggle="modal" class="btn btn-success pull-right">Добавить</a>
                        <!-- <div class="btn-group pull-right" style="margin-right: 10px;">
                            <button type="button" class="btn btn-white"><i class="fa fa-th-large"></i></button>
                            <button type="button" class="btn btn-white"><i class="fa fa-th-list"></i></button>
                        </div> -->
                    </div>
                </div>
            </div>


            <div class="wrapper wrapper-content">
                
                <!-- <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="contact-box text-center" style="padding-bottom: 10px;">
                            <a href="/styleru/employee/4">
                                <img alt="image" width="100" class="img-circle m-t-xs" src="{{ @BASE }}/ui/img/a2.jpg">
                                <h3 style="margin-top: 15px; margin-bottom: 0;">Трушин Виктор</h3>
                                <small>Web разработчик</small>
                                <p style="margin-top: 10px;"><i class="fa fa-cubes"></i> Отдел разработки</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="contact-box text-center" style="padding-bottom: 10px;">
                            <a href="profile.html">
                                <img alt="image" width="100" class="img-circle m-t-xs" src="{{ @BASE }}/ui/img/a2.jpg">
                                <h3 style="margin-top: 15px; margin-bottom: 0;">Трушин Виктор</h3>
                                <small>Web разработчик</small>
                                <p style="margin-top: 10px;"><i class="fa fa-cubes"></i> Отдел разработки</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="contact-box text-center" style="padding-bottom: 10px;">
                            <a href="profile.html">
                                <img alt="image" width="100" class="img-circle m-t-xs" src="{{ @BASE }}/ui/img/a2.jpg">
                                <h3 style="margin-top: 15px; margin-bottom: 0;">Трушин Виктор</h3>
                                <small>Web разработчик</small>
                                <p style="margin-top: 10px;"><i class="fa fa-cubes"></i> Отдел разработки</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="contact-box text-center" style="padding-bottom: 10px;">
                            <a href="profile.html">
                                <img alt="image" width="100" class="img-circle m-t-xs" src="{{ @BASE }}/ui/img/a2.jpg">
                                <h3 style="margin-top: 15px; margin-bottom: 0;">Трушин Виктор</h3>
                                <small>Web разработчик</small>
                                <p style="margin-top: 10px;"><i class="fa fa-cubes"></i> Отдел разработки</p>
                            </a>
                        </div>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col-xs-12">
                        
                        <div class="ibox">
                            <div class="ibox-content">

                                <div class="row m-b">
                                    <div class="col-md-6">
                                        <h2 class="no-margins">Количество: 201</h2>
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
                                        <tr>
                                            <td>
                                                <img alt="image" width="40" height="40" class="img-circle" src="{{ @BASE }}/ui/img/a1.jpg" />
                                            </td>
                                            <td>
                                                <a href="project_detail.html">Трушин Виктор</a>
                                                <br/>
                                                <small>Добавлен 12.12.2015</small>
                                            </td>
                                            <td>
                                                <small>Тип:</small><br>
                                                <h5 class="no-margins">Администратор</h5>
                                            </td> 
                                            <td>
                                                <small>Отдел:</small><br>
                                                <h5 class="no-margins">-</h5>
                                            </td> 
                                            <td>
                                                <small>Должность:</small><br>
                                                <h5 class="no-margins">-</h5>
                                            </td> 
                                            <td class="text-right">
                                                <a href="#" class="btn btn-white btn-sm"><i class="fa fa-external-link"></i> &nbsp; VK </a>
                                                <a href="/styleru/employee/5" class="btn btn-primary btn-sm"> Профиль </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img alt="image" width="40" height="40" class="img-circle" src="{{ @BASE }}/ui/img/a1.jpg" />
                                            </td>
                                            <td>
                                                <a href="project_detail.html">Смелов Леонид</a>
                                                <br/>
                                                <small>Добавлен 12.12.2015</small>
                                            </td>
                                            <td>
                                                <small>Тип:</small><br>
                                                <h5 class="no-margins">Руководитель</h5>
                                            </td> 
                                            <td>
                                                <small>Отдел:</small><br>
                                                <h5 class="no-margins">Web разработка</h5>
                                            </td> 
                                            <td>
                                                <small>Должность:</small><br>
                                                <h5 class="no-margins">Специалист</h5>
                                            </td> 
                                            <td class="text-right">
                                                <a href="#" class="btn btn-white btn-sm"><i class="fa fa-external-link"></i> &nbsp; VK </a>
                                                <a href="#" class="btn btn-primary btn-sm"> Профиль </a>
                                            </td>
                                        </tr>
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
                            <form>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="vk_id">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary">Добавить</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Mainly scripts -->
    <script src="{{ @BASE }}/ui/js/jquery-2.1.1.js"></script>
    <script src="{{ @BASE }}/ui/js/bootstrap.min.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Data Tables -->
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ @BASE }}/ui/js/inspinia.js"></script>
    <script src="{{ @BASE }}/ui/js/plugins/pace/pace.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#employeeTable').DataTable({
                lengthChange: false,
                searching: false
            });
        });
    </script>

</body>


</html>
