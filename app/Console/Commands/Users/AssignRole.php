<?php

namespace App\Console\Commands\Users;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:assign-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign Role To User';

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
        $ask_role = $this->ask('Enter role name');
        if($ask_role) {
            $role = Role::where(['name' => $ask_role])->first();
            if($role) {
                $ask_user_email = $this->ask('Enter user email');
                if($ask_user_email) {
                    $user = User::where(['email' => $ask_user_email])->first();
                    if($user) {
                        $user->syncRoles([]);
                        $user->assignRole(Role::findById($role->id));
                        $this->info('Role '. $role->name .' is successfully accepted to user '. $user->email);
                    } else {
                        $this->error('User email doesnt exists');
                    }
                }
            } else {
                $this->error('Role name doesnt exists');
            }
        }
    }
}
