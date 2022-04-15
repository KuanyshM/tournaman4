<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('comment-delete', function($user, $comment){
            return $user->id == $comment->user_id;
        });

        Gate::define('organization-create', function(){
            $user = auth()->user();
            if($user->organization==null || $user->can('settings-list')){
                return true;
            }else{
                return false;
            }
        });
/*        Gate::define('user-edit', function($id){
            return (auth()->user()->can("settings-list")
                || $id==auth()->user()->id);
        });*/



        //
    }
}
