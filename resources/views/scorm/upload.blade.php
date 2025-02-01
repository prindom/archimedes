@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Upload SCORM ZIP</h1>
        <form action="{{ route('scorm.upload.post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="scorm_zip">SCORM ZIP File</label>
                <input type="file" name="scorm_zip" id="scorm_zip" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
@endsection
