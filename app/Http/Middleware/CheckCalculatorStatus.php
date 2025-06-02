<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Calculator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCalculatorStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        // Get the route name
        $routeName = $request->route()->getName();
        
        // Extract calculator slug from route name or parameters
        if (str_contains($routeName, '-calculator')) {
            $calculatorSlug = str_replace(['.calculate', '-calculator'], '', $routeName);
            
            // Find the calculator
            $calculator = Calculator::where('slug', $calculatorSlug)->first();
            
            // If calculator doesn't exist or is inactive, redirect
            if (!$calculator || $calculator->status !== 'active') {
                return redirect()->route('home')->with('error', 'This calculator is currently unavailable.');
            }
        }
        
        return $next($request);
    }
} 