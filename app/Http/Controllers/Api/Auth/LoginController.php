<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;
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

    use HasApiTokens;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $Admin = User::firstWhere('email', $request->email);

        if (!$Admin) {
            throw ValidationException::withMessages([
                'credential' => ['The provided credential(s) is/are incorrect.'],
            ]);
        }else if (!Hash::check($request->password, $Admin->password)) {
            throw ValidationException::withMessages([
                'credential' => ['The provided credential(s) is/are incorrect.'],
            ]);
        }
        $common = new CommonController();

        return response()->json([
            'success'   => true,
            // 'common_data'   =>  json_encode($common->getBasicAuthData()),
            'token' => $Admin->createToken('admin')->plainTextToken
        ]);

    }
    
    protected static function test($request)
    {
        if($request->has('new_idea_test')){
            $new = $request->get('new_idea_test');
        }
    }


    public function logout(Request $request)
    {
        return response()->json($request->user()->currentAccessToken()->delete());
    }
}