<?php namespace App\Http\Middleware;

use Closure;
use Response;
use Result;

class ChecklistOwner
{
    
    public function handle($request, Closure $next)
    {
		$response = Result::response();
        
        // $role = ChecklistRole::where('account_id', '=', $request['account_id'])
        //     ->where('checklist_id', '=', $request->id)
        //     ->first();

        // if ($role && $role->role === 1000) {
        //     return $next($request);
        // }

        return Response::json($response, 550, ['Content-Type' => 'application/javascript']);
    }
}