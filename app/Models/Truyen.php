<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Theloai;

class Truyen extends Model
{
    use HasFactory;

    public function truyen()
    {
        return $this->belongsToMany(Theloai::class, 'theloai_truyens', 'id_truyen', 'id_theloai');
    }
    /**
     * Truyen belongs to Tacgia.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tacgia()
    {
        // belongsTo(RelatedModel, foreignKey = tacgia_id, keyOnRelatedModel = id)
        return $this->belongsTo(Tacgia::class,'id_tacgia','id');
    }
    public function dichgia()
    {
        // belongsTo(RelatedModel, foreignKey = tacgia_id, keyOnRelatedModel = id)
        return $this->belongsTo(Translator::class,'id_trans','id');
    }
    /**
     * Truyen has many Chuong.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chuong()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = truyen_id, localKey = id)
        return $this->hasMany(Chuongtruyen::class,'id_truyen','id');
    }
    public function view()
    {
        return $this->belongsToMany(Visitor::class, 'views', 'id_truyen', 'id_visit');
    }

}
