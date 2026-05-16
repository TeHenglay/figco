<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $fillable = [
        'project_id', 'name', 'figma_node_id', 'figma_url',
        'thumbnail_url', 'framework', 'generated_code', 'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function logs()
    {
        return $this->hasMany(GenerationLog::class);
    }
}
