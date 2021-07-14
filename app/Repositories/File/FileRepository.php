<?php

namespace App\Repositories\File;

use App\Models\File;
use App\Models\TopicFile;
use Illuminate\Support\Facades\Storage;

class FileRepository implements FileRepositoryInterface {
    
    protected $file, $topic_file;
    
    public function __construct(File $file, TopicFile $topic_file) {
        $this->file = $file;
        $this->topic_file = $topic_file;
    }
    
    public function getByFilename($filename) {
        return $this->file->where('filename', $filename)->first();
    }
    
    public function upload($fileObj) {
        $filename = basename($fileObj->store('files'));
        $originalFilename = $fileObj->getClientOriginalName();
        $fileSize = $fileObj->getClientSize();
    
        $file = new File;
        $file->user_id = request()->session()->user->id;
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
