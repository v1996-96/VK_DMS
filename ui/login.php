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
        <div class="heading">
            <h1>VK DMS</h1>
            <p>Система документооборота на основе Вконтакте</p> 
        </div>

        <ul class="tabs">
            <li><a data-toggle="tab" href="#loginTab" class="active">Авторизация</a></li>
            <li><a data-toggle="tab" href="#registerTab">Регистрация</a></li>
        </ul>

        <div class="body">
            <div class="tabs-inner active" id="loginTab">
                <form method="POST">
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

                    <div class="gomeniuk_group">
                        <button type="submit" name="action" value="loginVK" class="btn btn-primary">
                            <i class="fa fa-vk"></i>
                        </button>
                    </div>

                    <p class="text-center">
                        <a href="/restore">Восстановление пароля</a>
                    </p>
                </form>
            </div>

            <div class="tabs-inner" id="registerTab">
                <form>
                    <div class="registration-step step-1">
                        <p class="info">1. Авторизуйтесь при помощи аккаунта ВК.</p>

                        <div class="gomeniuk_group">
                            <button type="button" class="btn btn-primary">
                                <i class="fa fa-vk"></i>
                            </button>
                        </div>
                    </div>
                        
                    <div class="registration-step step-1">
                        <p class="info">2. Укажите личные данные.</p>

                        <div class="gomeniuk_group">
                            <input type="text" required="required" />
                            <label>ФИО</label>
                        </div>

                        <div class="gomeniuk_group">
                            <input type="text" required="required" />
                            <label>Email</label>
                        </div>

                        <div class="gomeniuk_group">
                            <input type="text" required="required" />
                            <label>Логин</label>
                        </div>

                        <div class="gomeniuk_group">
                            <input type="password" required="required" />
                            <label>Пароль</label>
                        </div>

                        <div class="gomeniuk_group">
                            <button type="button" class="btn btn-success">
                                Зарегистрироваться
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Mainly scripts -->
    <script src="{{ @BASE }}/ui/js/jquery-2.1.1.js" type="text/javascript"></script>
    
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
