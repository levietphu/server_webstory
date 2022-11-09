<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    /**
     * Comment belongs to User_comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_comment()
    {
        // belongsTo(RelatedModel, foreignKey = user_comment_id, keyOnRelatedModel = id)
        return $this->belongsTo(User::class,'id_user','id');
    }
    /**
     * Comment belongs to Chidrent_comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function children_comment()
    {
        // belongsTo(RelatedModel, foreignKey = chidrent_comment_id, keyOnRelatedModel = id)
        return $this->hasMany(Comment::class,'id_parent','id');
    }
}
