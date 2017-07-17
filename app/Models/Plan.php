<?php
namespace EverestBill\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /**
     * Get the pricing information associated with the plan.
     */
    public function pricing()
    {
        return $this->hasOne(Pricing::class, 'plan_id', 'id');
    }
}