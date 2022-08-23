<?php

namespace App\Controllers\ReusableControllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\UploadedFile;;

$uploatPath = __DIR__ . '/../../../public/uploads';


class FileUpload
{

    public function upload(Request $request,  String $fieldValue)
    {
        $filename = null;
        $uploadedFile = $request->getUploadedFiles();
        $file = $uploadedFile[$fieldValue];
        if ($uploadedFile[$fieldValue]->getError() === UPLOAD_ERR_OK) {
            $filename = $this->moveUploadedFile('./uploads', $file, $fieldValue);
        }
        return $filename;
    }

    public function updateUpload(Request $request,  String $fieldValue, $presentFile = '')
    {
        
        $filename = null;
        $uploadedFile = $request->getUploadedFiles();
        if($uploadedFile[$fieldValue] == null) {
            return $filename = null;
        }

        if($presentFile !== '') {
            if(file_exists('./uploads/' . $presentFile))
            unlink('./uploads/' . $presentFile );
        }
        
        $file = $uploadedFile[$fieldValue];
        if ($uploadedFile[$fieldValue]->getError() === UPLOAD_ERR_OK) {
            $filename = $this->moveUploadedFile('./uploads', $file, $fieldValue);
        }
        return $filename;
    }

    public function checkFile(Request $request,  String $fieldValue)
    {
        $uploadedFile = $request->getUploadedFiles();
        if($uploadedFile[$fieldValue] == null) {
            return false;
        }

        return true;
    }



    function moveUploadedFile($directory, UploadedFile $uploadedFile, String $fieldValue)
    {
        $permittedFiles = array('png', 'jpg');
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        if (in_array($extension, $permittedFiles)) {
            $basename = bin2hex(random_bytes(8)); 
            $filename = sprintf('%s.%0.8s', $basename, $extension);
            $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
        } else {
            return [$fieldValue => "File not supported"];
        }


        return $filename;
    }
}
