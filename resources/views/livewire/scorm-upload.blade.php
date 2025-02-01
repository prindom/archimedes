<div>
    <h1>Upload SCORM ZIP</h1>
    <form wire:submit.prevent="upload">
        <div class="form-group">
            <label for="scorm_zip">SCORM ZIP File</label>
            <input type="file" wire:model="scorm_zip" id="scorm_zip" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
