<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function LoginWithSocialite($driver){
        $user_s = Socialite::driver($driver)->user();
        $user = User::query()
            ->where('email', $user_s->getEmail())->first();
        if ($user) {
            Auth::login($user, true);
            return redirect()->to('/home');
        } else {

            $response = Http::withHeaders([
                'x-rapidapi-host' => 'get-avatar-from-string.p.rapidapi.com',
                'x-rapidapi-key' => '58e5ddbfbdmsh17d78406911846ap1f0fc9jsn37f9c1ce98d6'
            ])->get('https://get-avatar-from-string.p.rapidapi.com/avatar/Furqatmasda');

            $user = User::query()->create([
                'name' => $user_s->getName() ?? $user_s->getNickname(),
                'email' => $user_s->getEmail(),
                'password' => bcrypt(Str::random(16)),
                'avatar' => $response->json()['avatar_svg'],
            ]);
            auth()->login($user, true);
            return redirect()->to('/home');
        }
    }

}
