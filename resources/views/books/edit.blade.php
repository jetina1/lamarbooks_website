@include('body.head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="authorization-token" content="{{ session('token') }}">

@include('body.header') <!-- Include Header -->
@include('body.sidebar') <!-- Include Sidebar -->

<div class="main-content">
    <h2>Edit Book</h2>
    <!-- <form action="https://lalmarbooks.onrender.com/books/{{ $book['id'] ?? $book->id }}" method="POST" -->
    <!-- enctype="multipart/form-data"> -->

    <!-- <form action="{{ route('books.update', $book['id'] ?? $book->id) }}" method="POST" enctype="multipart/form-data"> -->
    <form action="https://lalmarbooks.onrender.com/books/{{ $book['id'] ?? $book->id }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Current Book Image</label>
            @if(!empty($book['thumbnails']) || !empty($book->thumbnails))
                <img src="https://lalmarbooks.onrender.com/books/thumbnails/{{ $book['thumbnails'] ?? $book->thumbnails }}"
                    alt="Book Image" class="current-image">
            @else
                <p class="no-image">No image available</p>
            @endif
        </div>

        <div class="form-group">
            <label for="title">Book Title</label>
            <input type="text" name="title" id="title" class="form-control"
                value="{{ old('title', $book['title'] ?? $book->title) }}" required>
        </div>

        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" name="author" id="author" class="form-control"
                value="{{ old('author', $book['author'] ?? $book->author) }}" required>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control"
                value="{{ old('price', $book['price'] ?? $book->price) }}" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select name="category" id="category" class="form-control" required>
                <option value="1" {{ ($book->category_id ?? 1) == 1 ? 'selected' : '' }}>Fiction</option>
                <option value="2" {{ ($book->category_id ?? 2) == 2 ? 'selected' : '' }}>Non-Fiction</option>
                <option value="3" {{ ($book->category_id ?? 3) == 3 ? 'selected' : '' }}>Science</option>
            </select>
        </div>

        <div class="form-group">
            <label for="isfree">Is Free</label>
            <select name="isfree" id="isfree" class="form-control" required>
                <option value="1" {{ (old('isfree', $book['isfree'] ?? $book->isfree) == 1) ? 'selected' : '' }}>Yes
                </option>
                <option value="0" {{ (old('isfree', $book['isfree'] ?? $book->isfree) == 0) ? 'selected' : '' }}>No
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="pdf">Upload PDF (if you want to update it)</label>
            <input type="file" name="pdf" id="pdf" class="form-control-file" accept="application/pdf">
        </div>

        <div class="form-group">
            <label for="image">Upload Book Image (if you want to update it)</label>
            <input type="file" name="image" id="image" class="form-control-file" accept="image/jpeg, image/png">
        </div>

        <button type="submit" class="btn btn-primary">Update Book</button>
    </form>
</div>

@include('body.footer') <!-- Include Footer -->

<style>
    /* General Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body & Background */
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f6f9;
        color: #333;
        line-height: 1.6;
    }

    /* Main Content */
    .main-content {
        max-width: 1000px;
        margin: 80px auto;
        background-color: #ffffff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-size: 28px;
        font-weight: 600;
        text-align: center;
        color: #333;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
        color: #555;
    }

    .form-control,
    .form-control-file,
    select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        color: #333;
    }

    .form-control:focus,
    select:focus {
        border-color: #007bff;
        box-shadow: 0 0 6px rgba(0, 123, 255, 0.5);
    }

    .current-image {
        max-width: 150px;
        border-radius: 8px;
        margin-top: 10px;
        border: 1px solid #ddd;
    }

    .no-image {
        font-size: 14px;
        color: #999;
        margin-top: 10px;
    }

    .btn {
        display: block;
        width: 100%;
        padding: 12px;
        font-size: 16px;
        font-weight: 600;
        text-align: center;
        color: #fff;
        background-color: #bcbe1d;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #a8a819;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .main-content {
            padding: 20px;
        }

        h2 {
            font-size: 24px;
        }

        .form-control,
        .form-control-file {
            font-size: 14px;
            padding: 10px;
        }

        .btn {
            font-size: 14px;
        }
    }
</style>

<script>
    document.querySelector('form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        const id = e.target.action.split('/').pop();

        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch(`https://lalmarbooks.onrender.com/books/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,  // Include CSRF token in headers
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`, // Add your Authorization header if needed
                },
                body: formData,
            });

            const result = await response.json();
            if (response.ok) {
                alert('Book updated successfully!');
            } else {
                alert(`Error: ${result.error}`);
            }
        } catch (error) {
            alert('Failed to update the book. Please try again later.');
        }
    });


</script>