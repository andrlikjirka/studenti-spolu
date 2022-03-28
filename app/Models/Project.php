<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';
    protected $primaryKey = 'id_project';
    public $timestamps = false;

    protected $fillable = [
        'id_project',
        'name',
        'description',
        'create_date',
    ];

    protected $attributes = [
        'id_status' => 1,
    ];

}
