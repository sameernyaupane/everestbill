<?php
namespace EverestBill\Decorators;

use Illuminate\Database\Eloquent\Collection;

class Plan
{
    public function decorate(Collection $plans)
    {
        return $plans->each(function ($item, $key) {
            if ($item->disk_unlimited === 0) {
                $item->diskSpaceWithUnit = $item->disk_space . ' ' . $item->disk_unit;
            } else {
                $item->diskSpaceWithUnit = 'Unlimited';
            }

            if ($item->disk_unlimited === 0) {
                $item->bandwidthWithUnit = $item->bandwidth . ' ' . $item->bandwidth_unit;
            } else {
                $item->bandwidthWithUnit = 'Unlimited';
            }

            if ($item->addon_domains_unlimited === 0) {
                $item->addonDomains = $item->addon_domains;
            } else {
                $item->addonDomains = 'Unlimited';
            }
        });
    }
}