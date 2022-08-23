<?php

namespace App\Controllers;

use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;

class BaseController {

    protected $customresponse;

    public function __construct() {
        $this->customresponse = new CustomResponse();
    }
    

    public function successResponse(Response $response, $data) {
        return $this->customresponse->is200Response($response, $data);
    }

    public function sendSuccess(Response $response, $data) {
        return $this->customresponse->is200Response($response, $data);
    }

    public function failedResponse(Response $response, $data, $code = 400) {
        switch($code) {
            case 404:
                return $this->customresponse->is404Response($response, $data);
                break;
            case 422:
                return $this->customresponse->is422Response($response, $data);
                break;
            default:
                return $this->customresponse->is400Response($response, $data);
                break;
            
        }
    }

    public function sendError(Response $response, $data, $code = 400) {
        switch($code) {
            case 404:
                return $this->customresponse->is404Response($response, $data);
                break;
            case 422:
                return $this->customresponse->is422Response($response, $data);
                break;
            default:
                return $this->customresponse->is400Response($response, $data);
                break;
        }
    }
}


