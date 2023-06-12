@extends('admin.base_admin')
@section('content')
    <h1>Bienvenue dans les rapports</h1>
<div name="widget_696315331" section="before_content" class="row">

    <div class="col-sm-6 col-lg-3">  <div class="card border-0 text-white bg-primary">
            <div class="card-body">
                <div class="text-value">{{ number_format($vente_journee, 0,","," ") }}</div>

                <div>Ventes journées</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: 13.2%" aria-valuenow="13.2" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

            </div>

        </div>
    </div>


    <div class="col-sm-6 col-lg-3">  <div class="card border-0 text-white bg-success">
            <div class="card-body">
                <div class="text-value">{{ number_format($vente_semaine, 0,","," ") }}</div>

                <div>Ventes weekend</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

            </div>

        </div>
    </div>


    <div class="col-sm-6 col-lg-3">  <div class="card border-0 text-white bg-red">
            <div class="card-body">
                <div class="text-value">{{ number_format($ventes_mois, 0,","," ") }}</div>

                <div>Vente mois</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

            </div>

        </div>
    </div>


    <div class="col-sm-6 col-lg-3">  <div class="card border-0 text-white bg-dark">
            <div class="card-body">
                <div class="text-value">{{ number_format($vente_annee, 0,","," ") }}</div>

                <div>Ventes année</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: 280%" aria-valuenow="280" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection


