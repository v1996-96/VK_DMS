<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - Страница авторизации</title>

    <link href="{{ @BASE }}/ui/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="{{ @BASE }}/ui/css/animate.css" rel="stylesheet">
    <link href="{{ @BASE }}/ui/css/login.css" rel="stylesheet">

</head>
<body>

    
    <!-- Gomeniuk block -->
    <div class="gomeniuk animated bounceIn">
        <div class="heading text-center">
            <h1>VK DMS</h1>
            <p>Система документооборота на основе Вконтакте</p> 
        </div>

        <ul class="tabs">
            <li><a data-toggle="tab" href="#loginTab" {{ @pageTab == 'login' ? 'class="active"' : '' }}>Авторизация</a></li>
            <li><a data-toggle="tab" href="#registerTab" {{ @pageTab == 'register' ? 'class="active"' : '' }}>Регистрация</a></li>
        </ul>

        <div class="body">
            <div class="tabs-inner {{ @pageTab == 'login' ? 'active' : '' }}" id="loginTab">
                <check if="{{ isset(@login_error) }}">
                    <div class="error-msg">{{ @login_error }}</div>
                </check>

                <form method="POST" action"/">
                    <div class="gomeniuk_group">
                        <input name="email" type="text" required="required" />
                        <label>Email</label>
                    </div>

                    <div class="gomeniuk_group">
                        <input name="password" type="password" required="required" />
                        <label>Пароль</label>
                    </div>

                    <div class="gomeniuk_group">
                        <button type="submit" name="action" value="loginAuth" class="btn btn-success">
                            Войти
                        </button>
                    </div>

                    <p class="info">Войдите при помощи аккаунта Вконтакте:</p>
                </form>

                <form method="POST" action="/">
                    <div class="gomeniuk_group">
                        <button name="action" value="loginVK" id="loginVKBtn" class="btn btn-primary">
                            <i class="fa fa-vk"></i>
                        </button>
                    </div>
                </form>

                <p class="text-center">
                    <a href="/restore">Восстановление пароля</a>
                </p>
            </div>

            <div class="tabs-inner {{ @pageTab == 'register' ? 'active' : '' }}" id="registerTab">
                <form method="POST" action="/registration">
                    <div class="registration-step">
                        <p class="info">1. Авторизуйтесь при помощи аккаунта ВК.</p>

                        <div class="gomeniuk_group">
                            <button type="submit" name="action" value="connectVk" class="btn btn-primary">
                                <i class="fa fa-vk"></i>
                            </button>
                        </div>
                    </div>

                    <check if="{{ isset(@registration_error) }}">
                        <div class="error-msg">{{ htmlspecialchars_decode(@registration_error) }}</div>
                    </check>
                        
                    <check if="{{ @showRegistrationFields }}">
                        <check if="{{ @vk_logged }}">
                            <input type="hidden" name="vk_logged" value="1" />
                            <input type="hidden" name="userId" value="{{ @userId }}" />
                            <input type="hidden" name="access_token" value="{{ @access_token }}" />
                            <input type="hidden" name="expires" value="{{ @expires }}" />
                        </check> 

                        <div class="registration-step">
                            <p class="info">2. Укажите личные данные.</p>
 
                            <input type="hidden" name="VK_Avatar" value="{{ @VK_Avatar }}" />

                            <div class="gomeniuk_group">
                                <input type="text" name="name" value="{{ @name }}" required="required" />
                                <label>Имя</label>
                            </div>

                            <div class="gomeniuk_group">
                                <input type="text" name="surname" value="{{ @surname }}" required="required" />
                                <label>Фамилия</label>
                            </div>

                            <div class="gomeniuk_group">
                                <input type="text" name="email" value="{{ @email }}" required="required" />
                                <label>Email</label>
                            </div>

                            <div class="gomeniuk_group">
                                <input type="password" name="pwd" required="required" />
                                <label>Пароль</label>
                            </div>

                            <div class="gomeniuk_group">
                                <input type="password" name="pwdRepeat" required="required" />
                                <label>Повтор пароля</label>
                            </div>

                            <div class="gomeniuk_group">
                                <button type="submit" name="action" value="register" class="btn btn-success">
                                    Зарегистрироваться
                                </button>
                            </div>
                        </div>
                    </check>

                </form>
            </div>
        </div>
    </div>


    <!-- Mainly scripts -->
    <script src="{{ @BASE }}/ui/js/jquery-2.1.1.js" type="text/javascript"></script>

    <!-- <script src="//vk.com/js/api/xd_connection.js?2"  type="text/javascript"></script> -->
    <script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
    
    <script type="text/javascript">
        var App = (function($){

            var parent = this;

            this.tabs = {
                showTab : function(target){
                    $(target).addClass("active");
                },

                hideTab : function(target){
                    $(target).removeClass("active");
                },

                getCurrentTab : function(){
                    var selector = null;
                    var links = $("[data-toggle='tab']");

                    for (var i = 0; i < links.length; i++) {
                        if ( $(links[i]).hasClass("active") ) {
                            selector = $(links[i]).attr("href");
                            break;
                        }
                    }

                    return selector;
                },

                setHandlers : function(){
                    var that = this;

                    $("[data-toggle='tab']").on("click", function(e){
                        e.preventDefault();

                        var connectedTab = $(this).attr("href");
                        if (!connectedTab) return;

                        if (!$(this).hasClass("active")) {
                            that.hideTab( that.getCurrentTab() );
                            that.showTab($(connectedTab));
                            $("[data-toggle='tab']").removeClass("active");
                            $(this).addClass("active");
                        } else return;
                    });
                }
            }

            this.vk = {
                init : function () {
                    
                }
            };

            this.init = function(){
                tabs.setHandlers();


            }

            return {
                init : function() {
                    parent.init();
                }
            }

        })(jQuery);

        $(document).ready(function () {
            App.init();
        });
    </script>
    

</body>
</html>
