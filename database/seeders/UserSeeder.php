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
        $appDomain = env('APP_DOMAIN');
        $password = Hash::make('password');

        $sysUser = new User;
        $sysUser->name = "System Update";
        $sysUser->email = "sys@{$appDomain}";
        $sysUser->phone = 9725263940;
        $sysUser->password = $password;
        $sysUser->status_id = 1;
        $sysUser->save();

        $autoUser = new User;
        $autoUser->name = "Auto Update";
        $autoUser->email = "auto@{$appDomain}";
        $autoUser->phone = 9725155851;
        $autoUser->password = $password;
        $autoUser->status_id = 1;
        $autoUser->save();

        if(!is_null($sysUser)){
            Status::get()->each(function($s) use($sysUser){
                $s->user_id = $sysUser->id;
                $s->save();
            });
        }

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
        $statuses = Status::get()->pluck('id')->toArray();
        $users->each(function($user) use($statuses){
            $role = Role::firstWhere('name', $user['admin_type']);
            unset($user['admin_type']);
            $newUser = new User;
            $newUser->fill($user);
            $newUser->status_id = 1;
            $newUser->save();
            $newUser->assignRole($role);
        });

        $user_role = Role::firstWhere('name', 'user');
        User::factory()->count(50)->create()->each(function($user) use($statuses, $password, $user_role){
            $user->password = $password;
            $user->status_id = Arr::random($statuses);
            $user->save();
            $user->assignRole($user_role);
        });
    }
}
