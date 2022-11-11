<?php

namespace App;

use Amorim\Tenant\TenantModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use \Illuminate\Notifications\Notifiable;
    use TenantModel;

    protected $connection = 'main';

    protected $fillable = [
        'name', 'email', 'password', 'image', 'mobile', 'empresa_id', 'nivel',
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
    ];

    protected $showable = [
        ['name' => 'id', 'title' => 'Id', 'datatable' => 'true', 'form' => 'false', 'type' => 'id', 'size' => '4'],
        ['name' => 'name', 'title' => 'Nome', 'datatable' => 'true', 'form' => 'true', 'type' => 'text', 'size' => '4'],
        ['name' => 'email', 'title' => 'Email', 'datatable' => 'true', 'form' => 'true', 'type' => 'text', 'size' => '4'],
        ['name' => 'mobile', 'title' => 'Celular', 'datatable' => 'true', 'form' => 'true', 'type' => 'text', 'size' => '4'],
        ['name' => 'empresa_id', 'title' => 'Empresa', 'datatable' => 'true', 'form' => 'true', 'type' => 'fk', 'size' => '8',
            'options' => [
                'model' => 'empresa', 'value' => 'id', 'label' => 'nome', ],
        ],
        ['name' => 'nivel', 'title' => 'Nível', 'datatable' => 'true', 'form' => 'true', 'type' => 'number', 'size' => '3', 'step' => '1.'],

        ['name' => 'image', 'title' => 'Foto', 'datatable' => 'false', 'form' => 'true', 'type' => 'image', 'size' => '8'],
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function empresa()
    {
        return $this->belongsTo('Amorim\Tenant\Models\Empresa');
    }

    public function getImage()
    {
        if (!empty($this->image)) {
            if (file_exists(public_path().'/img/users/'.$this->image)) {
                return '/img/users/'.$this->image;
            }
        }

        return '/img/0000-sem-foto.jpg';
    }
}
