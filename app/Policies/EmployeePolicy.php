<?php /** @noinspection PhpUnusedParameterInspection */

namespace App\Policies;

use App\Models\Company;
use App\Models\Employe;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        //
        //TODO change later
        return true;
//        return Company::requireLoggedInCompany()->hasActiveSubscription();

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Employe $employee
     * @return bool
     */
    public function view(User $user, Employe $employee): bool
    {
        //
        //TODO change later
        return true;
//        return $user->id == $employee->company->user->id;

    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        //
        return Company::requireLoggedInCompany()->hasActiveSubscription();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Employe $employee
     * @return Response|bool
     */
    public function update(User $user, Employe $employee): Response|bool
    {
        //
        return $user->id == $employee->company->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Employe $employee
     * @return bool
     */
    public function delete(User $user, Employe $employee): bool
    {
        //
        return $user->id == $employee->company->user->id;

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Employe $employee
     * @return Response|bool
     */
    public function restore(User $user, Employe $employee): Response|bool
    {
        //
        return $user->id == $employee->company->user->id;

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Employe $employee
     * @return Response|bool
     */
    public function forceDelete(User $user, Employe $employee): Response|bool
    {
        //
        return $user->id == $employee->company->user->id;

    }
}
