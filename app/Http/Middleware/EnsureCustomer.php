<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomer
{
    /**
     * Un compte administrateur ne peut pas utiliser le panier ni passer
     * commande. Il doit se connecter avec un compte client distinct.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            abort(403, 'Un compte administrateur ne peut pas passer de commande. Utilisez un compte client séparé.');
        }

        return $next($request);
    }
}
