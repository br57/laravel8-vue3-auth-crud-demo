<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Status;
use Illuminate\Support\Arr;
class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = Status::get()->pluck('id')->toArray();

        Company::factory()->count(100)->create()->each(function($company) use($statuses){
            $company->website = 'https://www.google.com';
            $company->logo = null;
            $company->status_id = Arr::random($statuses);
            $company->save();
            $count_emp = Arr::random([10,18,35,46,70]);
            Employee::factory()->count($count_emp)->create()->each(function($employee) use($statuses, $company){
                $employee->company_id = $company->id;
                $employee->phone = $company->id."9978480023";
                $employee->status_id = Arr::random($statuses);
                $employee->save();
            });
        });
    }
}
