<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\Middleware\Role as Middleware;
use Illuminate\Support\Facades\Auth;

class Role {

    // Check the users role and continue if the role is allowed to.
    public function handle($request, Closure $next, String $role) {
        if(!Auth::check())
            return redirect('/');

        $user = Auth::user();
        if($user->role == $role)
            return $next($request);
        else if($role == 'any')
            return $next($request);
        else if($user->role == 'admin' && $role == 'moderator')
            return $next($request);

        return redirect('/');
    }

}
