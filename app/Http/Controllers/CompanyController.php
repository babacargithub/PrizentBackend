<?php /** @noinspection UnknownColumnInspection */

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Formule;
use App\Models\User;
use App\Policies\RoleNames;
use App\Rules\PhoneNumber;
use Backpack\PermissionManager\app\Models\Permission;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return Company
     */
    public function show()
    {
        $company = Company::requireLoggedInCompany();
        $company->load("abonnement");
        $company->load("abonnement.formule");
        $company->load("params");
        $company->load("user");

        return $company;
    } /**
     * Display the specified resource.
     *
     * @return array
 */
    public function abonnementShow()
    {
        $abonnement = Company::requireLoggedInCompany()->abonnement;
        if ($abonnement != null){
            $abonnement->load('formule');
        }
        $formules = $abonnement->isCustom()?[]: Formule::with("features")->get();

        return ["abonnement"=>$abonnement, "formules"=>$formules];
    }
    public function pointeurs()
    {
        $company = Company::requireLoggedInCompany();
        return ["pointeurs"=>$company->employes()->get(),
        "users"=>$company->users];

    }

    public function update( UpdateCompanyRequest $updateCompanyRequest)
    {
        $company = Company::requireLoggedInCompany();
         $company->update($updateCompanyRequest->input());
         return $company;
    }

    public function updateParams()
    {
        $company = Company::requireLoggedInCompany();
        $params = request()->input();
                 foreach ($params as $param) {
                     $company->params()->updateExistingPivot($param["id"],["enabled"=>$param["pivot"]["enabled"]]);
                     //          $employe->horaires()->update($horaire);
                 }

        return new Response("OK. Updated");

    }

    /**
     * @param Request $request
     * @return User|JsonResponse
     */
    public function createUser(Request $request)
    {
        if ( ! $this->isCompanyCEO()){
            return  $this->forbiddenResponse();

        }
        $validated = $request->validate([
            "email"=>"required|email|unique:users",
            "name"=>"required|string"
        ]);
        $user = new User($validated);
        $user->password = Hash::make("0000");
        $user->email_verified_at = null;
        $user->assignRole(RoleNames::ROLE_COMPANY_EMPLOYEE);
        $user->save();
        Company::requireLoggedInCompany()->users()->save($user);

        return $user;

    }

    /**
     * @param User $user
     * @param Request $request
     * @return User|JsonResponse
     */
    public function updateUser(User $user, Request $request)
    {
        // action is only allowed for ceo
        if ( !$this->isCompanyCEO()){
            return  $this->forbiddenResponse();
        }
        // if user does not belong to company
        if (!$this->isActionAllowedOnUser($user)){
            return  $this->forbiddenResponse();

        }
        $validated = $request->validate([
            "disabled"=>['boolean'],
            "name"=>['string'],
            "email"=>['email', Rule::unique('users')->ignore($user->id),
            ],
            "telephone"=>["nullable",new PhoneNumber()],
        ]
        );
        $user->update($validated);
        return $user;

    }/**
     * @param User $user
     * @param Request $request
     * @return User|JsonResponse
     */
    public function deleteUser(User $user, Request $request)
    {
        // action is only allowed for ceo
        if ( !$this->isCompanyCEO()){
            return  $this->forbiddenResponse();
        }
        // if user does not belong to company
        if (!$this->isActionAllowedOnUser($user)){
            return  $this->forbiddenResponse();

        }
        $request->validate([
            "password"=>["required", function($attribute, $value, $fail) use ($request){
                if(!Hash::check($request->input('password'), $request->user()->password)){
                    $fail("Mot de passe incorrect !");
                }
            }]
        ]
        );
        $user->delete();

        return response()->json(["message"=>"deleted"])->setStatusCode(204);

    } /**
     * @param User $user
     * @param Request $request
     * @return User|JsonResponse
     */
    public function updatePermissions(User $user, Request $request)
    {
        // action is only allowed for ceo
        if ( !$this->isCompanyCEO()){
            return  $this->forbiddenResponse();
        }
        // if user does not belong to company
        if (!$this->isActionAllowedOnUser($user)){
            return  $this->forbiddenResponse();

        }
        $validated = $request->validate([
            "permissions"=>['required','array'],
        ]
        );
        $permissions = $validated["permissions"];
        foreach ($permissions as $permission ) {
            $enabled = $permission["enabled"];
            if ($enabled) {
                $user->givePermissionTo($permission["name"]);
            } else {
                $user->revokePermissionTo($permission["name"]);
            }
            $user->save();
        }

        return $user;

    }

    /**
     * @param User $user
     * @return array|JsonResponse
     */
    public function getUserPermissions(User $user)
    {
        // action is only allowed for ceo
        if ( !$this->isCompanyCEO()){
            return  $this->forbiddenResponse();
        }
        // if user does not belong to company
        if (!$this->isActionAllowedOnUser($user)){
            return  $this->forbiddenResponse();

        }
        $roles = Company::requireLoggedInCompany()->user->roles;
        $permissions = [];
        foreach ( $roles as $role ) {
            $companyUserAccountPermissions = $role->permissions;

            foreach ($companyUserAccountPermissions as /** @var Permission $permission */ $permission) {
                $item = ["name" => $permission->name, "enabled" => $user->hasPermissionTo($permission->name)];
                $permissions[] = $item;

            }
        }

        return $permissions;

    }

    public function getUsers()
    {
        if ( ! $this->isCompanyCEO()){
            return  $this->forbiddenResponse();
        }
        return Company::requireLoggedInCompany()->users;
    }
    public function isCompanyCEO(): bool
    {
        return request()->user()->hasRole(RoleNames::ROLE_COMPANY_CEO,"web");

    }

    /**
     * @return JsonResponse
     */
    public function forbiddenResponse(): JsonResponse{

        return  response()->json(["message"=>"Action non autorisée !"])->setStatusCode(403);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isActionAllowedOnUser(User $user): bool
    {

        return Company::requireLoggedInCompany()->users()->where("users.id", $user->id)->first() !== null;
    }

}
