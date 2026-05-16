<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenerationLog extends Model
{
    protected $fillable = ['component_id', 'n8n_execution_id', 'status', 'error_message', 'duration_ms'];

    public function component()
    {
        return $this->belongsTo(Component::class);
    }
}
