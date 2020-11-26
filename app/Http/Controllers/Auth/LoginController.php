<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Models\campuses;

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

    // use AuthenticatesUsers;

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

     //https://laravel.com/docs/8.x/controllers#controller-middleware
    // Route::get('profile', [UserController::class, 'show'])->middleware('auth');
     public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($website)
    {
        //return Socialite::driver($website)->redirect();
        return Socialite::driver($website)->with(["prompt" => "select_account"])->redirect();
    }

    function authenticate_bits_email($useremail)
    {
        // Fetch Campus
        $campus = campuses::orderby("campus","asc")
        ->select('campus')
        ->get();

        $isbitsemail = 0;

        foreach($campus as  $row)
        {
            if (strpos($useremail, strtolower($row->campus))){
                $isbitsemail = 1;
            }

            if($isbitsemail == 1)
            {
                break;
            }
        }

        return $isbitsemail;

    }

    public function handleProviderCallback($website)
    {
        try
        {
            $user = Socialite::driver($website)->stateless()->user();

            $verifiedemail = $this->authenticate_bits_email($user->getEmail());

            if($verifiedemail == 1)
            {
                //login if the user in the database
                $user_found = User::where('google_id', $user->id)->first();

                if($user_found){
                    Auth::login($user_found);
                }
                else
                {
                    //or we need to make a new user
                    $newUser                  = new User;
                    $newUser->name            = $user->getName();
                    $newUser->email           = $user->getEmail();
                    $newUser->google_id       = $user->id;
                    $newUser->avatar          = $user->avatar;
                    $newUser->avatar_original = $user->avatar_original;
                    $newUser->save();            
                    
                    Auth::login($newUser);
                }

                return redirect('/CS-IS/home');
            }
            else
            {
                return redirect('/CS-IS/login-alert');
            }

        }catch (Exception $e) {

            return redirect('/CS-IS/login/{website}');
        }
    }

    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect('/CS-IS/login');
    }
}
