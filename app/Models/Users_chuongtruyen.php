<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_chuongtruyen extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function chuongs()
    {
        // belongsTo(RelatedModel, foreignKey = chapter_truyen_id, keyOnRelatedModel = id)
        return $this->belongsTo(Chuongtruyen::class,'id_chuong','id');
    }
    public function truyen_user()
    {
        // belongsTo(RelatedModel, foreignKey = chapter_truyen_id, keyOnRelatedModel = id)
        return $this->belongsTo(Truyen::class,'id_truyen','id');
    }
}
