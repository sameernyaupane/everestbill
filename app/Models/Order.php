<?php

namespace EverestBill\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Get the plan associated with the order.
     */
    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }
}