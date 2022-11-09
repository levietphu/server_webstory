<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    public function views()
    {
        return $this->belongsToMany(Truyen::class, 'views', 'id_visit', 'id_truyen');
    }
}
