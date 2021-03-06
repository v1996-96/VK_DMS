

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">

            <li class="nav-header">
                <div class="dropdown profile-element"> 
                    <span><img alt="image" class="img-circle" src="<?php echo $UserInfo['VK_Avatar']; ?>" /></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs"> 
                                <strong class="font-bold"><?php echo $UserInfo['Name']; ?> <?php echo $UserInfo['Surname']; ?> <b class="caret"></b></strong>
                            </span>
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
                <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/dashboard">
                    <i class="fa fa-dashboard"></i> 
                    <span class="nav-label">Компания</span>
                </a>
            </li>


            <li <?php echo (isset($_page_type) && in_array($_page_type, array('employee_list', 'employee_profile'))) ? 'class="active"' : ''; ?>>
                <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/employee">
                    <i class="fa fa-users"></i> 
                    <span class="nav-label">Сотрудники</span>
                </a>
            </li>


            <li <?php echo (isset($_page_type) && in_array($_page_type, array('department_list', 'department_dashboard', 'department_documents'))) ? 'class="active"' : ''; ?>>
                <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/departments">
                    <i class="fa fa-cubes"></i> 
                    <span class="nav-label">Отделы</span>
                </a>
            </li>


            <li <?php echo (isset($_page_type) && in_array($_page_type, array('project_list', 'project_dashboard'))) ? 'class="active"' : ''; ?>>
                <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/projects">
                    <i class="fa fa-briefcase"></i> 
                    <span class="nav-label">Проекты</span>
                </a>
            </li>


            <li <?php echo (isset($_page_type) && $_page_type == 'documents') ? 'class="active"' : ''; ?>>
                <a href="/<?php echo $PARAMS['CompanyUrl']; ?>/documents">
                    <i class="fa fa-folder-open"></i> 
                    <span class="nav-label">Документы</span>
                </a>
            </li>
        </ul>

    </div>
</nav>