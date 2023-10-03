<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Http\Requests\CommercialRequest;
use App\Http\Requests\StoreCompanyRequest;
use App\Models\Abonnement;
use App\Models\Commercial;
use App\Models\Company;
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
 * Class CommercialCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CommercialCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Commercial::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/commercial');
        CRUD::setEntityNameStrings('commercial', 'commercials');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('nom');
        CRUD::column('telephone');
        CRUD::column('email');
        CRUD::column('sexe');

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
        CRUD::setValidation([
            // 'name' => 'required|min:2',
        ]);

        CRUD::field('nom');
        CRUD::field('telephone');
        CRUD::field('email');
        CRUD::field('sexe');
        $this->crud->setValidation(CommercialRequest::class);

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
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
    public function store(CommercialRequest $request)
    {
        $commercial = new Commercial($this->crud->getStrippedSaveRequest($request));
        $userAccount = new User();
        $userAccount->email = $commercial->email;
        $userAccount->name = $commercial->nom;
        $userAccount->email_verified_at = Carbon::now();
        $userAccount->password = Hash::make("0000");
        $userAccount->save();
        $userAccount->assignRole(RoleNames::ROLE_PRIZENT_EMPLOYEE);
        $userAccount->telephone = $commercial->telephone;
        $commercial->user()->associate($userAccount);
        $commercial->save();
        $userAccount->save();
        // create params
        // show a success message
        Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($commercial->getKey());
    }
}
