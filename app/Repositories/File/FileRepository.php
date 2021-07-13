<?php

namespace App\Repositories\File;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileRepository implements FileRepositoryInterface {
    
    protected $file;
    
    public function __construct(File $file) {
        $this->file = $file;
    }
    
    public function getByFilename($filename) {
        return $this->file->where('filename', $filename)->first();
    }
    
    public function upload($fileObj) {
        $filename = basename($fileObj->store('files'));
        $originalFilename = $fileObj->getClientOriginalName();
        $fileSize = $fileObj->getClientSize();
    
        $file = new File;
        $file->filename = $filename;
        $file->original_filename = $originalFilename;
        $file->filesize = $fileSize;
        $file->save();

        return $file;
    }
    
    public function delete($id) {
        $file = $this->file->where('id', $id)->first();
        if (!$file) { return; }

        Storage::disk('files')->delete($file->filename);
        $file->delete();
    }
    
}
