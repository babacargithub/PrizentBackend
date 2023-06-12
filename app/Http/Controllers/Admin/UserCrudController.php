<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Policies\PermissionNames;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class UserCrudController extends \Backpack\PermissionManager\app\Http\Controllers\UserCrudController
{


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        if( ! backpack_user()->can(PermissionNames::CREATE_SUPPER_ADMIN_USER)){
            abort(403);
    }

        CRUD::setEntityNameStrings('utilisateur', 'utilisateurs');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    public function setupListOperation()
    {
        parent::setupListOperation();

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
    public function setupCreateOperation()
    {
        if( ! backpack_user()->can(PermissionNames::CREATE_SUPPER_ADMIN_USER)){
            abort(403);
        }
      parent::setupCreateOperation();

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
    public function setupUpdateOperation()
    {
        if( ! backpack_user()->can(PermissionNames::CREATE_SUPPER_ADMIN_USER)){
            abort(403);
        }
        parent::setupUpdateOperation();
    }
}
