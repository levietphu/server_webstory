<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donate extends Model
{
    use HasFactory;
    /**
     * Donate belongs to GetUserDonate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getUserDonate()
    {
        // belongsTo(RelatedModel, foreignKey = getUserDonate_id, keyOnRelatedModel = id)
        return $this->belongsTo(User::class,"user_donate","id");
    }
    public function getDonnor()
    {
        return $this->belongsTo(User::class,"donnor","id");
    }

   /**
    * Donate has one GetStory.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function getStory()
   {
       // hasOne(RelatedModel, foreignKeyOnRelatedModel = donate_id, localKey = id)
       return $this->belongsTo(Truyen::class,"id_truyen","id");
   }
}
