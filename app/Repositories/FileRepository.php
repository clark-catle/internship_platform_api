<?php

namespace App\Repositories;

use App\DTOs\File\AddFileDTO;
use App\Models\File;

class FileRepository
{
    public function __construct(private File $file) {}

    /**
     * creating a new file info base on the 
     * passed `$data` and returning it
     * @param AddFileDTO $data
     * @return File
     */
    public function createFile(AddFileDTO $data)
    {
        return $this->file->create([
            'filename' => $data->filename,
            'path' => $data->path,
            'mime_type' => $data->mime_type,
            'category' => $data->category,
            'size' => $data->size,
        ]);
    }
}
