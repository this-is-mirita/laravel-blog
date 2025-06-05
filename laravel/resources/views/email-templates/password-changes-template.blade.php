<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Пароль изменён</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333333;
        }
        p {
            color: #555555;
        }
        .credentials {
            background-color: #f9f9f9;
            border-left: 4px solid #4CAF50;
            padding: 10px 15px;
            margin-top: 15px;
            font-size: 16px;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Пароль успешно изменён</h2>
    <p>Здравствуйте, {{ $user->$user }}</p>
    <p>Ваш пароль был успешно обновлён. Ниже указаны ваши новые данные для входа:</p>

    <div class="credentials">
        <strong>Имя пользователя / Email:</strong> {{ $user->email }} и {{ $user->username  }} <br/>
        <strong>Новый пароль:</strong> {{$new_password}}
    </div>

    <p>Если вы не запрашивали изменение пароля, пожалуйста, немедленно свяжитесь с нашей службой поддержки.</p>
    <p>С уважением,<br/>Команда поддержки</p>
    <p{{ date('Y') }}</p> MEEYMIRITA
</div>
</body>
</html>
