<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Uzivatel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'uzivatel';
    protected $primaryKey = 'id_uzivatel';
    public $timestamps = false;

    protected $fillable = [
        'jmeno',
        'prijmeni',
        'popis',
        'e-mail',
        'login',
        'heslo',
    ];

    protected $attributes = [
        'id_pravo' => 3, //student
        'id_stav' => 1, //aktivni
    ];

    protected $hidden = [
        'heslo',
    ];

}
