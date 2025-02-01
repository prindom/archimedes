<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use ZipArchive;

class ScormUploadForm extends Component
{
    use WithFileUploads;

    public $scormZip;

    protected $rules = [
        'scormZip' => 'required|file|mimes:zip|max:10240', // 10MB Max
    ];

    public function upload()
    {
        $this->validate();

        $path = $this->scormZip->store('scorm_uploads');

        $zip = new ZipArchive;
        if ($zip->open(storage_path('app/' . $path)) === TRUE) {
            $extractPath = storage_path('app/scorm_packages/' . pathinfo($path, PATHINFO_FILENAME));
            $zip->extractTo($extractPath);
            $zip->close();

            if ($this->isValidScormPackage($extractPath)) {
                // Save the valid SCORM package to the server
                Storage::move('app/' . $path, 'scorm_packages/' . pathinfo($path, PATHINFO_FILENAME));
                session()->flash('message', 'SCORM package uploaded and validated successfully.');
            } else {
                Storage::delete($path);
                session()->flash('error', 'Invalid SCORM package.');
            }
        } else {
            session()->flash('error', 'Failed to unpack the SCORM zip.');
        }
    }

    private function isValidScormPackage($path)
    {
        // Implement SCORM package validation logic here
        // For example, check for the existence of imsmanifest.xml
        return file_exists($path . '/imsmanifest.xml');
    }

    public function render()
    {
        return view('livewire.pages.scorm.upload');
    }
}
