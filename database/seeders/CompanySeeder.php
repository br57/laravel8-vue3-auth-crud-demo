<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Status;
use Illuminate\Support\Arr;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $appDomain = env('APP_DOMAIN');
        $sysUser = User::firstWhere('email', "sys@{$appDomain}");
        $statuses = Status::get()->pluck('id')->toArray();
        $password = Hash::make('password');
        Company::factory()->count(30)->create()->each(function($company) use($statuses, $password, $sysUser){

            $company->website = 'https://www.google.com';
            $company->logo = null;
            $company->status_id = Arr::random($statuses);
            $company->user_id = $sysUser->id;
            $company->save();

            $count_emp = Arr::random([5,10,15,20,25]);

            $phone_emp = Arr::random([
                9978480023,
                9727757057,
                9727790777,
                9727740077,
                9727740075,
                9727757055,
                9727792111,
            ]);

            $role_company_admin = Role::firstWhere('name', 'company-admin');
            User::factory()->count(1)->create()->each(function($user) use($statuses, $password, $role_company_admin, $company){
                $user->password = $password;
                $user->status_id = 1;
                $user->company_id = $company->id;
                $user->save();
                $user->assignRole($role_company_admin);
            });

            $role_hr = Role::firstWhere('name', 'hr-admin');
            User::factory()->count(1)->create()->each(function($user) use($statuses, $password, $role_hr, $company){
                $user->password = $password;
                $user->company_id = $company->id;
                $user->status_id = 1;
                $user->save();
                $user->assignRole($role_hr);
            });
            
            $role_hra = Role::firstWhere('name', 'hr-assistant-admin');
            User::factory()->count(1)->create()->each(function($user) use($statuses, $password, $role_hra, $company){
                $user->password = $password;
                $user->status_id = 1;
                $user->company_id = $company->id;
                $user->save();
                $user->assignRole($role_hra);
            });

            Employee::factory()->count($count_emp)->create()->each(function($employee) use($statuses, $company, $phone_emp, $sysUser){
                $employee->status_id = Arr::random($statuses);
                $employee->company_id = $company->id;
                $employee->phone = $phone_emp;
                $employee->user_id = $sysUser->id;
                $employee->save();
            });
            
        });
    }
}
