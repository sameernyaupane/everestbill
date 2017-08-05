<?php
namespace EverestBill\Decorators;

class Plan
{
    public function decorateAll($plans)
    {
        return $plans->each(function ($item, $key) {
            $this->decorate($item);
        });
    }

    public function decorate($item)
    {
        if ($item->disk_unlimited === 0) {
            $item->diskSpaceWithUnit = $item->disk_space . ' ' . $item->disk_unit;
        } else {
            $item->diskSpaceWithUnit = 'Unlimited';
        }

        if ($item->bandwidth_unlimited === 0) {
            $item->bandwidthWithUnit = $item->bandwidth . ' ' . $item->bandwidth_unit;
        } else {
            $item->bandwidthWithUnit = 'Unlimited';
        }

        if ($item->addon_domains_unlimited === 0) {
            $item->addonDomains = $item->addon_domains;
        } else {
            $item->addonDomains = 'Unlimited';
        }

        return $item;
    }
}