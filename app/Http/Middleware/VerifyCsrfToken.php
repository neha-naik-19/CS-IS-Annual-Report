<?php

namespace App\Http\Controllers\Auth;
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */

    protected $except = [
        //
    ];

    public function handle($request, Closure $next)
    {
        if(!Auth::check() && $request->route()->named('logout')) {
        
            // $this->except[] = route('logout');
            return redirect()->guest('/CS-IS/login-expire');
        }
        
        return parent::handle($request, $next);
    }
    
}
