<?php 
 
namespace App\Http\Controllers; 
 
use App\Models\MenuItem; 
use Illuminate\Http\Request; 
 
class CartController extends Controller 
{ 
    public function index() 
    { 
        $cart = session('cart', []); 
        $total = collect($cart)->sum(fn($item) => $item['price'] * 
$item['quantity']); 
        return view('cart.index', compact('cart', 'total')); 
    } 
 
    public function add(Request $request, MenuItem $menuItem) 
    { 
        $cart = session('cart', []); 
        $id   = $menuItem->id; 
 
        if (isset($cart[$id])) { 
            $cart[$id]['quantity']++; 
        } else { 
            $cart[$id] = [ 
                'name'     => $menuItem->name, 
                'price'    => $menuItem->price, 
                'quantity' => 1, 
                'image'    => $menuItem->image, 
            ]; 
        } 
 
        session(['cart' => $cart]); 
        return redirect()->back()->with('success', "{$menuItem->name} ajouté au 
panier !"); 
    } 
 
    public function update(Request $request, $id) 
    { 
        $cart = session('cart', []); 
 
        if (isset($cart[$id])) { 
            $qty = (int) $request->quantity; 
            if ($qty < 1) { 
                unset($cart[$id]); 
            } else { 
                $cart[$id]['quantity'] = $qty; 
            } 
        } 
 
        session(['cart' => $cart]); 
        return redirect()->route('cart.index'); 
    } 
 
    public function remove($id) 
    { 
        $cart = session('cart', []); 
        unset($cart[$id]); 
        session(['cart' => $cart]); 
        return redirect()->route('cart.index')->with('success', 'Article 
retiré.'); 
    } 
} 
