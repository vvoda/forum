<?php

namespace App\Repositories\File;

interface FileRepositoryInterface {
    
    public function getByFilename($filename);
    public function upload($fileObj);
    public function delete($id);
    
}
