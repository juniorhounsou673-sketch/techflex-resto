<?php 
 
namespace App\Http\Controllers\Admin; 
 
use App\Http\Controllers\Controller; 
use App\Models\MenuItem; 
use App\Models\Category; 
use Illuminate\Http\Request; 
use Illuminate\Support\Str; 
 
class MenuItemController extends Controller 
{ 
    public function index() 
    { 
        $items = MenuItem::with('category')->latest()->paginate(15); 
        return view('admin.menu_items.index', compact('items')); 
    } 
 
    public function create() 
    { 
        $categories = Category::where('is_active', true)->get(); 
        return view('admin.menu_items.create', compact('categories')); 
    } 
 
    public function store(Request $request) 
    { 
        $data = $request->validate([ 
            'category_id'  => 'required|exists:categories,id', 
            'name'         => 'required|string|max:150', 
            'description'  => 'nullable|string', 
            'price'        => 'required|numeric|min:0', 
            'image'        => 'nullable|image|max:2048', 
            'is_available' => 'boolean', 
            'is_featured'  => 'boolean', 
        ]); 
 
        $data['slug']         = Str::slug($data['name']); 
        $data['is_available'] = $request->has('is_available'); 
        $data['is_featured']  = $request->has('is_featured'); 
 
        if ($request->hasFile('image')) { 
            $data['image'] = $request->file('image')->store('menu', 'public'); 
        } 
 
        MenuItem::create($data); 
        return redirect()->route('admin.menu-items.index') 
                         ->with('success', 'Plat ajouté !'); 
    } 
 
    public function edit(MenuItem $menuItem) 
    { 
        $categories = Category::where('is_active', true)->get(); 
        return view('admin.menu_items.edit', compact('menuItem', 'categories')); 
    } 
 
    public function update(Request $request, MenuItem $menuItem) 
    { 
        $data = $request->validate([ 
            'category_id'  => 'required|exists:categories,id', 
            'name'         => 'required|string|max:150', 
            'description'  => 'nullable|string', 
            'price'        => 'required|numeric|min:0', 
            'image'        => 'nullable|image|max:2048', 
        ]); 
 
        $data['slug']         = Str::slug($data['name']); 
        $data['is_available'] = $request->has('is_available'); 
        $data['is_featured']  = $request->has('is_featured'); 
 
        if ($request->hasFile('image')) { 
            $data['image'] = $request->file('image')->store('menu', 'public'); 
        } 
 
        $menuItem->update($data); 
        return redirect()->route('admin.menu-items.index') 
                         ->with('success', 'Plat mis à jour !'); 
    } 
 
    public function destroy(MenuItem $menuItem) 
    { 
        $menuItem->delete(); 
        return redirect()->route('admin.menu-items.index') 
                         ->with('success', 'Plat supprimé.'); 
    } 
}