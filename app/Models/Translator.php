<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translator extends Model
{
    use HasFactory;
    /**
     * Tacgia has many Tacgia_truyen.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dichgia_truyen()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = tacgia_id, localKey = id)
        return $this->hasMany(Truyen::class,'id_trans','id');
    }
}
