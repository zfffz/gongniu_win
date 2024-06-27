<?php

namespace App\Http\Middleware;

use Closure;

class AdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // $route = $request->path();

    public function handle($request, Closure $next)
    {
  //       dd(session('user'));
  //      if (!session('manage_users')) {
  //   return redirect('login');
  // }
  return $next($request);

    }
}
