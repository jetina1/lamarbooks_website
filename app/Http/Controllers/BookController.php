<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category; // Assuming you have a Category model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
// use Psy\Readline\Hoa\Console;
use Tymon\JWTAuth\Facades\JWTAuth;
use GuzzleHttp\Client; // Import Guzzle Client
use \Log;
// const apiUrl = 'https://lalmarbooks.onrender.com/books/all';

class BookController extends Controller
{
    // Display all books
    // Display all books
    public function index()
    {
        $remoteApiUrl = 'https://lalmarbooks.onrender.com/books/all';
        try {
            $response = file_get_contents($remoteApiUrl);
            $books = json_decode($response, true);
        } catch (\Exception $e) {
            $books = []; // Fallback in case of an error
            session()->flash('error', 'Failed to fetch books.');
        }

        return view('books.index', compact('books'));
    }

    public function create()
    {
        // Fetch categories dynamically from the backend API   http://192.168.37.23:3000/categories/all
        $response = Http::get('https://lalmarbooks.onrender.com/categories/all');
        $categories = $response->successful() ? $response->json() : [];

        // if ($response->successful()) {
        //     $categories = $response->json(); // Assuming the response is an array of categories
        // } else {
        //     $categories = []; // Handle cases where the API request fails
        // }

        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'description' => 'required|string',
            'pdf' => 'required|file|mimes:pdf|max:2048',
            'image' => 'required|file|mimes:jpeg,png|max:2048',
        ]);

        try {
            // Store PDF locally
            $pdf = $request->file('pdf');
            $pdfPath = $pdf->storeAs('uploads/pdf', time() . '_' . $pdf->getClientOriginalName(), 'public');

            // Store Image locally
            $image = $request->file('image');
            $imagePath = $image->storeAs('uploads/thumbnails', time() . '_' . $image->getClientOriginalName(), 'public');

            // Send post request to Node.js  http://192.168.37.23:3000/books/create
            $response = Http::post('https://lalmarbooks.onrender.com/books/create', [
                'title' => $request->title,
                'author' => $request->author,
                'price' => $request->price,
                'category_id' => $request->category_id, // Ensure category_id matches the expected input
                'description' => $request->description,
                'pdf_url' => Storage::url($pdfPath),
                'image_url' => Storage::url($imagePath),
            ]);

            if ($response->successful()) {
                return redirect()->route('books.index')->with('success', 'Book created successfully.');
            } else {
                return back()->withErrors(['error' => 'Failed to create book']);
            }
        } catch (\Exception $e) {
            // Handle exceptions such as file upload failure, HTTP request error, etc.
            return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    // Show form to edit an existing book
    public function edit($id)
    {
        $client = new Client();

        try {
            // Fetch categories from Node.js backend
            $categoryResponse = $client->get('https://lalmarbooks.onrender.com/categories/all');
            $categories = json_decode($categoryResponse->getBody()->getContents(), true);

            // Fetch specific book details from Node.js backend
            $bookResponse = $client->get('https://lalmarbooks.onrender.com/books/specific/' . $id);
            $book = json_decode($bookResponse->getBody()->getContents(), true);

        } catch (\Exception $e) {
            // Handle any errors while fetching data
            return redirect()->back()->withErrors(['error' => 'Failed to fetch data from backend: ' . $e->getMessage()]);
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
        try {
            // Find the book
            $book = Book::findOrFail($id);

            // Delete associated files
            if ($book->pdf_path) {
                Storage::delete($book->pdf_path);
            }
            if ($book->image_path) {
                Storage::delete($book->image_path);
            }

            // Delete the book
            $book->delete();

            // Return JSON success response
            return response()->json([
                'message' => 'Book deleted successfully!'
            ], 200);

        } catch (\Exception $e) {
            // Return JSON error response
            return response()->json([
                'error' => 'Failed to delete the book: ' . $e->getMessage()
            ], 500);
        }
    }

    // public function destroy($id)
    // {
    //     $book = Book::findOrFail($id);

    //     // Delete associated files
    //     Storage::delete($book->pdf_path);
    //     Storage::delete($book->image_path);

    //     // Delete the book
    //     $book->delete();

    //     return redirect()->route('books.index');
    // }
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
        $path = storage_path('app/public/uploads/pdf/' . $filename);

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
        $path = storage_path('app/public/uploads/thumbnails' . $filename); // Adjust as necessary

        // Check if the file exists
        if (!file_exists($path)) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        // Return the file as a response
        return response()->file($path);
    }
}



// Handle form submission and send data with files to backend API
// public function store(Request $request)
// {
//     // Step 1: Validate input data and files
//     $validated = $request->validate([
//         'title' => 'required|string|max:255',
//         'author' => 'required|string|max:255',
//         'price' => 'required|numeric|min:0',
//         'category' => 'required',
//         'description' => 'required|string',
//         'pdf' => 'required|file|mimes:pdf', // Max 10MB
//         'image' => 'required|file|mimes:jpeg,png|max:10240', // Max 10MB
//     ]);

//     // Step 2: Prepare the multipart form data
//     $formData = [
//         'title' => $validated['title'],
//         'author' => $validated['author'],
//         'price' => $validated['price'],
//         'category_id' => $validated['category'],
//         'description' => $validated['description'],
//     ];

//     // Step 3: Add files as multipart
//     if ($request->hasFile('pdf')) {
//         $formData['pdf'] = fopen($request->file('pdf')->getRealPath(), 'r');
//     }

//     if ($request->hasFile('image')) {
//         $formData['image'] = fopen($request->file('image')->getRealPath(), 'r');
//     }

//     // Step 4: Send a multipart POST request to the backend API with a timeout
//     $response = Http::timeout(100) // Set timeout to 60 seconds
//         ->attach('pdf', $request->file('pdf')->get(), $request->file('pdf')->getClientOriginalName())
//         ->attach('image', $request->file('image')->get(), $request->file('image')->getClientOriginalName())
//         ->post('https://lalmarbooks.onrender.com/books/create', $formData);

//     // Step 5: Handle the response
//     if ($response->successful()) {
//         return redirect()->route('books.index')->with('success', 'Book created successfully.');
//     } else {
//         // Log the response for debugging purposes
//         Log::error('Failed to create the book.', ['response' => $response->body()]);

//         return back()->withErrors(['error' => 'Failed to create the book. Please try again.']);
//     }
// }

// Show form to create a new book
// public function create(Request $request)
// {
//     // Validate the incoming request
//     $request->validate([
//         'title' => 'required|string|max:255',
//         'description' => 'nullable|string',
//         'price' => 'nullable|numeric',
//         'author' => 'nullable|string|max:255',
//         'pdf' => 'required|file|mimes:pdf|max:2048',
//         'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
//     ]);

//     // Handle the PDF upload
//     if ($request->hasFile('pdf')) {
//         $pdf = $request->file('pdf');
//         $pdfFilename = time() . '_' . $pdf->getClientOriginalName();
//         $pdfPath = $pdf->storeAs('uploads/pdf', $pdfFilename, 'public');
//         $pdfUrl = asset('storage/' . $pdfPath);
//     }

//     // Handle the image upload
//     if ($request->hasFile('image')) {
//         $image = $request->file('image');
//         $imageFilename = time() . '_' . $image->getClientOriginalName();
//         $imagePath = $image->storeAs('uploads/images', $imageFilename, 'public');
//         $imageUrl = asset('storage/' . $imagePath);
//     }

//     // Prepare the data to send to Node.js
//     $data = [
//         'title' => $request->input('title'),
//         'description' => $request->input('description'),
//         'price' => $request->input('price'),
//         'author' => $request->input('author'),
//         'pdf_url' => $pdfUrl,
//         'image_url' => $imageUrl,
//     ];

//     // Send data to Node.js server
//     $response = Http::post('http://your-nodejs-server-url/create-book', $data);

//     if ($response->successful()) {
//         return redirect()->route('books.index')->with('success', 'Book created successfully');
//     } else {
//         return back()->withErrors(['error' => 'Failed to create book']);
//     }
// }


/*<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    private $apiUrl = 'http://external-api-url.com/api/books';

    public function index()
    {
        try {
            $response = Http::get($this->apiUrl);
            $books = $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            $books = [];
            session()->flash('error', 'Failed to fetch books.');
        }

        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        try {
            $response = Http::post($this->apiUrl, $validated);

            if ($response->successful()) {
                return redirect()->route('books.index')->with('success', 'Book created successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to create book.')->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.')->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $response = Http::get("{$this->apiUrl}/{$id}");

            if ($response->successful()) {
                $book = $response->json();
                return view('books.edit', compact('book'));
            } else {
                return redirect()->route('books.index')->with('error', 'Failed to fetch book details.');
            }
        } catch (\Exception $e) {
            return redirect()->route('books.index')->with('error', 'An error occurred. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        try {
            $response = Http::put("{$this->apiUrl}/{$id}", $validated);

            if ($response->successful()) {
                return redirect()->route('books.index')->with('success', 'Book updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to update book.')->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $response = Http::delete("{$this->apiUrl}/{$id}");

            if ($response->successful()) {
                return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
            } else {
                return redirect()->route('books.index')->with('error', 'Failed to delete book.');
            }
        } catch (\Exception $e) {
            return redirect()->route('books.index')->with('error', 'An error occurred. Please try again.');
        }
    }
}
*/
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
/*

// Show form to create a new book
    public function create()
    {
        $categories = Category::all(); // Local categories
        return view('books.create', compact('categories'));
    }

    // Store a newly created book
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|integer',
            'description' => 'required|string|max:1255',
            'pdf' => 'required|mimes:pdf|max:51200', // Max 50MB
            'image' => 'required|mimes:jpeg,png,jpg|max:5120', // Max 5MB
        ]);

        $pdfPath = $request->file('pdf')->store('public/pdfs');
        $imagePath = $request->file('image')->store('public/images');

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'price' => $request->price,
            'category_id' => $request->category,
            'description' => $request->description,
            'pdf_path' => $pdfPath,
            'thumbnails' => $imagePath,
            'user_id' => 1, // Example static user
        ]);

        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    // Show form to edit a book
    public function edit($id)
    {
        $client = new Client();
        try {
            $categoryResponse = $client->get('https://lalmarbooks.onrender.com/categories/all');
            $categories = json_decode($categoryResponse->getBody()->getContents(), true);

            $bookResponse = $client->get('https://lalmarbooks.onrender.com/books/specific/' . $id);
            $book = json_decode($bookResponse->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return redirect()->route('books.index')->withErrors('Failed to load data.');
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

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'category' => 'nullable|integer',
            'pdf' => 'nullable|file|mimes:pdf',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        if ($request->filled('title')) $book->title = $request->input('title');
        if ($request->filled('author')) $book->author = $request->input('author');
        if ($request->filled('price')) $book->price = $request->input('price');
        if ($request->filled('category')) $book->category_id = $request->input('category');

        if ($request->hasFile('pdf')) {
            if ($book->pdf_path && Storage::exists($book->pdf_path)) Storage::delete($book->pdf_path);
            $book->pdf_path = $request->file('pdf')->store('public/pdfs');
        }

        if ($request->hasFile('image')) {
            if ($book->thumbnails && Storage::exists($book->thumbnails)) Storage::delete($book->thumbnails);
            $book->thumbnails = $request->file('image')->store('public/images');
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    // Delete a book
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        Storage::delete($book->pdf_path);
        Storage::delete($book->thumbnails);
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }*/