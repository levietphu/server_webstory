<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransitionHistory extends Model
{
    use HasFactory;
    /**
     * TransitionHistory has one Get_bank_info.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function get_bank_info()
    {
        // hasOne(RelatedModel, foreignKeyOnRelatedModel = transitionHistory_id, localKey = id)
        return $this->hasOne(BankInfo::class,"id","id_bankinfo");
    }

    /**
     * TransitionHistory has one GetUser.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getUser()
    {
        // hasOne(RelatedModel, foreignKeyOnRelatedModel = transitionHistory_id, localKey = id)
        return $this->hasOne(User::class,"id","id_user");
    }
}
