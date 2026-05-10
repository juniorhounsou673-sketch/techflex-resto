<?php 
 
namespace App\Http\Controllers\Admin; 
 
use App\Http\Controllers\Controller; 
use App\Models\Category; 
use Illuminate\Http\Request; 
use Illuminate\Support\Str; 
 
class CategoryController extends Controller 
{ 
    public function index() 
    { 
        $categories = Category::withCount('menuItems')->latest()->paginate(10); 
        return view('admin.categories.index', compact('categories')); 
    } 
 
    public function create() 
    { 
        return view('admin.categories.create'); 
    } 
 
    public function store(Request $request) 
    { 
        $data = $request->validate([ 
            'name'        => 'required|string|max:100', 
            'description' => 'nullable|string', 
            'is_active'   => 'boolean', 
        ]); 
 
        $data['slug'] = Str::slug($data['name']); 
 
        Category::create($data); 
        return redirect()->route('admin.categories.index') 
                         ->with('success', 'Catégorie créée !'); 
    } 
 
    public function edit(Category $category) 
    { 
        return view('admin.categories.edit', compact('category')); 
    } 
 
    public function update(Request $request, Category $category) 
    { 
        $data = $request->validate([ 
            'name'        => 'required|string|max:100', 
            'description' => 'nullable|string', 
            'is_active'   => 'boolean', 
        ]); 
 
        $data['slug'] = Str::slug($data['name']); 
        $data['is_active'] = $request->has('is_active'); 
 
        $category->update($data); 
        return redirect()->route('admin.categories.index') 
                         ->with('success', 'Catégorie mise à jour !'); 
    } 
 
    public function destroy(Category $category) 
    { 
        $category->delete(); 
        return redirect()->route('admin.categories.index') 
                         ->with('success', 'Catégorie supprimée.'); 
    } 
}