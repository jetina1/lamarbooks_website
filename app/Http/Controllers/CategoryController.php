<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    protected $apiUrl = 'https://lalmarbooks.onrender.com/categories';

    // Display all categories
    public function index()
    {
        return view('categories.index');
    }

    // Show the form to create a new category
    public function create()
    {
        return view('categories.create');
    }

    // Show a specific category
    public function show($id)
    {
        // Fetch the category details from the Node.js backend
        $response = Http::get($this->apiUrl . '/' . $id);

        if ($response->successful()) {
            $category = $response->json();
            return view('categories.show', compact('category'));
        }

        return redirect()->route('categories.index')->withErrors(['error' => 'Category not found.']);
    }

    // Display the edit form for a specific category
    public function edit($id)
    {
        $response = Http::get($this->apiUrl . '/' . $id);

        if ($response->successful()) {
            $category = $response->json();
            return view('categories.edit', compact('category'));
        }

        return redirect()->route('categories.index')->withErrors(['error' => 'Category not found.']);
    }

    // Update a specific category
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $response = Http::put($this->apiUrl . '/' . $id, [
            'name' => $request->input('name'),
        ]);

        if ($response->successful()) {
            return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
        }

        return back()->withErrors(['error' => 'Failed to update category.']);
    }

    // Delete a specific category
    public function destroy($id)
    {
        $response = Http::delete($this->apiUrl . '/' . $id);

        if ($response->successful()) {
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
        }

        return redirect()->route('categories.index')->withErrors(['error' => 'Failed to delete category.']);
    }
}





// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Http;
// use App\Models\Category;
/*class CategoryController extends Controller
{  // Display all categories
    protected {
        $apiUrl = 'https://lalmarbooks.onrender.com/categories';

    }
    public function index()
    {
        return view('categories.index');
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


    public function edit($id)
    {

        // Fetch the category from the Node.js backend
        $response = Http::get($this->$apiUrl . '/' . $id);

        // Check if the request was successful
        if ($response->successful()) {
            $category = $response->json(); // Assuming the response is a JSON object
            return view('categories.edit', compact('category'));
        }

        // Handle the case where the category is not found
        return redirect()->route('categories.index')->withErrors(['error' => 'Category not found.']);
    }

    // Update the details of a specific category

    // Update the details of a specific category in the Node.js backend
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $response = Http::put($this->apiUrl . '/' . $id, [
            'name' => $request->input('name'),
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
        }

        return back()->withErrors(['error' => 'Failed to update category.']);
    }

    // public function update(Request $request, $id)
    // {
    //     // Validate the input data
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //     ]);

    //     $category = Category::findOrFail($id);  // Fetch the category by ID
    //     $category->update([
    //         'name' => $request->input('name'),
    //     ]);

    //     // Redirect to the category index with a success message
    //     return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    // }

    // Delete a category from the database
    public function destroy($id)
    {
        $category = Category::findOrFail($id);  // Fetch the category by ID
        $category->delete();  // Delete the category

        // Redirect to the category index with a success message
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}*/
/* // Store a new category in the Node.js backend
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $response = Http::post($this->apiUrl, [
            'name' => $request->input('name'),
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            return redirect()->route('categories.index')->with('success', 'Category created successfully!');
        }

        return back()->withErrors(['error' => 'Failed to create category.']);
    }

    // Display the details of a specific category
    public function show($id)
    {
        $response = Http::get($this->apiUrl . '/' . $id);
        $category = $response->json(); // Assuming the response is a JSON object

        return view('categories.show', compact('category'));
    }

    // Show the form to edit an existing category
    public function edit($id)
    {
        $response = Http::get($this->apiUrl . '/' . $id);
        $category = $response->json(); // Assuming the response is a JSON object

        return view('categories.edit', compact('category'));
    }

    // Update the details of a specific category in the Node.js backend
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $response = Http::put($this->apiUrl . '/' . $id, [
            'name' => $request->input('name'),
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
        }

        return back()->withErrors(['error' => 'Failed to update category.']);
    }

    // Delete a category from the Node.js backend
    public function destroy($id)
    {
        $response = Http::delete($this->apiUrl . '/' . $id);

        // Check if the request was successful
        if ($response->successful()) {
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
        }

        return back()->withErrors(['error' => 'Failed to delete category.']);
    }*/