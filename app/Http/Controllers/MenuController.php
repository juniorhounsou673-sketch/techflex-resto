<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->with(['menuItems' => function($q) {
                $q->where('is_available', true);
            }])
            ->get();

        $featured = MenuItem::where('is_featured', true)
            ->where('is_available', true)
            ->with('category')
            ->take(6)
            ->get();

        return view('menu.index', compact('categories', 'featured'));
    }

    public function show(MenuItem $menuItem)
    {
        return view('menu.show', compact('menuItem'));
    }
}