<?php namespace App\Http\Controllers\Auth;

use App\Service\FileService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Validator;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{

    /**
     * @var FileService $file
     */
    protected $fileService;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  FileService $fileService
     * @return void
     */
    public function __construct(Request $request, FileService $fileService) {
        $this->request = $request;
        $this->fileService = $fileService;
    }
    /**
     * Create a new token.
     *
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60 // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }
    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     *
     * @param  \App\User   $user
     * @return mixed
     */
    public function authenticate(User $user) {
        $this->validate($this->request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);
        // Find the user by email
        $user = User::where('email', $this->request->input('email'))->first();
        if (!$user) {
            // You wil probably have some sort of helpers or whatever
            // to make sure that you have the same response format for
            // differents kind of responses. But let's return the
            // below respose for now.
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);
        }
        // Verify the password and generate the token
        if (Hash::check($this->request->input('password'), $user->password)) {
            return response()->json([
                'token' => $this->jwt($user),
                'data' => $user
            ], 200);
        }
        // Bad Request response
        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);
    }

    /**
     * Register a user and return the token and data if the provided credentials are correct.
     *
     * @param  Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        $user = new User;
        $filename = null;
        $this->validate($request, $user::$rules);
        if($request->file('avatar')){
            $uploadedFile = $request->file('avatar');
            $filename = $uploadedFile->hashName();
            $this->fileService->storeFile($uploadedFile, $filename, 'avatar');
        }

        $user = $user::create($request->all());
        $token = $this->jwt($user);
        $data = [
            'token' => $token,
            'avatarLink' => $filename ? URL::asset('storage/avatar/'.$filename) : null
        ];

        return response()->json($data, Response::HTTP_CREATED);
    }
}