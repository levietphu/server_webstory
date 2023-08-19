<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankInfo extends Model
{
    use HasFactory;
    /**
     * BankInfo has many GetLoadCent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getLoadCent()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = bankInfo_id, localKey = id)
        return $this->hasMany(LoadCent::class,'id_bankinfo',"id");
    }
}
