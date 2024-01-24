<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\Global\ResponseMessage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    /**
     * @param Request $request
     * 
     * @return [type]
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::whereEmail($request->email)
            ->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'El email ingresado no se encuentra en nuestros registros'], 404);
        } else if (!password_verify($request->password, $user->password)) {
            return response()->json(['success' => false,  'message' => 'La contraseña es incorrecta'], 401);
        }

        $habilities = $user->permissionApi();
        $token = $user->createToken($user->name, $habilities->toArray())->plainTextToken;
        return $this->respondWithToken($token);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Carbon::parse(now()->addHours(24))->isoFormat('Do MMMM YYYY', 'Do MMMM')
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ResponseMessage::msgSuccess('La sesión se ha cerrado correctamente');
    }
}
