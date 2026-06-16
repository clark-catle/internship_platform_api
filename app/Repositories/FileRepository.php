<?php

namespace App\Repositories;

use App\DTOs\File\AddFileDTO;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

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

    /**
     * finds the file base on the passed `$id` then returning it
     * @param int $id
     * @return File|\Illuminate\Database\Eloquent\Builder<File>
     */
    public function getFileById(int $id)
    {
        return $this->file->find($id);
    }

    /**
     * getting the contents of file base on 
     * the path of `$file` then returning it
     * @param File $file
     * @return string|null
     */
    public function getFileContent(File $file)
    {
        return Storage::disk('private')->get($file->path);
    }
}
