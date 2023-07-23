<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;


     public function getPer()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'id_role', 'id_per');
    }
   
}
