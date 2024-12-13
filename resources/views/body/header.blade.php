<!-- Header Section -->
<div class="header">
    <!-- Search Bar -->
    <div class="header-search">
        <input type="text" class="search-bar" placeholder="Search book by Author and Title...">
    </div>

    <!-- Profile and Logout Section -->
    <div class="header-actions">
        <div class="header-profile" onclick="openProfileModal()">
            <img id="profileImage" src="{{ asset('image/noprofile.jpeg') }}" alt="Profile" class="profile-image">
        </div>

        <!-- Logout Button -->
        <button class="logout-button" onclick="logout()">Logout</button>
    </div>
</div>

<!-- Profile Modal -->
<div id="profileModal" class="modal" style="display: none">
    <div class="modal-content">
        <form id="profileForm">
            <h2>Edit Profile</h2>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required placeholder="Name">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Email">

            <label for="profileImage">Profile Image:</label>
            <input type="file" name="profileImage" accept="image/*">

            <button type="submit">Save Changes</button>
        </form>
        <button type="button" onclick="closeProfileModal()">Cancel</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const token = localStorage.getItem("auth_token");

    // Fetch User Info and Populate Header
    async function fetchUserInfo() {
        if (!token) {
            window.location.href = '/signin';
            return;
        }

        try {
            const response = await axios.get('https://lalmarbooks.onrender.com/auth/user', {
                headers: { Authorization: `Bearer ${token}` },
            });
            const user = response.data.user;

            console.log('userrrrrrrrrrrrrrrr')
            console.log(user)
            // Update Header and Modal
            document.getElementById("name").value = user.name || '';
            document.getElementById("email").value = user.email || '';
            document.getElementById("profileImage").src = user.profileImage || '{{ asset("image/noprofile.jpeg") }}';

        } catch (error) {
            console.error('Error fetching user data:', error);
        }
    }

    // Logout
    function logout() {
        localStorage.removeItem("auth_token");
        window.location.href = '/signin';
    }

    // Profile Modal Controls
    function openProfileModal() {
        document.getElementById("profileModal").style.display = "block";
    }

    function closeProfileModal() {
        document.getElementById("profileModal").style.display = "none";
    }

    window.onload = fetchUserInfo;
</script>



<style>
    /* Header CSS */
    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
        background-color: #1a1a1a;
        color: #d4af37;
        position: fixed;
        top: 0;
        left: 250px;
        width: calc(100% - 250px);
        /* Full width minus sidebar */
        box-sizing: border-box;
        /* Include padding in width calculations */
    }


    /* Search Bar */
    .header-search {
        flex-grow: 1;
        /* Still allow it to grow */
        margin: 0 20px;
        /* Keep spacing */
        max-width: 60%;
        /* Limit maximum width */
    }


    .search-bar {
        width: 100%;
        padding: 8px;
        font-size: 14px;
        border: 1px solid #d4af37;
        border-radius: 4px;
        background-color: #fff;
        color: #000;
    }

    /* Profile and Logout Section */
    .header-actions {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-shrink: 0;
        /* Prevent shrinking of the container */
        margin-right: 10px;
        /* Ensure spacing from the right edge */
    }

    .header-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #d4af37;
        cursor: pointer;
    }

    .profile-image {
        width: 30px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #d4af37;
    }

    .profile-name {
        font-size: 16px;
    }

    /* Logout Button Styling */
    .logout-button {
        background-color: #d9534f;
        color: #fff;
        border: none;
        padding: 8px 12px;
        font-size: 14px;
        border-radius: 4px;

        cursor: pointer;
        transition: background-color 0.3s ease;
        white-space: nowrap;
        /* Prevent the button text from breaking into multiple lines */
    }

    .profile-button {
        background-color: #beacab;
        color: #fff;
        border: none;
        padding: 8px 12px;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        white-space: nowrap;
        /* Prevent the button text from breaking into multiple lines */
    }

    .logout-button:hover {
        background-color: #c9302c;
        /* Darker red on hover */
    }

    /* Modal positioned below the header */
    .modal {
        position: fixed;
        top: 60px;
        /* Adjust based on your header height */
        right: 10px;
        /* Align to the right corner of the header */
        background-color: rgba(0, 0, 0, 0.5);
        /* Semi-transparent background */
        z-index: 1000;
        /* Ensure it appears above all other elements */
        display: none;
        /* Hidden by default */
        justify-content: center;
        align-items: flex-start;
        /* Align to the top of the container */
        width: auto;
        /* Automatically fit content */
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: 300px;
        /* Optional: set a fixed width for the modal */
        max-width: 100%;
        /* Prevent overflow */
    }


    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: 300px;
        /* Optional: set a fixed width for the modal */
        max-width: 100%;
        /* Prevent overflow */
    }
</style>