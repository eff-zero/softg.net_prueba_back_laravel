<?php

namespace App\Modules\UserModule\controllers;

use App\Helpers\RestActions;
use App\Http\Controllers\Controller;
use App\Modules\UserModule\User;
use App\Modules\UserModule\validations\AuthLoginRequest;


class AuthController extends Controller
{
    use RestActions;

    protected User $UserModel;

    public function __construct()
    {
        $this->UserModel = new User();
    }


    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Log in user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User credentials",
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="done"),
     *             @OA\Property(property="data", type="object", example="{id:1,name:'John Doe'}"),
     *             @OA\Property(property="message", type="string", example="Inicio de sesión exitoso"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="unauthorized"),
     *             @OA\Property(property="message", type="string", example="Credenciales invalidas."),
     *         ),
     *     ),
     * )
     */

    public function login(AuthLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return $this->respondJson('unauthorized', [], null, 'Credenciales invalidas.');
        }

        $user = auth()->user();
        $data = ['token' => $user->createToken('auth_token')->plainTextToken, 'data' => $user];

        return $this->respondJson('done', $data, null, 'Inicio de sesión exitoso');
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Log out user",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="Successful logout",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="done"),
     *             @OA\Property(property="data", type="object", example="null"),
     *             @OA\Property(property="message", type="string", example="Sesión cerrada exitosamente"),
     *         ),
     *     ),
     * )
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->respondJson('done', [], null, 'Sesión cerrada exitosamente');
    }
}
