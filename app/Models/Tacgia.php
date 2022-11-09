<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tacgia extends Model
{
    use HasFactory;
    /**
     * Tacgia has many Tacgia_truyen.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tacgia_truyen()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = tacgia_id, localKey = id)
        return $this->hasMany(Truyen::class,'id_tacgia','id');
    }
}
