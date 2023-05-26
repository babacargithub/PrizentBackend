<?php

namespace Database\Seeders;

use App\Models\Abonnement;
use App\Models\Appareil;
use App\Models\Company;
use App\Models\Employe;
use App\Models\Entree;
use App\Models\Feature;
use App\Models\Formule;
use App\Models\HoraireEmploye;
use App\Models\Journee;
use App\Models\Payment;
use App\Models\QrCode;
use App\Models\Sortie;
use App\Models\User;
use Artisan;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
        Artisan::call("db:reset");
        Artisan::call("user:create-super-admin",["email"=>"golobone@gmail.com"]);
        $user = User::factory()->create();
        $company = Company::factory()->make();
        $company->user()->associate($user);
        $company->save();
        $journee = Journee::factory()->create();
        $formule = Formule::factory()->create();
        $formule->features()->saveMany(Feature::factory()->count(20)->make());
        $abonnement = Abonnement::factory()->make();
        $abonnement->company()->associate($company);
        $abonnement->formule()->associate($formule);
        $abonnement->save();
        $abonnement->payments()->saveMany(Payment::factory()->count(20)->make());

        $qrCode = QrCode::factory()->make()->company()->associate($company);
        $qrCode->save();
        $horairesFactory = HoraireEmploye::factory();
        $horaires = [];
        for ($j = 0; $j < 7; $j++) {
            $horaire = $horairesFactory->definition();
            $horaires[] = $horaire;
        }

        for ($i=0; $i < 20; $i++) {
            $employe = Employe::factory()->make();
            $company->employes()->save($employe);
            $horairesArray = [];
            for ($j = 0; $j < 7; $j++) {
                $horairesArray[] = new HoraireEmploye($horaires[$j]);
            }
            $employe->horaires()->saveMany($horairesArray);

        $employe->appareils()->saveMany(Appareil::factory()->count(2)->make());
       // entrées
        $entree = Entree::factory()->make();
        $entree->employe()->associate($employe);
        $entree->journee()->associate($journee);
        $entree->qrCode()->associate($qrCode);
        $entree->calculerPonctualite();
        $entree->save();
        // sorties
        $sortie = Sortie::factory()->make();
        $sortie->employe()->associate($employe);
        $sortie->journee()->associate($journee);
        $sortie->qrCode()->associate($qrCode);
        $sortie->calculerPonctualite();
        $sortie->save();

        }
    }
}
