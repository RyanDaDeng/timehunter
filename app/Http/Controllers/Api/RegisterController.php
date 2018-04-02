<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\Parser\Parser;

use Illuminate\Support\Facades\DB;

class RegisterController extends BaseController
{


    public $successStatus = 200;


    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            return response()->json(
                [
                    'token' => $user->createToken('MyApp')->accessToken,
                    'user' => $user,
                    'status' => 200
                ], $this->successStatus);
        } else {
            return response()->json(['error' => 'User email or password is wrong.'], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'checkPass' => 'required|same:password',
            'timezone' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => 'Validation Error.'], 401);
        }

        if (User::where('email', $request->email)->exists()) {
            return response()->json(['error' => 'The email had already been registered.'], 401);
        }


        $input = $request->all();
        $input['name'] = $input['email'];
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        return response()->json(
            [
                'token' => $user->createToken('MyApp')->accessToken,
                'user' => $user,
                'status' => 200
            ], $this->successStatus);
    }


    public function logout()
    {
        $accessToken = auth()->user()->token();

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        return response()->json(['status' => 200]);
    }

    public function getUser()
    {
        return auth()->user();
    }
}