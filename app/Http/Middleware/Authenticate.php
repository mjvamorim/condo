<?php

namespace App\Http\Middleware;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;

class Authenticate extends Middleware
{
    protected $rotas_consulta=['consulta','crud/getdata','home','login','logout'];
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
    public function handle($request, Closure $next, ...$guards) {
        if (auth()->check() && auth()->user()->nivel < 3 ) {
            if ( !in_array(\Route::currentRouteName(),$this->rotas_consulta) ) {
                return redirect()->route('consulta');
            }
        }
        return $next($request);
    }
}
