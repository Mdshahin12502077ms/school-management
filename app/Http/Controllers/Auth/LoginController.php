<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function login(Request $request){
        $credential=$request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
        if(Auth::attempt($credential)){
         $user_role=Auth::user()->role;
         switch($user_role){
            case 1:
                return redirect('/admin');
                break;
                case 2:
                    return redirect('/teacher');
                    break;
                    case 3:
                        return redirect('/student');
                        break;
                        case 4:
                            return redirect('/parent');
                            break;
                          default:
                            Auth::logout();
                            return redirect('/login')->with('error', 'oops something wrong! please try again');
         }
        }

        else {
            return redirect('/login')->with('error', 'oops something wrong! please try again');
        }
    }
    
}
