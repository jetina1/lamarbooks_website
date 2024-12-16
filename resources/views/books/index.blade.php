@include('body.head')
@include('body.header')
@include('body.sidebar')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="main-content">
    <h2>All Books</h2>
    <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>

    <div id="loading" style="display: none; text-align: center; padding: 20px;">Loading...</div>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if (count($books) > 0)
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book['title'] }}</td>
                        <td>{{ $book['author'] }}</td>
                        <td>${{ number_format($book['price'], 2) }}</td>
                        <td>
                            <a href="{{ route('books.edit', $book['id']) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('books.delete', $book['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align: center;">No books are available.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@include('body.footer')

<style>
    /* General Styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .main-content {
        padding-left: 350px;
        padding-right: 20px;
        padding-top: 130px;
        padding-bottom: 70px;
        min-height: calc(100vh - 60px);
        background-color: #fff;
    }

    .table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .table tr:hover {
        background-color: #f1f1f1;
    }

    .btn {
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin: 5px;
    }

    .btn-primary {
        background-color: #bcbe1d;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-warning {
        background-color: #ffc107;
        color: white;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    @media (max-width: 768px) {
        .main-content {
            padding-left: 0;
            padding-right: 0;
        }

        .table {
            font-size: 14px;
        }

        .btn {
            font-size: 14px;
            padding: 8px 15px;
        }
    }
</style>


<!-- <script>document.addEventListener("DOMContentLoaded", function () {
        const loadingIndicator = document.getElementById('loading');
        const tableBody = document.querySelector('.table tbody');
        const fetchBooksUrl = 'https://lalmarbooks.onrender.com/books/all';

        // Display the loading indicator
        loadingIndicator.style.display = 'block';

        // Fetch books data from the remote API
        fetch(fetchBooksUrl)
            .then(response => {
                // Hide the loading indicator
                loadingIndicator.style.display = 'none';

                if (response.status === 404) {
                    // Display "No books are available" directly on the screen
                    tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" style="text-align: center;">No books are available.</td>
                    </tr>`;
                    return null; // Stop further processing
                }

                if (!response.ok) {
                    throw new Error("Network response was not ok: " + response.statusText);
                }

                return response.json();
            })
            .then(data => {
                if (!data) return; // Exit if no data is returned (e.g., 404 case)

                // Check if the response contains books
                if (!Array.isArray(data) || data.length === 0) {
                    tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" style="text-align: center;">No books are available.</td>
                    </tr>`;
                    return;
                }

                // Populate the table with book data
                data.forEach(book => {
                    const row = `
                    <tr>
                        <td>${book.title}</td>
                        <td>${book.author}</td>
                        <td>$${parseFloat(book.price).toFixed(2)}</td>
                        <td>
                            <a href="/books/edit/${book.id}" class="btn btn-warning">Edit</a>
                            <form action="/books/${book.id}" method="POST" style="display:inline;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                <button type="submit" class="btn btn-danger delete-book">Delete</button>
                            </form>
                        </td>
                    </tr>`;
                    tableBody.innerHTML += row;
                });

                // Attach delete confirmation functionality to dynamically added delete buttons
                attachDeleteEventListeners();
            })
            .catch(error => {
                // Hide the loading indicator
                loadingIndicator.style.display = 'none';

                // Display an error message
                tableBody.innerHTML = `
                <tr>
                    <td colspan="4" style="text-align: center; color: red;">
                        Failed to load books: ${error.message}
                    </td>
                </tr>`;
            });

        // Function to handle delete confirmation for dynamically added delete buttons
        function attachDeleteEventListeners() {
            const deleteButtons = document.querySelectorAll('.delete-book');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault(); // Prevent form submission
                    const form = this.closest('form');
                    const confirmed = confirm("Are you sure you want to delete this book?");
                    if (confirmed) {
                        form.submit();
                    }
                });
            });
        }
    });
</script> -->