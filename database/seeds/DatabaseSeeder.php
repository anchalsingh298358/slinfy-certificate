<?php

use App\User;
use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableDataSeeder::class);
        $this->call(CountryTableDataSeeder::class);

        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // disable fk constrain check
            // \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");

            // enable back fk constrain check
            // \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // Seed the default permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');

        $this->command->info('Default Permissions added.');

        // Confirm roles needed
        if ($this->command->confirm('Create Roles for user, default is super admin and admin? [y|N]', true)) {

            // Ask for roles from input
            $input_roles = $this->command->ask('Enter role in format.', 'Super Duper Admin');

            // Explode roles
            $roles_array = explode(',', $input_roles);

            // add roles
            foreach($roles_array as $role) {
                $role = Role::firstOrCreate(['name' => trim($role)]);

                if( $role->name == 'Super Duper Admin' ) {
                    // assign all permissions
                    $role->syncPermissions(Permission::all());
                    $this->command->info('Admin granted all the permissions');
                } else {
                    // for others by default only read access
                    $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
                }

                // create one user for each role
                $this->createUser($role);
            }

            $this->command->info('Roles ' . $input_roles . ' added successfully');

        } else {
            //Role::firstOrCreate(['name' => 'User']);

            // Explode roles
            $roles_array = ['Super Duper Admin'];

            // add roles
            foreach($roles_array as $role) {
                $role = Role::firstOrCreate(['name' => trim($role)]);

                if( $role->name == 'Super Duper Admin' ) {
                    // assign all permissions
                    $role->syncPermissions(Permission::all());
                    $this->command->info('Super Duper Admin granted all the permissions');
                } else {
                    // for others by default only read access
                    $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
                }
                
            }

            $this->command->info('Added only default user role.');
        }


        // now lets seed some posts for demo
        // factory(\App\Post::class, 30)->create();
        // $this->command->info('Some Posts data seeded.');
        $this->command->warn('All done :)');
    }

    private function createUser($role)
    {
        $user = new User;
        $user->name = "Super Duper Admin";
        $user->email = "superduperadmin@yopmail.com";
        $user->password = Hash::make('12345678');
        $user->role_type = 'Super Duper Admin';
        $user->role_id = $role->id;
        $user->save();


        // $user = factory(User::class)->create(['role_id' => $role->id]);
        $user->assignRole($role->name);

        if( $role->name == 'Super Duper Admin' ) {
            $this->command->info('Here is your admin details to login:');
            $this->command->warn($user->email);
            $this->command->warn('Password is "12345678"');
        }
    }
}
