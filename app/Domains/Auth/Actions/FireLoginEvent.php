<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Events\Login;

class FireLoginEvent
{
    public function handle($request, $next)
    {
        if ($request->user()) {
            event(new Login($request->user()));
        }

        return $next($request);
    }
}
