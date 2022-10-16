<?php

namespace App\Http\Controllers\Sanctum;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login user
     *
     * @param Request $request
     * @return void
     */
   public function login(Request $request)
   {
      $request->validate([
         'email' => 'required|email',
         'password' => 'required',
         'device_name' => 'required',
      ]);

      $user = User::where('email', $request->email)->first();

      if (!$user || !Hash::check($request->password, $user->password)) {
         return response('Login invalid', 503);
      }

      return ['token' => $user->createToken($request->device_name)->plainTextToken];
   }

   /**
    * Logout user
    *
    * @param Request $request
    * @return void
    */
   public function logout(Request $request)
   {
        return [
            "msg" => "Logout succesful",
            "status" => $request->user()->currentAccessToken()->delete()
        ];
   }
}
