<?php

namespace App\Http\Controllers\Admin;

use App\Models\Abonnement;
use App\Models\Company;
use App\Models\Payment;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Support\Carbon;

class RapportController extends CrudController
{
    //
    public function rapports()
    {

        $vente_annee = Payment::
        whereDate("created_at",">=",Carbon::today()->startOfYear()->toDateString())
            ->whereDate("created_at","<=",Carbon::today()->endOfYear())
            ->sum("montant");
        $vente_mois = Payment::
        whereDate("created_at",">=",Carbon::today()->startOfMonth()->toDateString())
            ->whereDate("created_at","<=",Carbon::today()->endOfMonth())
            ->sum("montant");
        $vente_semaine = Payment::
        whereDate("created_at",">=",Carbon::today()->startOfWeek()->toDateString())
        ->whereDate("created_at","<=",Carbon::today()->endOfWeek())
            ->sum("montant");
        $vente_journee = Payment::whereDate("created_at",Carbon::today()->toDateString())->sum("montant");

        return view('admin.rapports.rapports',[
            "ventes_mois"=>$vente_mois,
            "vente_journee"=>$vente_journee,
            "vente_semaine"=>$vente_semaine,
            "vente_annee"=>$vente_annee,
        ]);

    }
    //
    public function soldes()
    {
        $soldeAbonnes = 0;
        $soldePartners = 0;

        return view('admin.rapports.soldes',[
            "solde_comptes_abonnes"=>$soldeAbonnes,
            "solde_comptes_partenaires"=>$soldePartners,
            ]);

    }
    public function stats()
    {
        $nombreClients = Company::count();
        $nombreAbonnes = Abonnement::count();
        $achatsClient = Payment::count();

        return view('admin.rapports.stats',[
            "nombre_clients" => $nombreClients,
            "nombre_abonnes" => $nombreAbonnes,
            "nombre_achats"  => $achatsClient
            ]);

    }
}
