<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
      public function index()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('categories.index', compact('categories'));
    }

    // Menampilkan form create
    public function create()
    {
        return view('categories.create');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Category::create([
            'title' => $request->title,
            'user_id' => Auth::id(), // kaitkan dengan user login
        ]);

        return redirect()->route('categories.index')->with('success', 'Category Created successfully.');
    }

    // Menampilkan detail (opsional)
    public function show(Category $category)
    {
        $this->authorizeUser($category);
        return view('categories.show', compact('category'));
    }

    // Form edit kategori
    public function edit(Category $category)
    {
        $this->authorizeUser($category);
        return view('categories.edit', compact('category'));
    }

    // Update kategori
    public function update(Request $request, Category $category)
    {
        $this->authorizeUser($category);

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $category->update([
            'title' => $request->title,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category Updated successfully.');
    }

    // Hapus kategori
    public function destroy(Category $category)
    {
        $this->authorizeUser($category);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    // Fungsi untuk memastikan kategori milik user login
    private function authorizeUser(Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
