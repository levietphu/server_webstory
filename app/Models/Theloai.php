<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theloai extends Model
{
    use HasFactory;
    public function truyenss()
    {
        return $this->belongsToMany(Truyen::class, 'theloai_truyens', 'id_theloai', 'id_truyen');
    }
}
