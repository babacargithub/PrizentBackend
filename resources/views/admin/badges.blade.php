@extends('admin.base_admin')
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@stack('style')
@section('content')
    <h6>Badges QR CODE</h6>
    {{$unused_count}}
    <div id="app">
        <badges-index>
        </badges-index>
    </div>
@endsection


