@extends('admin.base_admin')
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@stack('style')
@section('content')
    <h6>QR Codes</h6>
    <div id="app">
        <qr-codes-index>
        </qr-codes-index>
    </div>
@endsection


