<?php

namespace App\Console\Commands;

use App\Policies\PermissionNames;
use App\Policies\RoleNames;
use Backpack\PermissionManager\app\Models\Permission;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Console\Command;

class CreateRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create roles  for the app user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->saveRoles();
        $this->savePermissions();

        return 0;
    }

    public function saveRoles(): void
    {
        $roleNames = RoleNames::ROLES;
        $roles = [];
        foreach ($roleNames as $roleName) {
            $roles[] = ["name" => $roleName, "guard_name" => "web"];

        }
        Role::insert($roles);
    }

    public function savePermissions(): void
    {
        $permissionNames = PermissionNames::PERMISSION_NAMES;
        $permissions = [];
        foreach ($permissionNames as $permissionName) {
            $permissions[] = ["name" => $permissionName, "guard_name" => "web"];

        }
        Permission::insert($permissions);

    }
}

