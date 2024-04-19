<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\StoreCompanyRequest;
use App\Models\Abonnement;
use App\Models\Commercial;
use App\Models\Company;
use App\Models\Feature;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
    public function setup(): void
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
    protected function setupListOperation(): void
    {
        CRUD::column('nom')->label("Nom de la société");
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
    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(CompanyRequest::class);
        CRUD::field('nom')->label("Nom de la société");
        CRUD::field('email');
        CRUD::field('telephone')->label("Contact");
        CRUD::field('adresse')->label("Adresse");
        $this->crud->addField([
            'name'=>'region',
            'label'=>'Région',
            'type'=>'select_from_array',
            'options'=>[
                'DAKAR'=>'DAKAR',
                'THIES'=>'THIES',
                'DIOURBEL'=>'DIOURBEL',
                'FATICK'=>'FATICK',
                'KAOLACK'=>'KAOLACK',
                'KOLDA'=>'KOLDA',
                'LOUGA'=>'LOUGA',
                'MATAM'=>'MATAM',
                'SAINT-LOUIS'=>'SAINT-LOUIS',
                'KAFFRINE'=>'KAFFRINE',
                'SEDHIOU'=>'SEDHIOU',
                'TAMBACOUNDA'=>'TAMBACOUNDA',
                'KEDOUGOU'=>'KEDOUGOU',
                'ZIGUINCHOR'=>'ZIGUINCHOR',
            ]
        ]);
        CRUD::field('latitude');
        CRUD::field('longitude');
        $this->crud->addField([
            'name'=>'custom',
            'label'=>"Type d'abonnement",
            'type'=>'radio',
            'attributes' => [
                'id' => 'type_abonnement',
                'required' => 'required',
            ],
            'options'=>['custom'=>'Personnalisé','pre_defined'=>'Formule prédéfinie']
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
     * @noinspection PhpUnused
     */
    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    public function store(StoreCompanyRequest $request)
    {
        $data = $request->all();
        $data = $this->crud->getStrippedSaveRequest($request);
        $custom = $data['custom'] == 'custom';

        $company = new Company($data);
        // Create user account
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
        // TODO decide what to do with the default length of trial period and whether it should be enabled
//        $abonnement = new Abonnement(["date_expir" => Carbon::now()->addDays(3)->toDateTimeString()]);
//        $abonnement->formule()->associate(Formule::first());
//        $abonnement->company()->associate($company);
//        $abonnement->save();
        $userAccount->save();
        // create params
        $params = Params::all();

        foreach ($params as $param) {
            $company->params()->save($param);
        }
        // create entry data for  the salesperson who created it
        $commercial = Commercial::whereUserId(backpack_user()->id)->first();
        if ($commercial != null){
            $company->commercial()->associate($commercial);
            $company->save();
        }

        // show a success message
        Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();
        return $this->createAbonnementForm($company, $data['custom']);


    }
    public function createAbonnementForm(Company $company, $type_abonnement)
    {
        CRUD::setCreateView('admin.company.create_abonnement');
        $this->crud->addField([
            'name' => 'formule',
            'label' => "Abonner à la formule",
            'type' => 'select',
            'entity' => 'abonnement',
            'attribute' => 'nom',
            'model' => Formule::class,
            'query' => function ($query) {
                return $query->where('custom', false);
            },
            'attributes' => [
                'id' => 'formule',
                'required' => 'required',
            ],


        ]);
        $this->crud->addField([
            'name' => 'duree',
            'label' => "Durée de l'abonnement",
            'type' => 'number',
            'attributes' => [
                'id' => 'number',
                'required' => 'required',
            ],
        ]);
        $this->crud->addField([
            'name' => 'unite',
            'label' => "En",
            'type' => 'select_from_array',
            'options' => ['jour' => 'jour', 'semaine' => 'semaine', 'mois' => 'mois', 'année' => 'année'],
            'attributes' => [
                'id' => 'unite',
                'required' => 'required',
            ],
        ]);
        $this->crud->addField([
            'name'=>'prix',
            'type'=>'number',
            'label'=>'Prix de l\'abonnement',
        ]);
        return view('admin.company.create_abonnement',['crud'=>$this->crud,'company'=>$company,
            'formules'=>Formule::preDefined()->get(),
            'features'=>Feature::all(),
            'type_abonnement' => $type_abonnement,
            ],

        );

    }

    public function createCustomAbonnement(Company $company, Request $request)
    {
        $custom = $request->input('custom');
        $custom_validator =[
            'unite' => ['required','string', Rule::in(['jour', 'semaine', 'mois', 'annee'])],
            'duree' => 'required|integer',
            'prix' => 'required|integer',
            'limite' => 'required|integer',
            'features' => 'required|array',
            'features.*' => 'required|string|exists:features,constant_name'

        ];
        $pre_defined_validator = [
            'formule_id' => ['required','integer','exists:formules,id'],
            'duree' => 'required|integer',

        ];

        $data = $custom ? $request->validate($custom_validator) : $request->validate($pre_defined_validator);
        if ($custom) {
            $data['features'] = array_map(function ($feature) {
                return Feature::whereConstantName($feature)->firstOrFail()->id;
            }, $data['features']);
            $formule = new Formule($data);
            $formule->nom = "Abonnement de " . $company->nom;
            $formule->comment = 'Abonnement personnalisé pour ' . $company->nom . ' pour une durée de ' . $data['duree'] . ' ' . $data['unite'] . ' à ' . $data['prix'] . ' FCFA par ' . $data['unite'] . '.';
            $formule->custom = true;
            $formule->save();
            $formule->features()->attach($data['features']);
            $formule->save();
        } else {
            $formule = Formule::findOrFail($data['formule_id']);
            $data['unite'] = $formule->unite;
        }
        $abonnement = new Abonnement();
        $abonnement->formule()->associate($formule);
        $abonnement->company()->associate($company);
        $expir_date = Carbon::now();
        switch ($data['unite']) {
            case 'jour':
                $expir_date->addDays($data['duree']);
                break;
            case 'semaine':
                $expir_date->addWeeks($data['duree']);
                break;
            case 'mois':
                $expir_date->addMonths($data['duree']);
                break;
            case 'annee':
                $expir_date->addYears($data['duree']);
                break;
        }
        $abonnement->date_expir = $expir_date->toDateTimeString();
        $abonnement->save();
        $company->save();

        // calculer la commission du commercial
        //TODO implementer la commission du commercial
       /* $commercial = Commercial::whereUserId(backpack_user()->id)->first();
        if ($commercial != null){
            $company->commercial()->associate($commercial);
            $company->save();
            $commercial->commission += $formule->prix * 0.1;
            $commercial->save();
        }*/

        return redirect()->route('company.index');
    }


}
