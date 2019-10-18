<?php

namespace App\Helpers;

use \Auth;

class Rbac
{
	/**
	 * Get authenticated user
	 */
	public function user()
	{
		return Auth::user();
	}

	/**
	 * Check if user has roles
	 */
	public function hasRole($roles)
	{
		return $this->user()->hasRole($roles);
	}

	/**
	 * Check if user has any of roles
	 */
	public function hasAnyRole($roles, $user = null)
	{
		$user = $user ?: \Auth::user();

		if (is_array($roles)) {
			foreach($roles as $item) {
				if($user->roles->where('name', $item)->first()) {
					return true;
				}
			}

			return false;
		}

		return $user->permissions->where('name', $roles)->first();
	}

	/**
	 * Check if user has permission
	 */
	public function hasPermission($name)
	{
		return $this->user()->hasPermissionTo($name);
	}

	/**
	 * Check if user has permission
	 */
	public function hasPerm($name)
	{
		return $this->hasPermission($name);
	}

	/**
	 * Check if user has any permissions
	 */
	public function hasAnyPerm($name, $user = null)
	{
		$user = $user ?: \Auth::user();

		if (is_array($name)) {
			foreach($name as $item) {
				if($user->permissions->where('name', $item)->first()) {
					return true;
				}
			}

			return false;
		}

		return $user->permissions->where('name', $name)->first();
	}
}