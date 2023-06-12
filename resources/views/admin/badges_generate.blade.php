@extends('admin.base_admin')
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@stack('style')
@section('content')
    <div id="app">
        <h6>Generate Badges</h6>
        <generate-badge>
        </generate-badge>
    </div>
@endsection


