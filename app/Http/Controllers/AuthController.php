<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
use App\Http\Requests\signupRequest;
use App\User;
use Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Spatie\Permission\Traits\HasRoles;

class AuthController extends Controller
{
    use HasRoles,ResetsPasswords;


    /**
     * Create a new AuthController instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['login', 'signup', 'sendResetFailedResponse', 'sendResetResponse', 'callResetPassword', 'resetPassword']]);
        if (env('APP_ENV') == 'testing'
            && array_key_exists("HTTP_AUTHORIZATION", request()->server())) {
            JWTAuth::setRequest(\Route::getCurrentRequest());
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(loginRequest $request)
    {

        $credentials = request(['email', 'password']);
        $rememberMe = request(['rememberMe']);

        if ($rememberMe) {
            $token = JWTAuth::attempt($credentials, ['exp' => Carbon\Carbon::now()->addDays(7)->timestamp]);
        } else {
            $token = JWTAuth::attempt($credentials);

        }
        $users = DB::table('users')->where('email', '=', $credentials['email'])->first();

        if (!$token) {
            return response()->json(['errors' => ['wrong' => 'Incorrect email or password']], 401);
        }

        return $this->respondWithToken($token, $rememberMe, $request);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function signup(signupRequest $request)
    {
        $user = User::create($request->all());
        return $this->login($request);

    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $rememberMe,$request)
    {

        auth()->user()->update([
            'last_login_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);

        if ($rememberMe == true) {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 3660,
                'userUniqueId' => auth()->user()->id,
                'name' => auth()->user()->name,
                'userRole' => auth()->user()->getRoleNames()->first(),
            ],200);
        } else {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'userUniqueId' => auth()->user()->id,
                'name' => auth()->user()->name,
                'userRole' => auth()->user()->getRoleNames()->first(),

            ],200);
        }

    }

    public function callResetPassword(Request $request)
    {
        return $this->reset($request);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json(['message' => 'Failed, Invalid Token.']);
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return response()->json(['message' => 'Password reset successfully.']);
    }

    protected function resetPassword($user, $password)
    {

        $user->password = Hash::make($password) ;
        $user->save();
        event(new PasswordReset($user));
    }

}
