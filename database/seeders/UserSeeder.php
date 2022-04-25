<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Status;
use Illuminate\Support\Arr;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('password');
        $users = collect([
            [
                'name'  => 'Super Admin',
                'email' =>  's.admin@laravue3.local',
                'phone' =>  '9999999999',
                'password' => $password,
                'admin_type' => 'super-admin',
            ],
            [
                'name'  => 'Admin',
                'email' =>  'a.admin@laravue3.local',
                'password' => $password,
                'phone' =>  '8888888888',
                'admin_type' => 'admin',
            ],
            [
                'name'  => 'Company Admin',
                'email' =>  'c.admin@laravue3.local',
                'phone' =>  '7777777777',
                'password' => $password,
                'admin_type' => 'company-admin',
            ],
            [
                'name'  => 'HR Admin',
                'phone' =>  '5555555555',
                'email' =>  'hr.admin@laravue3.local',
                'password' => $password,
                'admin_type' => 'hr-admin',
            ],
            [
                'name'  => 'HR Assistant Admin',
                'phone' =>  '4444444444',
                'email' =>  'hra.admin@laravue3.local',
                'password' => $password,
                'admin_type' => 'hr-assistant-admin',
            ]
        ]);
        $allStatuses = Status::get()->pluck('id')->toArray();
        $users->each(function($user) use($allStatuses){
            $role = Role::firstWhere('name', $user['admin_type']);
            unset($user['admin_type']);
            $newUser = new User;
            $newUser->fill($user);
            $newUser->status_id = 1;
            // $newUser->status_id = Arr::random($all_Statuses);
            $newUser->save();
            $newUser->assignRole($role);
        });
    }
}
