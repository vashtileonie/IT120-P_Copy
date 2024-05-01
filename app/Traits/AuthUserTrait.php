<?php

namespace App\Traits;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;

trait AuthUserTrait
{
    /**
     * If User is Super Admin
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return in_array(Role::SUPER_ADMIN, $this->userRoles());
    }

    /**
     * If User is Dealer Admin
     *
     * @return bool
     */
    public function isDealerAdmin()
    {
        return in_array(Role::DEALER_ADMIN, $this->userRoles());
    }

    /**
     * If User is Dealer Admin
     *
     * @return bool
     */
    public function isDistributorAdmin()
    {
        return in_array(Role::DISTRIBUTOR_ADMIN, $this->userRoles());
    }

    /**
     * Returns User's Roles
     *
     * @param string $field
     * @return array
     */
    private function userRoles(string $field = 'name')
    {
        if (Auth::check()) {
            return Auth::user()
                    ->roles
                    ->pluck($field)
                    ->toArray();
        }

        return [];
    }

    /**
     * Returns Providers for the User that is a Dealer
     */
    public function userDealerProviders()
    {
        return Auth::user()
                ?->user_dealer
                ?->dealer_providers;
    }

    /**
     * Returns Distributors for the User that is a Dealer
     */
    public function userDealerDistributors()
    {
        return Auth::user()
                ?->user_dealer
                ?->dealer_distributors;
    }

    /**
     * Returns Dealers for the User that is a Distributor
     */
    public function userDistributorDealers()
    {
        return Auth::user()
                ?->user_distributor
                ?->distributor_dealers;
    }

    /**
     * Returns the Retailers for the User that is a Distributor
     */
    public function userDistributorRetailers()
    {
        return Auth::user()
                ?->user_distributor
                ?->distributor_retailers;
    }
}
