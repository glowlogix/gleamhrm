<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Employee;

class AllowedPermission {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next) {
        $getUrl = \Route::currentRouteAction();
        $getUrl = str_replace("@", ":", $getUrl);
        $getUrl = str_replace("App\Http\Controllers\\", "", $getUrl);

        if (
            Auth::user()->hasRole('admin') ||
            $request->is('documents/index') ||
            $request->is('documents/index') ||
            $request->is('employee/profile') ||
            // strstr($getUrl, 'organization_hierarchy') ||
            $request->is('organization_hierarchy') ||
            $request->is('leaves/*') 
        ) // If user has this permission
        {
            return $next($request);
        }

        if (!Auth::user()->hasPermissionTo($getUrl)){
            abort('401');
        } 
        else {
            return $next($request);
        }

        return $next($request);
    }

    function permiss(){
        Auth::user()->hasRole('admin');
    }
    
    public function handle_old($request, Closure $next) {
        if (
            Auth::user()->hasPermissionTo('admin') ||
            $request->is('documents/*') ||
            $request->is('posts/*/edit') ||
            $request->is('posts/*/edit') ||
            $request->is('posts/*/edit') ||
            $request->is('posts/*/edit')
        ) //If user has this //permission
        {
            return $next($request);
        }

        if ($request->is('posts/create'))//If user is creating a post
        {
            if (!Auth::user()->hasPermissionTo('Create Post'))
            {
                abort('401');
            } 
         else {
                return $next($request);
            }
        }

        if ($request->is('posts/*/edit')) //If user is editing a post
        {
            if (!Auth::user()->hasPermissionTo('Edit Post')) {
                abort('401');
            } else {
                return $next($request);
            }
        }

        if ($request->isMethod('Delete')) //If user is deleting a post
        {
            if (!Auth::user()->hasPermissionTo('Delete Post')) {
                abort('401');
            } 
            else{
                return $next($request);
            }
        }

        return $next($request);
    }
}