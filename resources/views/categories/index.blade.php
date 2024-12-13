@include('body.head')
@include('body.header')  <!-- Include Header -->
@include('body.sidebar') <!-- Include Sidebar -->

<div class="main-content">
    <h1>Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Create New Category</a>

    <!-- Check if categories are available -->
    <div id="categoriesContainer">
        <p>Loading categories...</p>
    </div>
</div>

@include('body.footer') <!-- Include Footer -->

<script>
    // Fetch categories from the Node.js backend
    fetch('https://lalmarbooks.onrender.com/categories/all')  // Replace with your backend URL
        .then(response => response.json())
        .then(categories => {
            const categoriesContainer = document.getElementById('categoriesContainer');

            if (categories.length === 0) {
                categoriesContainer.innerHTML = '<p>No categories found.</p>';
            } else {
                let tableHTML = `
                    <table class="table mt-4">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                categories.forEach(category => {
                    tableHTML += `
                        <tr>
                            <td>${category.id}</td>
                            <td>${category.name}</td>
                            <td>
                                <a href="{{ route('categories.show', '') }}/${category.id}" class="btn btn-info">View</a>
                                <a href="{{ route('categories.edit', '') }}/${category.id}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('categories.destroy', '') }}/${category.id}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    `;
                });

                tableHTML += `
                        </tbody>
                    </table>
                `;

                categoriesContainer.innerHTML = tableHTML;
            }
        })
        .catch(error => {
            const categoriesContainer = document.getElementById('categoriesContainer');
            categoriesContainer.innerHTML = `<p>Error fetching categories: ${error}</p>`;
        });
</script>


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
        padding-left: 300px;
        /* Adjust to your sidebar width */
        padding-right: 20px;
        /* Right padding to avoid content touching the edge */
        padding-top: 130px;
        /* Top padding for better spacing */
        padding-bottom: 20px;
        /* Bottom padding to avoid content touching footer */
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
        /* Increased padding for better readability */
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #f2f2f2;
        /* Light gray background for table headers */
        font-weight: bold;
    }

    .table tr:hover {
        background-color: #f1f1f1;
        /* Highlight row on hover */
    }

    /* Button Styles */
    .btn {
        padding: 10px 20px;
        /* More padding for buttons */
        font-size: 16px;
        /* Slightly larger text */
        border: none;
        border-radius: 5px;
        /* Rounded corners */
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin: 5px;
        /* Add some margin between buttons */
    }

    .btn-primary {
        background-color: #bcbe1d;
        /* Blue background */
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        /* Darker blue on hover */
    }

    .btn-info {
        background-color: #17a2b8;
        /* Info button (light blue) */
        color: white;
    }

    .btn-info:hover {
        background-color: #117a8b;
        /* Darker blue on hover */
    }

    .btn-warning {
        background-color: #ffc107;
        /* Yellow background */
        color: white;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        /* Darker yellow on hover */
    }

    .btn-danger {
        background-color: #dc3545;
        /* Red background */
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
        /* Darker red on hover */
    }

    /* Empty Categories Message */
    .no-categories {
        font-size: 18px;
        color: #888;
        /* Gray text color */
        margin-top: 20px;
        text-align: center;
    }

    /* Sidebar and Header adjustment for a full layout */
    body {
        display: flex;
        flex-direction: column;
    }

    /* header {
        background-color: #343a40;
        Dark background for header
        color: white;
        padding: 15px 20px;
        text-align: center;
    } */

    /* .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        Sidebar width
        height: 100%;
        background-color: #343a40;
        Dark sidebar
        color: white;
        padding-top: 50px;
        Give space for the header
    } */

    /* .sidebar a {
        color: white;
        text-decoration: none;
        padding: 15px;
        display: block;
        transition: background-color 0.3s ease;
    }

    .sidebar a:hover {
        background-color: #575757;
        Hover effect for sidebar links
    }

    */
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

        /* .sidebar {
            width: 200px;
            Slightly narrower sidebar
        } */

        /* .no-categories {
            font-size: 16px;
        } */
    }
</style>