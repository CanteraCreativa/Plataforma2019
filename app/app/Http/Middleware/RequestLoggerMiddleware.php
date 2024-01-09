<?php


namespace App\Http\Middleware;

use App\Models\LogEntry;
use Closure;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class RequestLoggerMiddleware
{

    public function handle($request, Closure $next)
    {
        if (!auth()->check())
            return $next($request);

        $logEntry = LogEntry::where('user_id', auth()->user()->id)->first();

        if(is_null($logEntry))
            $logEntry = new LogEntry();

        $logEntry->user_id = auth()->user()->id;

        $logEntry->save();
        $logEntry->touch();

        return $next($request);
    }
}
