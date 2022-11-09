<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chuongtruyen extends Model
{
    use HasFactory;
    /**
     * Chuongtruyen belongs to Chapter_truyen.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chapter_truyen()
    {
        // belongsTo(RelatedModel, foreignKey = chapter_truyen_id, keyOnRelatedModel = id)
        return $this->belongsTo(Truyen::class,'id_truyen','id');
    }
    /**
     * Query scope .
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query,$search_chapter)
    {
        if($search_chapter!='undefined'){
            return $query->where('name_chapter','like','%'.$search_chapter.'%');
        }
    }

     public function getChapterPersonal()
    {
        return $this->belongsToMany(User::class, 'users_chuongtruyens', 'id_chuong', 'id_user');
    }

}
