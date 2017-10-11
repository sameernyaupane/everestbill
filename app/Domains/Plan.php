<?php

namespace EverestBill\Domains;

use EverestBill\Decorators\Plan as PlanDecorator;
use EverestBill\Repositories\Plan as PlanRepository;

class Plan
{
    /**
     * PlanDecorator instance
     * 
     * @var PlanDecorator
     */
    public $planDecorator;

    /**
     * PlanRepository instance
     * 
     * @var PlanRepository
     */
    public $planRepository;

    /**
     * Plan constructor
     * 
     * @param PlanDecorator $planDecorator
     * @param PlanRepository $planRepository
     */
    public function __construct(
        PlanDecorator $planDecorator, 
        PlanRepository $planRepository
    )
    {
        $this->planDecorator  = $planDecorator;
        $this->planRepository = $planRepository;
    }

    /**
     * Save plan to the database
     * 
     * @param  \Illuminate\Http\Request $request
     */
    public function store($request)
    {
        $this->planRepository->save($request);
    }

    /**
     * Get all the plans from the database
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        $plans = $this->planRepository->getAll();

        return $this->planDecorator->decorateAll($plans);
    }

    /**
     * Get a plan by id from the database
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getById($planId)
    {
        $plan = $this->planRepository->getById($planId);

        return $this->planDecorator->decorate($plan);
    }
}