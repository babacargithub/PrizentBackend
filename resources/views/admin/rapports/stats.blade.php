@extends('admin.base_admin')
@section('content')
    <h1>Bienvenue dans les rapports</h1>
<div name="widget_696315331" section="before_content" class="row">

    <div class="col-sm-6 col-lg-3">  <div class="card border-0 text-white bg-primary">
            <div class="card-body">
                <div class="text-value">{{ number_format($nombre_clients, 0,","," ") }}</div>

                <div>Nombre clients</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: 13.2%" aria-valuenow="13.2" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

            </div>

        </div>
    </div>


    <div class="col-sm-6 col-lg-3">  <div class="card border-0 text-white bg-success">
            <div class="card-body">
                <div class="text-value">{{ number_format($nombre_abonnes, 0,","," ") }}</div>

                <div>Nombre Abonnés</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

            </div>

        </div>
    </div>
 <div class="col-sm-6 col-lg-3">  <div class="card border-0 text-white bg-success">
            <div class="card-body">
                <div class="text-value">{{ number_format($nombre_achats, 0,","," ") }}</div>

                <div>Nombre achats</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

            </div>

        </div>
    </div>


</div>
@endsection


