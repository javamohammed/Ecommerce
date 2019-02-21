<?php

namespace App\Http\Middleware;

use Closure;

class Mintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(setting()->status == 'close'){
            return redirect('mintenance');
        }else{
            return $next($request);
        }
        
    }
}
