<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsMedecin
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()?->role !== 'medecin') {
            return response()->json(['message' => 'Accès réservé au médecin'], 403);
        }
        return $next($request);
    }
}