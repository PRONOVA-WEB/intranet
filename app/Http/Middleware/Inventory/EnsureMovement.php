<?php

namespace App\Http\Middleware\Inventory;

use App\Models\Inv\InventoryMovement;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureMovement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $movement = InventoryMovement::find($request->route('movement'));

        if($movement->responsibleUser->id == Auth::id())
            return $next($request);

        session()->flash('danger', 'Ud. no posee los permisos para ver los detalles del movimiento.');
        return redirect()->route('inventories.pending-movements');
    }
}
