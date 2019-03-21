<?php

namespace App\Http\Middleware;

use Closure;

class LogMiddleware
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
         //127.0.0.1 在 190315
        //获取用户来访的ip
       //var_dump( $_SERVER);
       $ip = $request->ip();
       $date = date("Y-m-d H:i:s");
       $url = $request->url();
       $str = $ip."在".$date."访问了".$url."\n\r";
       $filename = public_path().'/logs/'.date("ymd").".txt";
       file_put_contents($filename,$str,FILE_APPEND);
       if(session("userInfo")==""){
           return redirect("login");
        }else{
            return $next($request);
        }
    }
}
