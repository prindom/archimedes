<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ScormController extends Controller
{
    /**
     * Show the form for uploading a SCORM ZIP file.
     */
    public function showUploadForm()
    {
        return view('scorm.upload');
    }

    /**
     * Handle the SCORM ZIP file upload.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'scorm_zip' => 'required|file|mimes:zip',
        ]);

        $file = $request->file('scorm_zip');
        $path = $file->store('scorm_zips', 'public');

        $unpackedPath = $this->unpackZip($path);

        $uniqueUrl = $this->generateUniqueUrl($unpackedPath);

        return redirect()->route('scorm.content', ['id' => $uniqueUrl]);
    }

    /**
     * Unpack the ZIP file.
     */
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

    /**
     * Generate a unique URL for accessing the uploaded files.
     */
    protected function generateUniqueUrl($uniqueDir)
    {
        return url('storage/scorm/' . $uniqueDir);
    }

    /**
     * Serve the SCORM content and assign the LMS variable.
     */
    public function showContent($id)
    {
        $path = storage_path('app/public/scorm/' . $id);

        if (!file_exists($path)) {
            abort(404);
        }

        return view('scorm.content', ['path' => $path]);
    }
}
