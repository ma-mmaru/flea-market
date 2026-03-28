<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use App\Http\Requests\LoginRequest; //作成したLoginRequest
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest; //FortifyのLoginRequest

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);
        
        //会員登録画面にauth/register.blade.phpを使用する
        Fortify::registerView(function ()
        {
            return view('auth.register');
        });
        //ログイン画面にauth/login.blade.phpを使用する
        Fortify::loginView(function ()
        {
            return view('auth.login');
        });
        //FortifyのLoginRequestから作成したLoginRequestに差し替え
        $this->app->bind(FortifyLoginRequest::class, LoginRequest::class);
        //会員登録後プロフィール編集画面へ
        config(['fortify.home' => '/mypage/profile']);
        
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}