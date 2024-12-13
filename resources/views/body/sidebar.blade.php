<aside>
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
                <img src="{{ asset('/image/lallogo1.png') }}" alt="Logo" class="sidebar-logo">
                ላል-<span>ማር</span>
            </a>
        </div>
        <div class="sidebar-body">
            <ul class="nav">
                <!-- Main Category -->
                <li class="nav-item nav-category">Main</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>

                <!-- Books Management Category -->
                <li class="nav-item nav-category">Books Management</li>
                <div class="collapse" id="books">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('books.index') }}" class="nav-link">All Books</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('books.create') }}" class="nav-link">Add Book</a>
                        </li>
                    </ul>
                </div>

                <!-- Category Management Category -->
                <li class="nav-item nav-category">Category Management</li>
                <div class="collapse" id="categories">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link">All Categories</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categories.create') }}" class="nav-link">Add Category</a>
                        </li>
                    </ul>
                </div>

                <!-- Account Management -->
                <!-- <li class="nav-item nav-category">Account Management</li>
                <li class="nav-item">
                    <a href="{{ route('profile') }}" class="nav-link">
                        <i class="link-icon" data-feather="user"></i>
                        <span class="link-title">Profile</span>
                    </a>
                </li> -->
                <!--<li class="nav-item">-->
                <!--    <a href="{{ route('logout') }}" class="nav-link">-->
                <!--        <i class="link-icon" data-feather="log-out"></i>-->
                <!--        <span class="link-title">Logout</span>-->
                <!--    </a>-->
                <!--</li>-->
            </ul>
        </div>
    </nav>
</aside>

<script>
    feather.replace(); // Initialize icons
</script>


<style>
    /* Sidebar General */
    .sidebar {
        width: 260px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #121212;
        color: #d4af37;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }

    .sidebar-header {
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid #333;
    }

    .sidebar-logo {
        width: 50px;
        height: 50px;
        margin-right: 10px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #d4af37;
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        font-size: 1.5rem;
        font-weight: bold;
        color: #d4af37;
        text-decoration: none;
    }

    .sidebar-body {
        flex-grow: 1;
        overflow-y: auto;
        padding: 10px;
    }

    .nav,
    .sub-menu {
        list-style: none;
        /* No bullets */
        padding: 0;
        margin: 0;
    }

    .nav-category {
        margin: 20px 15px 10px;
        color: #fff;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }

    .nav-link {
        padding: 12px 20px;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #d4af37;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .nav-link i {
        font-size: 1.2rem;
    }

    .nav-link:hover {
        background-color: #333;
        color: #fff;
        transform: scale(1.03);
    }

    .nav-link.active {
        background-color: #444;
        color: #fff;
    }

    .link-icon {
        margin-right: 12px;
    }

    .link-title {
        font-size: 1rem;
        font-weight: 500;
    }

    .sub-menu {
        margin-left: 20px;
        padding-left: 10px;
        border-left: 2px solid #444;
    }

    .sub-menu .nav-link {
        padding: 8px 15px;
        font-size: 0.9rem;
        color: #d4af37;
    }

    .sub-menu .nav-link:hover {
        background-color: #444;
    }

    .link-arrow {
        margin-left: auto;
        transition: transform 0.3s ease;
    }

    .nav-link[aria-expanded="true"] .link-arrow {
        transform: rotate(180deg);
    }
</style>



<!-- <script>
    feather.replace(); // Initialize icons
</script> -->