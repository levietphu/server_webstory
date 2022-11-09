<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    /**
     * Review belongs to Review_user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function review_user()
    {
        // belongsTo(RelatedModel, foreignKey = review_user_id, keyOnRelatedModel = id)
        return $this->hasMany(User::class,'id_user','id');
    }
}
