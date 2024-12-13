<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category; // Assuming you have a Category model
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use GuzzleHttp\Client; // Import Guzzle Client

use Log;
class BookController extends Controller
{
    // Display all books
    public function index()
    {
        // Fetch books directly from the database
        $books = Book::all();
        //??????????????????????????? from the backend
        return view('books.index', compact('books'));
    }

    // Show form to create a new book
    public function create()
    {
        // Get categories for the form
        // ftch all category from the backend
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    // Store a newly created book
    public function store(Request $request)
    {
        // $user = JWTAuth::parseToken()->authenticate();

        $validated = $request->validate([

            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|integer',
            'description' => 'required|string|max:1255',
            'pdf' => 'required|mimes:pdf|max:51200',  // 50MB max PDF file
            'image' => 'required|mimes:jpeg,png,jpg,j|max:5120', // 5MB max image file
        ]);

        // Handle file uploads for PDF and Image
        $pdfPath = $request->file('pdf')->store('public/pdfs');
        $thumbnails = $request->file('image')->store('public/thumbnails');

        // Create the book
        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'price' => $request->price,
            'category_id' => $request->category,
            'description' => $request->description,
            'pdf_path' => $pdfPath,
            'thumbnails' => $thumbnails,
            'user_id' => 1, // Set the authenticated user's ID
        ]);


        return redirect()->route('books.index');
    }

    // Show form to edit an existing book
    public function edit($id)
    {
        $client = new Client();
        // $book = Book::findOrFail($id);
        // $categories = Category::all(); // Get categories for the form
        // Fetch categories from Node.js backend
        try {
            $categoryresponse = $client->get('https://lalmarbooks.onrender.com/categories/all'); // Replace with your Node.js URL
            $categories = json_decode($categoryresponse->getBody()->getContents(), true); // Decode the JSON response
            $bookresponse = $client->get('https://lalmarbooks.onrender.com/books/specific/' . $id); // Replace with your Node.js URL
            $book = json_decode($bookresponse->getBody()->getContents(), true); // Decode the JSON response
        } catch (\Exception $e) {
            $categories = []; // If there is an error, set an empty array
            // Optionally, handle the error (log it or display a message)
        }
        return view('books.edit', compact('book', 'categories'));
    }

    // Update an existing book
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }
        // Validate the data
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'category' => 'nullable|integer',
            'pdf' => 'nullable|file|mimes:pdf', // Optional PDF file
            'image' => 'nullable|image|mimes:jpeg,png,jpg' // Optional image file
        ]);

        // Update the book's data with available input
        if ($request->filled('title')) {
            $book->title = $request->input('title');
        }
        if ($request->filled('author')) {
            $book->author = $request->input('author');
        }
        if ($request->filled('price')) {
            $book->price = $request->input('price');
        }
        if ($request->filled('category')) {
            $book->category_id = $request->input('category');
        }

        // Handle PDF file upload
        if ($request->hasFile('pdf')) {
            // Delete old PDF if it exists
            if ($book->pdf_path && Storage::exists($book->pdf_path)) {
                Storage::delete($book->pdf_path);
            }

            // Store new PDF and update path
            $book->pdf_path = $request->file('pdf')->store('public/pdfs');
        }

        // Handle image file upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($book->thumbnails && Storage::exists($book->thumbnails)) {
                Storage::delete($book->thumbnails);
            }

            // Store new image and update path
            $book->thumbnails = $request->file('image')->store('public/images');
        }

        // Save the updated book
        $book->save();

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }


    // Delete a book
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Delete associated files
        Storage::delete($book->pdf_path);
        Storage::delete($book->image_path);

        // Delete the book
        $book->delete();

        return redirect()->route('books.index');
    }
    /**
     * Return the book image file.
     */
    public function getBookThumbnail($filename)
    {
        $path = storage_path('app/public/thumbnails/' . $filename);

        if (file_exists($path)) {
            return response()->file($path);
        } else {
            abort(404);
        }
    }


    /**
     * Return the book PDF file.
     */
    public function getBookPdf($filename)
    {
        $path = storage_path('app/public/pdfs/' . $filename);

        if (file_exists($path)) {
            return response()->file($path);
        } else {
            abort(404);
        }
    }

    /**
     * Return the book image file.
     */
    public function getImage($filename)
    {
        // Construct the path to the image in storage
        $path = storage_path('app/public/images/' . $filename); // Adjust as necessary

        // Check if the file exists
        if (!file_exists($path)) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        // Return the file as a response
        return response()->file($path);
    }
}
// Update an existing book
// public function update(Request $request, $id)
// {
//     $validated = $request->validate([
//         'title' => 'required|string|max:255',
//         'author' => 'required|string|max:255',
//         'price' => 'required|numeric',
//         'category' => 'required|integer',
//     ]);

//     $response = Http::put(env('BASE_URI') . "/books/{$id}", [
//         'title' => $request->title,
//         'author' => $request->author,
//         'price' => $request->price,
//         'category' => $request->category,
//     ]);

//     return redirect()->route('books.index');
// }
// use Illuminate\Support\Facades\Http;
// public function getBookPdf($filename)
// {
//     $path = storage_path('app/public/books/pdf/' . $filename); // Adjust the path as necessary

//     if (file_exists($path)) {
//         return response()->file($path);
//     }

//     return response()->json(['error' => 'PDF not found'], 404);
// }
// public function getBookImage($filename)
// {
//     $path = storage_path('app/public/books/' . $filename); // Adjust the path as necessary

//     if (file_exists($path)) {
//         return response()->file($path);
//     }

//     return response()->json(['error' => 'Image not found'], 404);
// }