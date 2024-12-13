@include('body.head') <!-- Include Head -->
@include('body.header') <!-- Include Header -->
@include('body.sidebar') <!-- Include Sidebar -->
<meta name="csrf-token" content="{{ csrf_token() }}">


<div class="main-content">
    <h2>All Books</h2>
    <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>

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
            @foreach ($books as $book)
                <tr data-book-id="{{ $book->id }}">
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->price }}</td>
                    <td>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">Edit</a>
                        <button class="btn btn-danger" onclick="deleteBook('{{ $book->id }}')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('body.footer') <!-- Include Footer -->

<style>
    /* General Styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        /* Light gray background */
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Main Content Area */
    .main-content {
        padding-left: 350px;
        /* Adjust for sidebar */
        padding-right: 20px;
        /* Prevent content touching edge */
        padding-top: 130px;
        /* Adjust top padding for header */
        padding-bottom: 70px;
        /* Avoid content touching footer */
        min-height: calc(100vh - 60px);
        /* Ensure content fills screen minus header */
        background-color: #fff;
        /* White background for content */
    }

    /* Table Styles */
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
        /* Light gray header */
        font-weight: bold;
    }

    .table tr:hover {
        background-color: #f1f1f1;
        /* Highlight row on hover */
    }

    /* Button Styles */
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

    /* Responsive Styles */
    @media (max-width: 768px) {
        .main-content {
            padding-left: 0;
            padding-right: 0;
        }

        .table {
            font-size: 14px;
            /* Adjust table font size for smaller screens */
        }

        .btn {
            font-size: 14px;
            /* Smaller buttons on mobile */
            padding: 8px 15px;
        }
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch('https://lalmarbooks.onrender.com/books/all')  // Replace with actual URL of your Node.js API
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('.table tbody');
                tableBody.innerHTML = ''; // Clear existing rows

                // Loop through the data and append it to the table
                data.forEach(book => {
                    const row = document.createElement('tr');

                    const titleCell = document.createElement('td');
                    titleCell.textContent = book.title;
                    row.appendChild(titleCell);

                    const authorCell = document.createElement('td');
                    authorCell.textContent = book.author;
                    row.appendChild(authorCell);

                    const priceCell = document.createElement('td');
                    priceCell.textContent = book.price;
                    row.appendChild(priceCell);

                    const actionsCell = document.createElement('td');
                    actionsCell.innerHTML = `
                    <a href="/books/${book.id}/edit" class="btn btn-warning">Edit</a>
                    <form action="/books/${book.id}/delete" method="POST" style="display:inline;">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                `;
                    row.appendChild(actionsCell);

                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching books:', error);
            });
    });
</script>
<script>
    // Function to delete the book
    function deleteBook(bookId) {
        if (confirm('Are you sure?')) {
            const token = localStorage.getItem('auth_token');  // Get the token from localStorage

            fetch(`https://lalmarbooks.onrender.com/books/${bookId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,  // Include Authorization header with token
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // CSRF Token
                    'Content-Type': 'application/json'   // Set the content type to JSON
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Book deleted successfully!');
                        // Optionally, you can remove the book row from the table
                        const row = document.querySelector(`tr[data-book-id="${bookId}"]`);
                        row.remove();
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error deleting book:', error);
                    alert('An error occurred while deleting the book.');
                });
        }
    }
</script>