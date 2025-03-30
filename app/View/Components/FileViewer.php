<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class FileViewer extends Component
{
    public $filePath;
    public $fileName;
    public $fileType;
    public $isPrivate;

    public function __construct($file, $isPrivate = false)
    {
        $this->fileName = $file->filename;
        $this->fileType = strtolower(pathinfo($this->fileName, PATHINFO_EXTENSION));
        $this->isPrivate = $isPrivate;

        // Generate the file path based on whether it's private or public
        if ($this->isPrivate) {
            if (Storage::exists($file->file_path)) {
                $this->filePath = Storage::temporaryUrl($file->file_path, now()->addMinutes(30));
            } else {
                $this->filePath = null; // Handle missing file gracefully
            }
        } else {
            $this->filePath = asset("storage/{$file->file_path}");
        }
    }

    public function render()
    {
        return view('components.file-viewer');
    }
}
