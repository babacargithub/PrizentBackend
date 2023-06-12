<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Policies\PermissionNames;
use App\Policies\RoleNames;
use Backpack\PermissionManager\app\Models\Permission;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-super-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a super admin user for the app';

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
        $user = User::find(1);
        if ($user != null){
           $this->error("Un utilisateur existe déjà, le super admin est crée au debut de l'application");
        }else{
            Artisan::call("user:create-roles");
            $user = User::create(["name"=>"Directeur Général Prizent","email"=>$this->argument("email"),"password"=>Hash::make("0000")]);
            $user->assignRole(RoleNames::ROLE_PRIZENT_CEO);
            $user->save();
            $this->info("Super admin user created success");
        }
        return 0;
    }
}
