<?php

use App\Livewire\Forms\ScormUploadForm;
use Livewire\Volt\Component;

new class extends Component
{
    public ScormUploadForm $form;

    public function upload()
    {
        $this->validate();

        $this->form->upload();
    }
}; ?>

<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit="upload">
        <div>
            <x-input-label for="scormZip" :value="__('SCORM Zip')" />
            <x-text-input wire:model="form.scormZip" id="scormZip" class="block mt-1 w-full" type="file" name="scormZip" required />
            <x-input-error :messages="$errors->get('form.scormZip')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Upload') }}
            </x-primary-button>
        </div>
    </form>
</div>
