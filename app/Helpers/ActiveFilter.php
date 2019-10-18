<?php

namespace App\Helpers;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use \Nav;

class ActiveFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
        if (isset($item['activateVia'])) {
            foreach ($item['activateVia'] as $activeRule) {
                if (Nav::is($activeRule, true, false)) {
                    $item['active'] = true;
                    return $item;
                }
            }
        }

        if (isset($item['regex'])) {
            $item['active'] = Nav::regex($item['regex'], true, false);
            return $item;
        }

        if (isset($item['route'])) {
            $item['active'] = Nav::is($item['route'], true, false);
            return $item;
        }

        $item['active'] = false;
        return $item;
    }
}
