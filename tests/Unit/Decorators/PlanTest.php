<?php

namespace Tests\Unit\Decorators;

use EverestBill\Decorators\Plan;
use Illuminate\Support\Collection;

class PlanTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $this->plan = new Plan();
    }

    public function test_decorate_WhenCalled_ReturnDecoratedCollection()
    {
        $plans = new Collection([
            (object)[
                'id'                      => 1,
                'plan_name'               => 'Starter',
                'disk_space'              => 10,
                'disk_unit'               => 'GB',
                'disk_unlimited'          => 0,
                'bandwidth'               => 100,
                'bandwidth_unit'          => 'GB',
                'bandwidth_unlimited'     => 0,
                'addon_domains'           => 1,
                'addon_domains_unlimited' => 0,
            ],
            (object)[
                'id'                      => 2,
                'plan_name'               => 'Medium',
                'disk_space'              => 20,
                'disk_unit'               => 'GB',
                'disk_unlimited'          => 1,
                'bandwidth'               => 200,
                'bandwidth_unit'          => 'GB',
                'bandwidth_unlimited'     => 1,
                'addon_domains'           => 1,
                'addon_domains_unlimited' => 1,
            ]
        ]);

        $decoratedPlans = $this->plan->decorate($plans);

        $decoratedPlans->each(function ($item, $key) {
            $this->assertObjectHasAttribute('diskSpaceWithUnit', $item);
            $this->assertObjectHasAttribute('bandwidthWithUnit', $item);
            $this->assertObjectHasAttribute('addonDomains', $item);

            if ($item->id === 1) {
                $this->assertNotEquals('Unlimited', $item->diskSpaceWithUnit);
                $this->assertNotEquals('Unlimited', $item->bandwidthWithUnit);
                $this->assertNotEquals('Unlimited', $item->addonDomains);
            } elseif ($item->id === 2) {
                $this->assertEquals('Unlimited', $item->diskSpaceWithUnit);
                $this->assertEquals('Unlimited', $item->bandwidthWithUnit);
                $this->assertEquals('Unlimited', $item->addonDomains);
            }
        });
    }
}