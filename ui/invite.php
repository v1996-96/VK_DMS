<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ SITE_TITLE }} - Страница регистрации</title>

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

        <div class="body">
            <check if="{{ isset(@CompanyData) }}">
                <p class="info">Вы приглашены в компанию:<br/><strong>{{ @CompanyData.Title }}</strong></p>
            </check>

            <check if="{{ isset(@invite_error) }}">
                <div class="error-msg">{{ htmlspecialchars_decode(@invite_error) }}</div>
            </check>

            <form method="POST">
                <p class="info">1. Авторизуйтесь при помощи аккаунта ВК.</p>

                <div class="gomeniuk_group">
                    <button type="submit" name="action" value="loginVK" class="btn btn-success">
                        Войти
                    </button>
                </div>
            </form>

            <check if="{{ isset(@registration_error) }}">
                <div class="error-msg">{{ htmlspecialchars_decode(@registration_error) }}</div>
            </check>
            
            <check if="{{ @showRegistrationFields }}">
                <form method="POST">
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
                </form>
            </check>


            <check if="{{ @showAcceptFields }}">
                <p class="info">3. Вступите в компанию.</p>

                <form method="POST">
                    <check if="{{ @vk_logged }}">
                        <input type="hidden" name="vk_logged" value="1" />
                        <input type="hidden" name="userId" value="{{ @userId }}" />
                        <input type="hidden" name="access_token" value="{{ @access_token }}" />
                        <input type="hidden" name="expires" value="{{ @expires }}" />
                    </check>

                    <div class="gomeniuk_group half">
                        <button type="submit" name="action" value="accept" class="btn btn-primary">
                            Принять
                        </button>
                    </div>

                    <div class="gomeniuk_group half">
                        <button type="submit" name="action" value="decline" class="btn btn-danger">
                            Отказаться
                        </button>
                    </div>
                </form>
            </check>

        </div>
    </div>


    <!-- Mainly scripts -->
    <script src="{{ @BASE }}/ui/js/jquery-2.1.1.js" type="text/javascript"></script>

</body>
</html>
