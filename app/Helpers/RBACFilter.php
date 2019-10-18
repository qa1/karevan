<?php

namespace App\Helpers;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use \RBAC;

class RBACFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
    	if (!isset($item['role']) && !isset($item['perm'])) {
    		return $item;
    	}

    	if (isset($item['role']) && isset($item['perm'])) {
    		if (RBAC::hasAnyRole($item['role']) || RBAC::hasAnyPerm($item['perm'])) {
    			return $item;
    		} else {
    			return false;
    		}
    	}

    	if (isset($item['perm'])) {
    		if (RBAC::hasAnyPerm($item['perm'])) {
    			return $item;
    		}
    	}

    	if (isset($item['role'])) {
    		if (RBAC::hasAnyRole($item['role'])) {
    			return $item;
    		}
    	}

    	return false;
    }
}
