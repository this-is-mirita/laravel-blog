<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\UserType;
use App\UserStatus;

class AuthController extends Controller
{
    public function loginForm(Request $request)
    {
        $data = [
            'pageTitle' => 'Вход',
        ];
        return view('back.pages.auth.login', $data);
    }

    public function forgotForm(Request $request)
    {
        $data = [
            'pageTitle' => 'Забыли пароль',
        ];
        return view('back.pages.auth.forgot', $data);
    }

    public function loginHandler(Request $request)
    {
        // Определяем, ввёл ли пользователь email или имя пользователя
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType == 'email') {
            $request->validate([
                'login_id' => 'required|email|exists:users,email',
                'password' => 'required|min:5',
            ], [
                'login_id.required' => 'Почта или логин обязательны',
                'login_id.email' => 'Неверный формат почты',
                'login_id.exists' => 'Пользователь с такой почтой не найден',
                'password.required' => 'Пароль обязателен',
            ]);
        } else {
            $request->validate([
                'login_id' => 'required|string|exists:users,username',
                'password' => 'required|min:5',
            ], [
                'login_id.required' => 'Почта или логин обязательны',
                'login_id.exists' => 'Пользователь с таким логином не найден',
                'password.required' => 'Пароль обязателен',
            ]);
        }

        $credentials = [
            $fieldType => $request->login_id,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            // Проверка на неактивный аккаунт
            if ($user->status == UserStatus::Inactive) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()
                    ->route('admin.login')
                    ->with('fail', 'Ваш аккаунт неактивен. Пожалуйста, свяжитесь с поддержкой: support@popap.com');
            }

            // Проверка на аккаунт в ожидании подтверждения
            if ($user->status == UserStatus::Pending) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()
                    ->route('admin.login')
                    ->with('fail', 'Ваш аккаунт ожидает подтверждения.
                    Проверьте почту или свяжитесь с поддержкой: support@popap.com');
            }

            // Всё ок — перенаправляем на панель администратора
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()
                ->route('admin.login')
                ->withInput()
                ->with('fail', 'Неверный пароль');
        }
    }
}
