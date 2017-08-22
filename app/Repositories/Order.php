<?php

namespace EverestBill\Repositories;

use Exception;
use EverestBill\Models\Order as OrderModel;

class Order
{
    public function __construct(OrderModel $order)
    {
        $this->order = $order;
    }

    /**
     * Save order to the database
     *
     * @param array $data
     */
    public function create($data)
    {
        $this->order->user_id       = $data['user_id'];
        $this->order->plan_id       = $data['plan_id'];
        $this->order->domain_id     = $data['domain_id'];
        $this->order->billing_cycle = $data['billing_cycle'];
        $this->order->status        = 'Pending';

        if (!$this->order->save()) {
            throw new Exception('Unable to save data to the database');
        }
    }
}