<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * URLに指定がない場合、ログイン情報から遷移先分岐
     */
    public function index()
    {
        $user = Auth::user();
        $route = '';

        if(is_null($user)){
            /* ログインがない場合、ログイン画面へリダイレクト */
            $route = 'login';
        }else{
            switch($user->type){
                /* 管理者権限ユーザ */
                case 1:
                    $route = 'admin.home';
                    break;
                /* 一般権限ユーザ */
                case 2:
                    $route = 'dashboard';
                    break;
                default:
                    $route = 'login';
            }
        }

        return redirect()->intended(route($route));
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
