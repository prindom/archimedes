<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use ZipArchive;

class ScormUpload extends Component
{
    use WithFileUploads;

    public $scorm_zip;

    public function upload()
    {
        $this->validate([
            'scorm_zip' => 'required|file|mimes:zip',
        ]);

        $path = $this->scorm_zip->store('scorm_zips', 'public');

        $unpackedPath = $this->unpackZip($path);

        $uniqueUrl = $this->generateUniqueUrl($unpackedPath);

        return redirect()->route('scorm.content', ['id' => $uniqueUrl]);
    }

    protected function unpackZip($path)
    {
        $zip = new ZipArchive;
        $res = $zip->open(Storage::disk('public')->path($path));

        if ($res === true) {
            $uniqueDir = uniqid('scorm_', true);
            $extractPath = storage_path('app/public/scorm/' . $uniqueDir);
            $zip->extractTo($extractPath);
            $zip->close();

            return $uniqueDir;
        }

        return null;
    }

    protected function generateUniqueUrl($uniqueDir)
    {
        return url('storage/scorm/' . $uniqueDir);
    }

    public function render()
    {
        return view('livewire.scorm-upload');
    }
}
