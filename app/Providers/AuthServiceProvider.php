<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
//use  App\Models\Hamahang\Menus\Menus;
//use App\Policies\MenusPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Hamahang\Menus\Menus' => 'App\Policies\MenuPolicy',
        'App\Models\Hamahang\Tools\Tools' => 'App\Policies\ToolPolicy',
        'App\Models\Hamahang\Tools\ToolsGroup' => 'ToolsGroupPolicy',
        'App\Models\Hamahang\Tools\Tools' => 'ToolsPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
