<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;
class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statues = collect([
            ['label' => 'Active'],
            ['label' => 'Pending'],
            ['label' => 'In Active'],
        ]);

        $statues->each(function ($status){
            $newStatus = new Status;
            $newStatus->fill($status);
            $newStatus->slug = makeSlug($newStatus->label, 'status');
            $newStatus->save();
        });
    }
}
