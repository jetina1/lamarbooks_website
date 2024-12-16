@include('body.head')
@include('body.header') <!-- Include Header -->
@include('body.sidebar') <!-- Include Sidebar -->

<div class="main-content">
    <h1>Create Category</h1>
    <form id="createCategoryForm">
        @csrf
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Create Category</button>
    </form>
</div>

@include('body.footer') <!-- Include Footer -->

<script>
    // Handle the form submission
    document.getElementById('createCategoryForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        const categoryName = document.getElementById('name').value.trim(); // Get and trim input value

        // Check for empty input
        if (!categoryName) {
            alert('Category name cannot be empty.');
            return;
        }

        // Prepare the data to send
        const requestData = {
            name: categoryName
        };

        // Make a POST request to the backend
        fetch('https://lalmarbooks.onrender.com/categories/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}` // Include JWT token if needed
            },
            body: JSON.stringify(requestData)
        })
            .then(response => {
                // Handle both 200 OK and 201 Created statuses
                if (response.status === 200 || response.status === 201) {
                    return response.json();
                } else {
                    throw new Error('Failed to create category. Status: ' + response.status);
                }
            })
            .then(responseData => {
                // Check if the backend returned success
                if (responseData.success) {
                    alert('Category created successfully!');
                    window.location.href = '/categories'; // Redirect to categories page
                } else {
                    alert('Error: ' + responseData.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the category. Please try again later.');
            });
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