<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AbonnementRequest;
use App\Models\Abonnement;
use App\Rules\PhoneNumber;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class AbonnementCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AbonnementCrudController extends CrudController
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
        CRUD::setModel(Abonnement::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/abonnement');
        CRUD::setEntityNameStrings('abonnement', 'abonnements');
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
        $this->crud->orderBy("date_expir","desc");
        $this->crud->addColumn(["label"=>"Société","type"=>"entity", "relation"=>"company","attribute"=>"nom"]);
       $this->crud->addColumn(["label"=>"Formule","type"=>"entity", "relation"=>"formule","attribute"=>"nom"]);
        CRUD::column('date_expir')->label("Expire le");

        $this->crud->removeAllButtonsFromStack("top");


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
        $request = request();
        $request->validate(  [
        'date_expir' => 'date',
    ]);

        CRUD::field('date_expir');
        CRUD::field('formule_id');

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
}
