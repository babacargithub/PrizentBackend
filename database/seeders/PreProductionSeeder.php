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
use App\Models\Params;
use App\Models\Payment;
use App\Models\QrCode;
use App\Models\Sortie;
use App\Models\User;
use App\Policies\RoleNames;
use Artisan;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PreProductionSeeder extends Seeder
{

    const FEATURES = [
        ["public_name"=>"Pointage", "constant_name"=>Feature::FEATURE_POINTAGE,],
        ["public_name"=>"Classement des employés", "constant_name"=>Feature::FEATURE_RANKINGS],
        ["public_name"=>"Badge physique", "constant_name"=>Feature::FEATURE_PHYSICAL_BADGE],
        ["public_name"=>"Rapport de l'employé", "constant_name"=>Feature::FEATURE_REPORTS],
        ["public_name"=>"Impression de rapports", "constant_name"=>Feature::FEATURE_REPORT_EXPORT],
        ["public_name"=>"Notification SMS à chaque pointage", "constant_name"=>Feature::FEATURE_SMS_NOTIFICATIONS],
        ["public_name"=>"Vérification de localisation", "constant_name"=>Feature::FEATURE_LOCATION_CONSTRAINT],
        ["public_name"=>"Plusieurs utilisateurs", "constant_name"=>Feature::FEATURE_MULTIPLE_ACCOUNT],
    ];
    const FORMULE_FEATURES =[
        "BASIC"=>[Feature::FEATURE_POINTAGE,Feature::FEATURE_PHYSICAL_BADGE],
        "PME"=>[Feature::FEATURE_POINTAGE,Feature::FEATURE_PHYSICAL_BADGE, Feature::FEATURE_REPORTS],
        "BUSINESS"=>[Feature::FEATURE_POINTAGE,Feature::FEATURE_PHYSICAL_BADGE, Feature::FEATURE_REPORTS, Feature::FEATURE_LOCATION_CONSTRAINT,Feature::FEATURE_SMS_NOTIFICATIONS],
        "CORPORATE"=>[Feature::FEATURE_POINTAGE,
            Feature::FEATURE_PHYSICAL_BADGE,
            Feature::FEATURE_REPORTS,
            Feature::FEATURE_LOCATION_CONSTRAINT,
            Feature::FEATURE_SMS_NOTIFICATIONS,
            Feature::FEATURE_MULTIPLE_ACCOUNT],
        "ENTREPRISE"=>[Feature::FEATURE_POINTAGE,
            Feature::FEATURE_PHYSICAL_BADGE,
            Feature::FEATURE_REPORTS,
            Feature::FEATURE_LOCATION_CONSTRAINT,
            Feature::FEATURE_SMS_NOTIFICATIONS,
            Feature::FEATURE_MULTIPLE_ACCOUNT],
        "ILLIMITE"=>[Feature::FEATURE_POINTAGE,
            Feature::FEATURE_PHYSICAL_BADGE,
            Feature::FEATURE_REPORTS,
            Feature::FEATURE_LOCATION_CONSTRAINT,
            Feature::FEATURE_SMS_NOTIFICATIONS,
            Feature::FEATURE_MULTIPLE_ACCOUNT]
    ];
    const FORMULES = [
        ["nom"=>"BASIC", "comment"=>"Ideal", "prix"=>10000, "limite"=>4, "duree"=>1, "unite"=>"mois"],
        ["nom"=>"PME", "comment"=>"Idéal", "prix"=>25000, "limite"=>8, "duree"=>1, "unite"=>"mois",
        ],
        ["nom"=>"BUSINESS", "comment"=>"idéal","prix"=>50000, "limite"=>20, "duree"=>1, "unite"=>"mois"],
        [
            "nom"=>"CORPORATE", "comment"=>"idéal", "prix"=>100000, "limite"=>40, "duree"=>1, "unite"=>"mois",

        ],

        ["nom"=>"ENTREPRISE", "comment"=>"idéal", "prix"=>200000, "limite"=>100, "duree"=>1, "unite"=>"mois",
           ],
        ["nom"=>"ILLIMITE", "comment"=>"idéal", "prix"=>350000, "limite"=>100000, "duree"=>1, "unite"=>"mois",
            ],
    ];
    const PARAMS = [
        ["nom"=>Params::PARAM_NOTIFICATION_SORITE, "constant_name"=>Params::PARAM_NOTIFICATION_SORITE],
        ["nom"=>Params::PARAM_NOTIFICATION_ENTREE,'constant_name'=>Params::PARAM_NOTIFICATION_ENTREE]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
        Artisan::call("db:reset");
        Artisan::call("user:create-super-admin",["email"=>"pdzprizent@gmail.com"]);

        $formules = Formule::insert(self::FORMULES);
        $features = Feature::insert(self::FEATURES);
        foreach (self::FORMULES as $formule) {
            $features = self::FORMULE_FEATURES[$formule["nom"]];
            $formule = Formule::whereNom($formule["nom"])->first();
                    foreach ($features as $feature) {

            $formule->features()->save(Feature::whereConstantName($feature)->first());
        }
        }

        $params = Params::insert(self::PARAMS);


    }
}
