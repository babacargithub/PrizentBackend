<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FormuleRequest;
use App\Models\Formule;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FormuleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class FormuleCrudController extends CrudController
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
        CRUD::setModel(Formule::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/formule');
        CRUD::setEntityNameStrings('formule', 'formules');
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
        CRUD::column('comment');
        CRUD::column('limite');
        CRUD::column('prix');
        CRUD::column('duree');
        CRUD::column('unite');


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
        CRUD::setValidation(FormuleRequest::class);

        CRUD::field('nom');
        $this->crud->addField([
            'name' => 'limite',
            'label' => "Maximum d'employés",
            'type' => 'number'
        ]);
        CRUD::field('prix');
        $this->crud->addField([
            'name' => 'unite',
            'label' => "La formule est valable pour",
            'type' => 'select_from_array',
            'options' => ['jour'=>'jour', 'semaine'=>'semaine','mois' => 'mois', 'année' => 'année']
        ]);
        $this->crud->addField([
            'name' => 'duree',
            'label' => "Durée",
            'type' => 'number'
        ]);



        $this->crud->addField([
            'name' => 'features',
            'label' => "Fonctionnalités",
            'type' => 'select_multiple',
            'entity' => 'features',
            'attribute' => 'public_name',
            'multiple' => true,
            'model' => "App\Models\Feature",
            'pivot' => true,
        ]);

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
    public function setupShowOperation()
    {
        $this->autoSetupShowOperation();
        $this->crud->addColumn( ['label'     => 'Fonctionnalités', // Table column heading
   'type'      => 'select_multiple',
   'name'      => 'features', // the method that defines the relationship in your Model
   'entity'    => 'features', // the method that defines the relationship in your Model
   'attribute' => 'public_name', // foreign key attribute that is shown to user
   'model'     => 'App\Models\Feature', ]); // the method that defines the relationship in your Model
    }
}
