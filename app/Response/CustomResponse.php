<?php

namespace  App\Response;

class CustomResponse
{

    public function is200Response($response,$responseMessage)
    {
        $responseMessage = ["success"=>true,"response"=>$responseMessage];
        $response->getBody()->write(json_encode($responseMessage));
        return $response->withHeader("Content-Type","application/json")
            ->withStatus(200);
    }


    public function is404Response($response,$responseMessage)
    {
        $responseMessage = ["success"=>false,"response"=>$responseMessage];
        $response->getBody()->write(json_encode($responseMessage));
        return $response->withHeader("Content-Type","application/json")
            ->withStatus(404);
    }

    public function is403Response($response,$responseMessage)
    {
        $responseMessage = ["success"=>false,"response"=>$responseMessage];
        $response->getBody()->write(json_encode($responseMessage));
        return $response->withHeader("Content-Type","application/json")
            ->withStatus(403);
    }


    public function is400Response($response,$responseMessage)
    {
        $responseMessage = ["success"=>false,"response"=>$responseMessage];
        $response->getBody()->write(json_encode($responseMessage));
        return $response->withHeader("Content-Type","application/json")
            ->withStatus(400);
    }

    public function is422Response($response,$responseMessage)
    {
        $responseMessage = json_encode(["success"=>false,"response"=>$responseMessage]);
        $response->getBody()->write($responseMessage);
        return $response->withHeader("Content-Type","application/json")
            ->withStatus(422);
    }
}