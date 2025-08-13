<?php

namespace App\Providers;

//use Illuminate\Support\ServiceProvider;
use App\Models\Models\Institute;
 use App\Models\Models\Circle;
use App\Models\Models\Employee;
use App\Policies\CirclePolicy;
use App\Policies\EmployeePolicy;
use App\Policies\InstitutePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies = [
        Institute::class => InstitutePolicy::class,
        Employee::class  => EmployeePolicy::class,
        Circle::class    => CirclePolicy::class,
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
            $this->registerPolicies();
    }
}
