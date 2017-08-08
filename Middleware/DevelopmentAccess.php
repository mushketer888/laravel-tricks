<?php

namespace App\Http\Middleware;

use Closure;
use Config;

class DevelopmentAccess
{
    /**
     * Client IPs allowed to access the app.
     * Defaults are loopback IPv4 and IPv6 for use in local development.
     *
     * @var array
     */
    protected $ipWhitelist = ['127.0.0.1','::1'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (app()->environment() != 'production' && $this->clientNotAllowed()) {
            Config::set('app.debug', false);
            //Here you can log access if you want
            return abort(403, 'You are not authorized to access this');
        }

        return $next($request);
    }

    /**
     * Checks if current request client is allowed to access the app.
     *
     * @return boolean
     */
    protected function clientNotAllowed()
    {
        $isAllowedIP = in_array(request()->ip(), $this->ipWhitelist);

        return !$isAllowedIP ;
    }
}
