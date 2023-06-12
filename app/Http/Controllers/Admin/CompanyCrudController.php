<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\StoreCompanyRequest;
use App\Models\Abonnement;
use App\Models\Company;
use App\Models\CompanyParams;
use App\Models\Formule;
use App\Models\Params;
use App\Models\User;
use App\Policies\RoleNames;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * Class CompanyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CompanyCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Company::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/company');
        CRUD::setEntityNameStrings('Société', 'Sociétés');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     * @noinspection PhpUnused
     */
    protected function setupListOperation()
    {
        CRUD::column('nom');
        CRUD::column('telephone')->label("Contact");
        CRUD::column('email');
        CRUD::column('latitude');
        CRUD::column('longitude');


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CompanyRequest::class);
        CRUD::field('nom');
        CRUD::field('email');
        CRUD::field('telephone');
        CRUD::field('adresse');
        CRUD::field('region');
        CRUD::field('latitude');
        CRUD::field('longitude');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     * @noinspection PhpUnused
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = new Company($this->crud->getStrippedSaveRequest($request));
        $userAccount = new User();
        $userAccount->email = $company->email;
        $userAccount->name = $company->nom;
        $userAccount->email_verified_at = Carbon::now();
        $userAccount->password = Hash::make("0000");
        $userAccount->save();
        $userAccount->assignRole(RoleNames::ROLE_COMPANY_CEO);
        $userAccount->telephone = $company->telephone;
        $company->user()->associate($userAccount);
        $company->save();
        $abonnement = new Abonnement(["date_expir" => Carbon::now()->addDays(2)->toDateTimeString()]);
        $abonnement->formule()->associate(Formule::first());
        $abonnement->company()->associate($company);
        $abonnement->save();
        $userAccount->save();
        // create params
        $params = Params::all();

        foreach ($params as $param) {
            $company->params()->save($param);
        }
        // show a success message
        Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($company->getKey());
    }

}
