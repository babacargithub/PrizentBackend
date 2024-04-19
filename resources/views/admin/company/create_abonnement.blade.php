@extends('admin.base_admin')
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@stack('style')
@php
 @endphp
@section('content')
    <div id="app">
        <h4>Créer un abonnement pour {{$company->nom}}</h4>
        <create-company-abonnement type="{{$company->nom}}"
                                   company_prop="{{json_encode($company)}}"
                                   type_abonnement="{{$type_abonnement}}"
                                   list_of_formules="{{json_encode($formules)}}"
                                   list_of_features="{{json_encode($features)}}">
            </create-company-abonnement>
    </div>
@endsection
