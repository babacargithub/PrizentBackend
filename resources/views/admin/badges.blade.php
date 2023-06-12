@extends('admin.base_admin')
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@stack('style')
@section('content')
    <h1>Badges QR CODE</h1>
    <div id="app">
        <badges-index>
        </badges-index>
    </div>
@endsection


