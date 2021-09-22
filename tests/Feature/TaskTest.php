<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

use App\Models\Task;
use App\Models\Project;

class TaskTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Can load the home page of tasks
     */
    public function test_task_home()
    {
        $response = $this->get('/task');
        $response->assertStatus(200);
    }

    /**
     * Can load the home page of projects
     */
    public function test_project_home()
    {
        $response = $this->get('/project');
        $response->assertStatus(200);
    }

    /**
     * Can create a new project
     */
    public function test_create_project()
    {
        $response = $this->post('/project', [
            'name' => 'Project nae', 
            'description' => 'Project description'
        ]);
        
        $response->assertStatus(302);
    }

    /**
     * Can create a new task
     */
    public function test_create_task()
    {
        
        $response = $this->post('/task', [
            'name' => 'Task name', 
            'priority' => 'urgent', 
            'schedule_date_date' => '2020-12-12',
            'schedule_date_time' => '12:22',
            'project_id' => 1,
        ]);
        $response->assertStatus(302);
    }

    /**
     * Can edit a task
     */
    public function test_edit_task()
    {
        Task::create([
            'name' => 'Task name', 
            'priority' => 'urgent', 
            'schedule_date' => '2020-12-12 12:22:00',
            'project_id' => 1
        ]);
        $response = $this->post('/task/update', [
            'task_id' => 1,
            'name' => 'Updated task name', 
            'priority' => 'normal', 
            'schedule_date_date' => '2020-12-12',
            'schedule_date_time' => '10:08',
            'project_id' => '1',
        ]);
        $response->assertStatus(302);
    }

    /**
     * Can reorder tasks
     */
    public function test_reorder_task()
    {
        foreach([30,31] as $id) {
            Task::create([
                'id' => $id,
                'name' => 'Task name', 
                'priority' => 'urgent', 
                'schedule_date' => '2020-12-12 12:22:00',
                'project_id' => 1
            ]);
        }

        $response = $this->post('/task/reorder', [
            'ids' => [30,31]
        ]);
        $response->assertStatus(200);
    }

    /**
     * Can delete a task
     */
    public function test_delete_task()
    {
        Project::create([
            'id' => 1,
            'name' => 'Project nae', 
            'description' => 'Project description'
        ]);
        Task::create([
            'id' => 200,
            'name' => 'Task ndfame', 
            'priority' => 'high', 
            'schedule_date' => '2020-12-12 12:22:00',
            'project_id' => 200
        ]);
        $response = $this->delete('/task/200');
        $response->assertStatus(302);
    }
}
