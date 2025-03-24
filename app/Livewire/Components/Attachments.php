<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\WithFileUploads;

class Attachments extends Component
{
    use WithFileUploads;

    public $attachments = [];
    public $tempAttachments = [];

    protected $rules = [
        'tempAttachments.*' => 'file|max:10240|mimes:gif,jpg,jpeg,png,pdf,docx,csv,xls,ppt,mp4,webm,msg,eml',
    ];

    public function updatedTempAttachments()
    {
        $this->validate();
        foreach ($this->tempAttachments as $file) {
            $this->attachments[] = $file;
        }
        $this->tempAttachments = [];
        // dd($this->attachments);
        $this->dispatch("attachmentsUpdated", attachments : $this->attachments);
    }

    public function removeAttachment($index)
    {
        if (isset($this->attachments[$index])) {
            $this->attachments[$index]->delete();
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments); // Reindex the array
            $this->dispatch("attachmentsUpdated", attachments : $this->attachments);
        }
    }

    public function render()
    {
        return view('livewire.components.attachments');
    }
}
