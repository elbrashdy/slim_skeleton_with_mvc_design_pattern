<?php 

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends BaseController {
  

    public function index(Request $request, Response $response)
    {
        // $user = Auth::user();
        $home = "Hello! The app is working perfect";
        return $this->successResponse($response, $home);
    }

    public function get(Request $request, Response $response, $id) {
        
    }

    public function create(Request $request, Response $response) {
        
    }

    public function update(Request $request, Response $response, $id) {

    }

    public function delete(Request $request, Response $response, $id) {

    }
}