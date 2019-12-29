<?php


namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;

class AuthController extends Controller
{

    /**`
     * User Service Instance.
     *
     * @var UserService
     */
    protected $userService;

    /**
     * AuthController constructor.
     *
     * @param UserService $userService
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth:api', ['except' => ['register', 'login']]);

        $this->userService = $userService;
    }

    /**
     * Register user.
     *
     * @param RegisterUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUserRequest $request)
    {
        $user = $this->userService->create([
            'first_name' => $request->get('first_name'),
            'last_name'  => $request->get('last_name'),
            'email'      => $request->get('email'),
            'password'   => bcrypt($request->get('password'))
        ]);

        $user = $this->userService->findOrFail($user->id);

        dispatch(new SendMailJob($user))
            ->delay(now()->addSeconds(5));

        return response()->json(['message' => 'Successfully created user!'], 201);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param LoginUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
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
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
