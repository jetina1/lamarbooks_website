<!DOCTYPE html>
<html lang="en">

@include('body.head')

<!-- Feather Icons -->
<script src="https://unpkg.com/feather-icons"></script>
<script>
    // Feather Icons initialization
    window.onload = function () {
        if (typeof feather !== 'undefined') {
            feather.replace();
        } else {
            console.error('Feather Icons library failed to load.');
        }
    };
</script>

<body>
    <div class="main-wrapper">
        <!-- Sidebar -->
        @include('body.sidebar')

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Header -->
            @include('body.header')

            <!-- Notifications -->
            <div id="notifications" class="notifications"></div>

            <!-- Main Content -->
            <div class="main-content">
                <h1>Welcome back to Admin Panel</h1>
                <h1 id="userName">Welcome, Guest!</h1>
                <p>Your email: <span id="userEmail">N/A</span></p>
                <p>Your role: <span id="userRole">N/A</span></p>
                <p class="profile-name">Guest</p>
                <img id="profileImage" src="/path/to/default/image.png" alt="Profile Image" />
            </div>
        </div>
    </div>

    @include('body.footer')
</body>

<!-- Axios for API Requests -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Function to display user data in the dashboard
    async function displayDashboardData() {
        try {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                console.error('Token not found');
                return;
            }

            const response = await fetch('https://lalmarbooks.onrender.com/auth/user', {
                method: 'GET',
                headers: { Authorization: `Bearer ${token}` },
            });

            if (response.ok) {
                // Parse user data from the response
                const user = await response.json();

                // Update the UI with user data
                document.getElementById("userName").textContent = `Welcome, ${user.name}!`;
                document.getElementById("userEmail").textContent = user.email || 'N/A';
                document.getElementById("userRole").textContent = user.role || 'N/A';
                document.querySelector('.profile-name').innerText = user.name || 'Guest';

                // Set default profile image
                document.getElementById('profileImage').src = '/path/to/default/image.png'; // Replace with actual logic
            } else {
                console.error('Error fetching user data:', response.statusText);
            }
        } catch (error) {
            console.error('Error fetching user data:', error);
        }
    }

    // On window load, fetch and display user data
    window.onload = function () {
        const token = localStorage.getItem('auth_token');
        console.log('Token:', token);

        // Redirect to login page if no token is found
        if (!token) {
            window.location.href = '/signin';
            return;
        }

        // Display user data
        displayDashboardData();
    };
</script>

<style>
    /* General Styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Main Content Area */
    .main-content {
        padding-left: 300px;
        padding-right: 20px;
        padding-top: 200px;
        padding-bottom: 20px;
        min-height: calc(100vh - 60px);
        background-color: #fff;
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
        font-weight: bold;
    }

    .table tr:hover {
        background-color: #f1f1f1;
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

    /* Responsive Styles */
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

</html>