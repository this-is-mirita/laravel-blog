<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\UserType;
use App\UserStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Helpers\CMail;
use function Laravel\Prompts\table;

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

    public function sendPasswordResetLink(Request $request)
    {
        // validate form
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Почта обязательны',
            'email.email' => 'Неверный формат почты',
            'email.exists' => 'Пользователь с такой почтой не найден',
        ]);

        //get user data
        $user = User::where('email', $request->email)->first();
        // renerated token
        $token = base64_encode(Str::random(64));
        // check if here is an axisin
        $oldToken = DB::table('password_reset_tokens')->
        where('email', $user->email)->first();

        if ($oldToken) {
            // update existing token если есть такая запись то обновим с новым
            DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]);
        } else {
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
        }
        // create clickable action link
        $actionLink = route('admin.reset_password_form', ['token' => $token]);
        $data = array(
            'actionLink' => $actionLink,
            'user' => $user,
        );
        $mail_body = view('email-templates.forgot-template', $data)->render();
        $mailConfig = array(
            'recipient_address' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Reset Password',
            'body' => $mail_body,
        );

        if(CMail::send($mailConfig)) {
            return redirect()->route('admin.login')->with('success', 'Данные направлены на почты');
        } else {
            return redirect()->route('admin.forgot')->with('fail', 'Ошибка, попробуйте позже');
        }
    }

    public function resetForm(Request $request, $token = null)
    {
        //dd($token);
        $isValidToken = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();
        if (!$isValidToken) {
            return redirect()->route('admin.forgot')
                ->with('fail', 'Неверный токен попробуйте еще раз');
        } else {
            $data = [
                'pageTitle' => 'Reset Password',
                'token' => $token,
            ];
            return view('back.pages.auth.reset', $data);

        }
    }
    public function resetPasswordHandler(Request $request){
        $request->validate([
            'new_password' => 'required|min:5|
                required_with:new_password_confirmation|
                same:new_password_confirmation',
            'new_password_confirmation' => 'required|min:5',

        ]);
        // получение данных пользователя
        $dbToken = DB::table('password_reset_tokens')
            ->where('token', $request->token)->first();
        $user = User::where('email', $dbToken->email)->first();
        // обновление пароля
        User::where('email', $dbToken->email)->update([
           'password' => Hash::make($request->new_password)
        ]);
        // отправка на почту что новый пароль
        $data = array(
            'user' => $user,
            'new_password' => $request->new_password
        );
        $mailBody = view('email-templates.password-changes-template', $data)->render();
        $mailConfig = array(
            'recipient_address' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Password Changes',
            'body' => $mailBody,
        );
        if(CMail::send($mailConfig)) {
            // удаление токена прошлого
            DB::table('password_reset_tokens')
                ->where([
                    'email' => $dbToken->email,
                    'token'=>$dbToken->token])
                ->delete();
            return redirect()->route('admin.login')->with('success', 'Ваш пароль был изменен, используйте новый пароль');
        } else {
            return redirect()
                ->route('admin.reset_password_form', ['token' => $dbToken->token])
                ->with('fail', 'Что то не так, попробуйте еще раз');
        }

    }
}
