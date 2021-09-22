<?php

use Illuminate\Database\Seeder;
use App\Models\Project;
use Carbon\Carbon;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $pLists = ['Build website', 'Plumbing', 'House chores', 'Family time', 'Teach the kids'];
        
        foreach($pLists as $p) {
            Project::create(['name' => $p, 'description' => $p, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        }
    }
}
