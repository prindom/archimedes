@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>SCORM Content</h1>
        <iframe src="{{ $path }}" width="100%" height="600px"></iframe>
    </div>
@endsection

@section('scripts')
    <script>
        var LMS = {
            Initialize: function() {
                return "true";
            },
            Finish: function() {
                return "true";
            },
            GetValue: function(key) {
                return localStorage.getItem(key) || "";
            },
            SetValue: function(key, value) {
                localStorage.setItem(key, value);
                return "true";
            },
            Commit: function() {
                fetch('/scorm/progress', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        progress: localStorage.getItem('cmi.core.lesson_status')
                    })
                });
                return "true";
            }
        };
    </script>
@endsection
