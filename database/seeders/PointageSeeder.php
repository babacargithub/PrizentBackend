<?php

namespace Database\Seeders;

use App\Models\Employe;
use App\Models\Entree;
use App\Models\Journee;
use App\Models\QrCode;
use App\Models\Sortie;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/** @noinspection PhpUnused */
class PointageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $journee = Journee::firstOrCreate(["calendrier" => Carbon::today()->toDateString(),"name" => Carbon::today()->toDateString()]);
            $employes = Employe::all();
            $sortieFactory = Sortie::factory();
            $entreeFactory = Entree::factory();
            $qrCode = QrCode::first();
            foreach ($employes as $employe) {
                $sorite = $sortieFactory->make();
                $entree = $entreeFactory->make();
                $sorite->journee()->associate($journee);
                $sorite->employe()->associate($employe);
                $sorite->qrCode()->associate($qrCode);
                $sorite->calculerPonctualite();
                $entree->employe()->associate($employe);
                $entree->journee()->associate($journee);
                $entree->qrCode()->associate($qrCode);
                $entree->calculerPonctualite();

                $entree->save();
                $sorite->save();
            }
        }


}
