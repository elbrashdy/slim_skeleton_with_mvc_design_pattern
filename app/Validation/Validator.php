<?php
namespace  App\Validation;

use App\Request\CustomRequest;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{

    protected  $requestHandler;

    public $errors = [];


    public function validate($request, array $rules)
    {
        foreach ($rules as $field => $value)
        {
            try
            {
                $value->setName(ucfirst($field))->assert(CustomRequest::getParam($request,$field));
            }catch(NestedValidationException $ex)
            {
            $this->errors[$field] = $ex->getMessages();
            }
        }

        return $this;
    }


    public function failed()
    {
        return !empty($this->errors);
    }
}