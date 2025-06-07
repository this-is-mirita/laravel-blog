<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Сброс пароля</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f2f4f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .email-header {
            background-color: #4a90e2;
            color: white;
            padding: 24px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 30px;
            line-height: 1.6;
        }

        .email-body p {
            margin: 16px 0;
        }

        .button {
            display: inline-block;
            padding: 14px 24px;
            background-color: #4a90e2;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 24px;
        }

        .email-footer {
            font-size: 12px;
            color: #888;
            text-align: center;
            padding: 20px;
            background-color: #f9f9f9;
        }

        @media (max-width: 600px) {
            .email-body {
                padding: 20px;
            }

            .button {
                display: block;
                text-align: center;
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    <div class="email-header">
        <h1>Сброс пароля</h1>
    </div>
    <div class="email-body">
        <p>Здравствуйте, {{ $user->name }}</p>
        <p>Мы получили запрос на сброс пароля для вашей учётной записи.</p>
        <p>Чтобы создать новый пароль, нажмите на кнопку ниже:</p>

        <a href="{{ $actionLink }}" target="_blank" class="button">Сбросить пароль</a>
        <p>
            Эта ссылка активна 15 минут
        </p>
        <p>Если вы не запрашивали сброс, просто проигнорируйте это сообщение.</p>
        <p>С уважением, <br> Команда поддержки</p>
    </div>
    <div class="email-footer">
        © {{ date('Y') }} MEEYMIRITA
    </div>
</div>
</body>
</html>
