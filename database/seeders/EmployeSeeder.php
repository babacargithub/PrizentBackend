<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employe;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
        $user = User::factory()->create();
        $company = Company::factory()->make();
        $company->user()->associate($user);
        $company->save();
        $employees = Employe::factory()->count(20)->make();
        $company->employes()->saveMany($employees);

    }
}
