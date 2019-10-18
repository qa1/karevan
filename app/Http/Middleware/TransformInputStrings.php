<?php

namespace App\Http\Middleware;

use Closure;

class TransformInputStrings
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
        $input = $request->all();

        array_walk_recursive($input, function ($val, $key) use (&$input) {
            $input[$key] = replacePersianDigistWithEnglish($val);
        });

        // Masked Input
        // array_walk_recursive($input, function($val, $key) use(&$input){
        //     if (in_array($key, ['kart'])) {
        //         $input[$key] = preg_replace("/-/", "", $val);
        //     }
        // });

        $request->replace($input);

        return $next($request);
    }
}
