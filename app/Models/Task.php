<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'project_id', 'priority', 'schedule_date', 'position', 'executed_date', 'created_at', 'updated_at'];

    protected $date = ['schedule_date', 'executed_date'];

    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id');
    }
}
