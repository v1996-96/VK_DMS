

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">

            <li class="nav-header">
                <div class="dropdown profile-element"> 
                    <span><img alt="image" class="img-circle" src="<?php echo $BASE; ?>/ui/img/profile_small.jpg" /></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs"> 
                                <strong class="font-bold">Трушин Виктор</strong>
                            </span>
                            <span class="text-muted text-xs block">Менеджер <b class="caret"></b></span> 
                        </span>
                    </a>
                    <ul class="dropdown-menu animated pulse m-t-xs">
                        <li><a href="#">Профиль</a></li>
                        <li class="divider"></li>
                        <li><a href="/logOut">Выйти</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    VKDMS
                </div>
            </li>


            <li <?php echo (isset($_page_type) && $_page_type == 'company_dashboard') ? 'class="active"' : ''; ?>>
                <a href="/styleru/dashboard">
                    <i class="fa fa-dashboard"></i> 
                    <span class="nav-label">Компания</span>
                </a>
            </li>


            <li <?php echo (isset($_page_type) && in_array($_page_type, array('employee_list', 'employee_profile'))) ? 'class="active"' : ''; ?>>
                <a href="/styleru/employee">
                    <i class="fa fa-users"></i> 
                    <span class="nav-label">Сотрудники</span>
                </a>
            </li>


            <li <?php echo (isset($_page_type) && in_array($_page_type, array('department_list', 'department_dashboard', 'department_documents'))) ? 'class="active"' : ''; ?>>
                <a href="/styleru/departments">
                    <i class="fa fa-cubes"></i> 
                    <span class="nav-label">Отделы</span>
                </a>
            </li>


            <li <?php echo (isset($_page_type) && in_array($_page_type, array('project_list', 'project_dashboard'))) ? 'class="active"' : ''; ?>>
                <a href="/styleru/projects">
                    <i class="fa fa-briefcase"></i> 
                    <span class="nav-label">Проекты</span>
                </a>
            </li>


            <li <?php echo (isset($_page_type) && $_page_type == 'documents') ? 'class="active"' : ''; ?>>
                <a href="/styleru/documents">
                    <i class="fa fa-folder-open"></i> 
                    <span class="nav-label">Документы</span>
                </a>
            </li>
        </ul>

    </div>
</nav>