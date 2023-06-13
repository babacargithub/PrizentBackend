@extends('admin.base_admin')
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@stack('style')
@section('content')

        <div id="app">
            <h4>Génération de lots ou d'images de qr code</h4>
            <generate-qrcode>
            </generate-qrcode>
        </div>
@endsection


