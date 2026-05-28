<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CategoryFormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('can:viewAny,App\Models\Category', only: ['index', 'show']),
            new Middleware('can:create,App\Models\Category', only: ['create', 'store']),
            new Middleware('can:update,App\Models\Category', only: ['edit', 'update']),
            new Middleware('can:delete,App\Models\Category', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of categories (public)
     */
    public function index(): View
    {
        $categories = Category::withCount('tshirtImages')
            ->orderBy('name')
            ->get();
        
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category (admin only)
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category (admin only)
     */
    public function store(CategoryFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        
        $category = new Category();
        $category->name = $validatedData['name'];
        
        // Handle image upload
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('categories', $filename, 'public');
            $category->image_url = $filename;
        }
        
        $category->save();
        
        return redirect()->route('admin.categories.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Category {$category->name} has been created successfully!");
    }

    /**
     * Display the specified category (public)
     */
    public function show(Category $category): View
    {
        $category->load('tshirtImages');
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing a category (admin only)
     */
    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category (admin only)
     */
    public function update(CategoryFormRequest $request, Category $category): RedirectResponse
    {
        $validatedData = $request->validated();
        
        $category->name = $validatedData['name'];
        
        // Handle image upload
        if ($request->hasFile('image_file')) {
            // Delete old image
            if ($category->image_url) {
                Storage::disk('public')->delete('categories/' . $category->image_url);
            }
            
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('categories', $filename, 'public');
            $category->image_url = $filename;
        }
        
        $category->save();
        
        return redirect()->route('admin.categories.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Category {$category->name} has been updated successfully!");
    }

    /**
     * Remove the specified category (admin only)
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            // Delete associated image
            if ($category->image_url) {
                Storage::disk('public')->delete('categories/' . $category->image_url);
            }
            
            $category->delete();
            
            return redirect()->route('admin.categories.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', "Category {$category->name} has been deleted successfully!");
        } catch (\Exception $error) {
            return redirect()->back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Cannot delete category because it has associated t-shirt images!");
        }
    }
}