<?php
namespace EverestBill\Repositories;

use Exception;
use EverestBill\Models\Plan as PlanModel;

class Plan
{
    public function __construct(PlanModel $plan)
    {
        $this->plan = $plan;
    }

    /**
     * Save plan to the database
     * 
     * @param  \Illuminate\Http\Request $request
     */
    public function save($request)
    {
        $this->plan->plan_name               = $request->plan_name;
        $this->plan->disk_space              = $request->disk_space;
        $this->plan->disk_unit               = $request->disk_unit;
        $this->plan->disk_unlimited          = isset($request->disk_unlimited) ? true : false;
        $this->plan->bandwidth               = $request->bandwidth;
        $this->plan->bandwidth_unit          = $request->bandwidth_unit;
        $this->plan->bandwidth_unlimited     = isset($request->bandwidth_unlimited) ? true : false;
        $this->plan->addon_domains           = $request->addon_domains;
        $this->plan->addon_domains_unlimited = isset($request->addon_domains_unlimited) ? true : false;

        if (!$this->plan->save()) {
            throw new Exception('Unable to save data to the database');
        }
    }

    /**
     * Get all the plans from the database
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->plan->all();
    }

    /**
     * Get plan using the given plan id
     *
     * @param integer $planId
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getById($planId)
    {
        return $this->plan->find($planId);
    }
}