@props(['record'])

@if($record->file)

    <iframe
        src="{{ Storage::url($record->file) }}"
        width="100%"
        height="300px">
    </iframe>
@else
    <span>No PDF Uploaded</span>
@endif

