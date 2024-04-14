<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Laravel\Passport\Passport;

class RegisterController extends Controller
{
    /**
 * @OA\Post(
 *     path="/api/register",
 *     summary="Register a new user",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="User registration data",
 *         @OA\JsonContent(
 *             required={"email", "password", "c_password", "name"},
 *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="password"),
 *             @OA\Property(property="c_password", type="string", format="password", example="password"),
 *             @OA\Property(property="name", type="string", example="John Doe")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User registered successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="object",
 *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQ2ODVmMjFjN2RhZjRlODllYzI3MzM2NzZjYWEwZGZkMjZlMjA1ZTYzZTMzMDA2YWE1NWRlZWM2ZjlmMjg3ZjU0Mjk1OWQ3OGJhZmEwNTYyIn0.eyJhdWQiOiIxIiwianRpIjoiZDY4NWYyMWM3ZGFmNGU4OWVjMjczMzY3NmNhYTBkZmQyNmUyMDVlNjNlMzMwMDZhNTVkZWVjNmY5ZjI4N2Y1NDI5NTlkNzhiYWZhMDU2MiIsImlhdCI6MTYyNzg0MTE5NywiZXhwIjoxNjI3ODQ0Nzk3LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.eNIB3E1qvhLuZaHdpfsGKhB_nYhlnszVI7mwW8iHtF3uFq_dZhB2gQODDklN5hokHccW1rIcFskBxU4G5PJ-h4JWvTc4yyDyd-1S--L0bMDtWlb4QYog7oP-CXZ7vYltd6Kvmb_GpvSHP9h8zq6j-z5_pRaZaF8V6lJg3Jkp5FKot-ovW7mRlwveK4GKuk0i6b1I49XZ6OQdowv3sfq3Nfw3h3IP7oTXQ4nYkLqWdOTGfKl0RYd-UPMStmZf3JiW22qGYB7G66C99jAdgLKgGnFpLYptl1c6cb11cEKZJJQIenXpYqu0Cq-Nv9QQw0ueEusHosn-vJXdA"),
 *                 @OA\Property(property="name", type="string", example="John Doe")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="object",
 *                 @OA\Property(property="email", type="array",
 *                     @OA\Items(type="string", example="The email field is required")
 *                 ),
 *                 @OA\Property(property="password", type="array",
 *                     @OA\Items(type="string", example="The password field is required")
 *                 ),
 *                 @OA\Property(property="c_password", type="array",
 *                     @OA\Items(type="string", example="The c_password field is required")
 *                 ),
 *                 @OA\Property(property="name", type="array",
 *                     @OA\Items(type="string", example="The name field is required")
 *                 )
 *             )
 *         )
 *     )
 * )
 */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return response()->json(['success' => $success], 200);
    }

    public function login(Request $request)
    {
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();
            $success['token'] = Passport::token()->accessToken;
            $success['name'] = $user->name;

            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->token()->revoke();
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success' => $success], 200);
    }
}
