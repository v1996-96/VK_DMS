<?php

defined('_EXECUTED') or die('Restricted access');

?>

<div class="row border-bottom">
    <nav class="navbar navbar-static-top {{ isset(@_topLineColor) ? @_topLineColor : '' }}" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <h3 class="company-nav-title dropdown">
                <a href="#" data-toggle="dropdown">{{ @CompanyData.Title }} <span class="caret"></span></a>
                <ul class="dropdown-menu animated pulse">
                    <li>
                        <a href="/companies">Сменить компанию</a>
                    </li>
                    <check if="{{ @CompanyRight_Edit }}">
                        <li><a href="/{{ @PARAMS.CompanyUrl }}/edit">Редактировать</a></li>
                    </check>
                </ul>
            </h3>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <check if="{{ !@UserInfo.VK_Authorized }}">
                <li>
                    <a href="#" id="authorize_vk" style="color: #e74c3c;">
                        Авторизоваться в ВК
                    </a>
                </li>
            </check>

            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="mailbox.html">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="profile.html">
                            <div>
                                <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                <span class="pull-right text-muted small">12 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="grid_options.html">
                            <div>
                                <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <div class="text-center link-block">
                            <a href="notifications.html">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>

            <li>
                <a class="right-sidebar-toggle">
                    <i class="fa fa-tasks"></i>
                </a>
            </li>
            <li>
                <a href="/logOut">
                    <i class="fa fa-sign-out"></i> Выйти
                </a>
            </li>
        </ul>
    </nav>
</div>