<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Category;

class CategoryController extends Controller
{  // Display all categories
    public function index()
    {
        $categories = Category::all();  // Fetch all categories from the database
        \Log::debug('Categories: ', $categories->toArray());
        return view('categories.index', compact('categories'));
    }

    // Show the form to create a new category
    public function create()
    {
        return view('categories.create');
    }

    // Store a new category in the database
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new category
        Category::create([
            'name' => $request->input('name'),
        ]);

        // Redirect to the category index with a success message
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    // Display the details of a specific category
    public function show($id)
    {
        $category = Category::findOrFail($id);  // Fetch the category by ID
        return view('categories.show', compact('category'));
    }

    // Show the form to edit an existing category
    public function edit($id)
    {
        $category = Category::findOrFail($id);  // Fetch the category by ID
        return view('categories.edit', compact('category'));
    }

    // Update the details of a specific category
    public function update(Request $request, $id)
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);  // Fetch the category by ID
        $category->update([
            'name' => $request->input('name'),
        ]);

        // Redirect to the category index with a success message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    // Delete a category from the database
    public function destroy($id)
    {
        $category = Category::findOrFail($id);  // Fetch the category by ID
        $category->delete();  // Delete the category

        // Redirect to the category index with a success message
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
