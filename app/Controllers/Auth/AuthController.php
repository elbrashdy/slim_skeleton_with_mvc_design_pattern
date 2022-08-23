<?php

namespace  App\Controllers\Auth;

use App\Controllers\GTController;
use App\Models\User;
use App\Request\CustomRequest;
use App\Response\CustomResponse;
use App\Validation\Validator;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;


class AuthController
{

    protected $user;
    protected $customResponse;
    protected $validator;

    public function __construct()
    {
        $this->user = new User();
        $this->customResponse = new CustomResponse();
        $this->validator = new Validator();
    }


    public function register(Request $request, Response $response)
    {
        $this->validator->validate($request, [
            "name" => v::notEmpty(),
            "email" => v::notEmpty()->email(),
            "password" => v::notEmpty()
        ]);

        if ($this->validator->failed()) {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response, $responseMessage);
        }

        if ($this->EmailExist(CustomRequest::getParam($request, "email"))) {
            $responseMessage = "Email already taken";
            return $this->customResponse->is400Response($response, $responseMessage);
        }

        $passwordHash = $this->hashPassword(CustomRequest::getParam($request, 'password'));

        $user = $this->user->create([
            "name" => CustomRequest::getParam($request, "name"),
            "email" => CustomRequest::getParam($request, "email"),
            "password" => $passwordHash,
        ]);

        return $this->customResponse->is200Response($response, $user);
    }


    public function login(Request $request, Response $response)
    {
        $this->validator->validate($request, [
            "email" => v::notEmpty()->email(),
            "password" => v::notEmpty()
        ]);

        
        if ($this->validator->failed()) {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response, $responseMessage);
        }

        $user = User::where('email', CustomRequest::getParam($request, "email"))->first();

        
        if(!$user || !$this->verifyPassword(CustomRequest::getParam($request, "password"), $user->password)) {
            $responseMessage = "Wrong Email/Password";
            return $this->customResponse->is403Response($response, $responseMessage);
        } else {
            $responseMessage = GTController::generateToken([
                "email" => $user->email,
                "name" => $user->name,
                "id" => $user->id
           ]);
            return $this->customResponse->is200Response($response, $responseMessage);
        }
        
    }

    public function verifyPassword($password, $hashedPassword)
    {
        $verify = password_verify($password, $hashedPassword);
        if ($verify == false) {
            return false;
        }
        return true;
    }

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function EmailExist($email)
    {
        $count = $this->user->where(['email' => $email])->count();
        if ($count == 0) {
            return false;
        }
        return true;
    }
}
