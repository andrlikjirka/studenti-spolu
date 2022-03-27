<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'description',
        'e-mail',
        'login',
        'password',
    ];

    protected $visible = [
        'id_user',
        'first_name',
        'last_name',
        'id_right',
        'id_status',
    ];

    protected $attributes = [
        'id_right' => 3,
        'id_status' => 1,
    ];
}
