@include('body.head')
@include('body.header') <!-- Include Header -->
@include('body.sidebar') <!-- Include Sidebar -->

<div class="main-content">
    <h2>Edit Profile</h2>
    <p>Update your profile information below.</p>

    <!-- Profile Update Form -->
    <form id="profileForm">
        <!-- Name Field -->
        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <!-- Email Field -->
        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <!-- Password Field -->
        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" class="form-control"
                placeholder="Leave blank to keep current password">
        </div>

        <!-- Confirm Password Field -->
        <div class="form-group">
            <label for="password_confirmation">Confirm New Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>
</div>

@include('body.footer') <!-- Include Footer -->

<!-- Add JavaScript for JWT Authentication -->
<script>
    document.addEventListener('DOMContentLoaded', async function () {
        const token = localStorage.getItem('jwt_token');
        const apiUrl = 'http://your-api-url.com/api/user/profile'; // Update with your API URL

        if (!token) {
            alert('You are not authenticated!');
            window.location.href = '/login'; // Redirect to login
            return;
        }

        // Fetch user profile data from the server
        try {
            const response = await fetch(apiUrl, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
            });

            if (!response.ok) {
                alert('Failed to load profile data.');
                return;
            }

            const user = await response.json();

            // Populate form fields with user data
            document.getElementById('name').value = user.name || '';
            document.getElementById('email').value = user.email || '';
        } catch (error) {
            console.error('Error fetching user data:', error);
            alert('Error fetching profile data. Please try again later.');
        }

        // Handle form submission
        document.getElementById('profileForm').addEventListener('submit', async function (event) {
            event.preventDefault();

            const formData = new FormData(this);
            const updatedData = {
                name: formData.get('name'),
                email: formData.get('email'),
                password: formData.get('password') || null,
                password_confirmation: formData.get('password_confirmation') || null,
            };

            try {
                const updateResponse = await fetch(apiUrl, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(updatedData),
                });

                if (!updateResponse.ok) {
                    const errorData = await updateResponse.json();
                    alert(`Failed to update profile: ${errorData.message}`);
                    return;
                }

                alert('Profile updated successfully!');
            } catch (error) {
                console.error('Error updating profile:', error);
                alert('Error updating profile. Please try again later.');
            }
        });
    });
</script>

<!-- Style the Edit Profile Page -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .main-content {
        padding-left: 300px;
        padding-right: 20px;
        padding-top: 130px;
        padding-bottom: 20px;
        min-height: calc(100vh - 60px);
        background-color: #fff;
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
    }

    p {
        color: #666;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .form-control:focus {
        border-color: #bcbe1d;
        box-shadow: 0 0 5px rgba(188, 190, 29, 0.5);
    }

    .btn-primary {
        background-color: #bcbe1d;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #9fa513;
    }
</style>