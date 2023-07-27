<?php

namespace App\Console\Commands\Roles;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install roles&permission from config/roles_permissions.php';

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
    public function handle()
    {
        $config = json_decode(json_encode(config('roles_permissions')),false);
        if(isset($config->roles)) {
            foreach ($config->roles as $role) {
                if(Role::where(['name' => trim($role)])->exists() == false ) {
                    Role::create([
                        'name' => trim($role)
                    ]);
                    $this->info('Role [ '.$role.' ] successfully installed!');
                }
            }
        }
        if(isset($config->permissions)) {
            foreach ($config->permissions as $permission) {
                if(Permission::where(['name' => $permission])->exists() == false ) {
                    Permission::updateOrCreate(
                        ['name' => $permission],
                        ['title' => $permission]
                    );
                    $this->info('Permission [ '.$permission.' ] successfully installed!');
                }
            }
        }
        if(isset($config->install)) {
            foreach ($config->install as $role => $permissions) {
                $role_to = Role::where(['name' => trim($role)])->first();
                if($role_to) {
                    $role_to->syncPermissions([]);
                    foreach ($permissions as $permission) {
                        $role_to->givePermissionTo($permission);
                        $this->info('Role ('.$role.') was updated permission '. $permission);
                    }
                }
            }
        }
    }
}
