@include('body.head')
@include('body.header') <!-- Include Header -->
@include('body.sidebar') <!-- Include Sidebar -->
<script src="https://unpkg.com/feather-icons"></script>

<div class="scrollable-content">
    <div class="main-content">
        <h2>Create a New Book</h2>

        <!-- Display errors -->
        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="https://lalmarbooks.onrender.com/books/create" method="POST" enctype="multipart/form-data"
            class="book-form">
            @csrf

            <div class="form-group">
                <label for="title">Book Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="form-control">
            </div>

            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" value="{{ old('author') }}" required class="form-control">
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" required
                    class="form-control">
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" required class="form-control">
                    <option value="1" {{ old('category') == 1 ? 'selected' : '' }}>Fiction</option>
                    <option value="2" {{ old('category') == 2 ? 'selected' : '' }}>Non-Fiction</option>
                    <option value="3" {{ old('category') == 3 ? 'selected' : '' }}>Science</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" required>{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="pdf">Upload PDF</label>
                <input type="file" name="pdf" id="pdf" accept="application/pdf" required class="form-control-file">
            </div>

            <div class="form-group">
                <label for="image">Upload Book Image</label>
                <input type="file" name="image" id="image" accept="image/jpeg, image/png" required
                    class="form-control-file">
            </div>

            <div class="button-container">
                <button type="submit" class="btn btn-primary">Create Book</button>
                <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to Book List</a>
            </div>
        </form>
    </div>
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
        background-color: #f9f9f9;
        color: #333;
        line-height: 1.6;
        overflow: hidden;
        /* Prevent double scrollbars */
    }

    /* Scrollable Content */
    .scrollable-content {
        position: fixed;
        top: 60px;
        /* Adjust for header height */
        left: 260px;
        /* Adjust for sidebar width */
        right: 0;
        bottom: 30;
        overflow-y: auto;
        padding: 20px;
        background-color: #f9f9f9;
    }

    /* Main Content Area */
    .main-content {
        max-width: 1200px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    h2 {
        font-size: 28px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
    }

    /* Error Messages */
    .error-list {
        margin-bottom: 20px;
        padding: 10px;
        background-color: #f8d7da;
        color: #721c24;
        border-radius: 5px;
        list-style: none;
    }

    .error-list li {
        margin-bottom: 5px;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 500;
        color: #555;
        margin-bottom: 8px;
        display: block;
    }

    .form-control,
    .form-control-file {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        color: #333;
    }

    .form-control:focus {
        border-color: #bcbe1d;
        box-shadow: 0 0 5px rgba(188, 190, 29, 0.4);
    }

    /* Button Styling */
    .btn {
        display: inline-block;
        padding: 12px 20px;
        font-size: 16px;
        font-weight: 600;
        text-align: center;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary {
        background-color: #bcbe1d;
        color: white;
    }

    .btn-primary:hover {
        background-color: #a8a819;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6368;
    }

    /* Button Container for Alignment */
    .button-container {
        display: flex;
        justify-content: flex-start;
        /* Align buttons to the left */
        gap: 10px;
        /* Add space between buttons */
        margin-top: 20px;
        /* Add some space above the buttons */
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .scrollable-content {
            top: 100px;
            /* Adjust for smaller header */
            left: 0;
            /* Remove left margin for smaller devices */
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
            padding: 10px 15px;
        }
    }
</style>