<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Lamar Books</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Fantasy Bookstore Background */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #000, #333);
            color: #f8c12f;
            /* Golden text color */
            margin: 10px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header Styling */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 3rem;
            background-color: rgba(26, 26, 26, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .header .logo img {
            width: 120px;
        }

        .header nav a {
            color: #f8c12f;
            text-decoration: none;
            margin: 0 1.5rem;
            font-weight: bold;
            text-transform: uppercase;
            transition: color 0.3s;
        }

        .header nav a:hover {
            color: #ffd700;
        }

        /* Welcome Container Styling */
        .welcome-container {
            text-align: center;
            max-width: 700px;
            margin: auto;
            padding: 3rem 2rem;
            background: rgba(26, 26, 26, 0.9);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            color: #f8c12f;
            flex-grow: 1;
            margin-top: 100px;
            /* margin-bottom: 3rem; */
            margin-bottom: 4rem;
            /* Adjust gap between content and footer */
            /* Adjust this value to control the gap */
        }

        .welcome-container h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ffd700;
        }

        .welcome-container p {
            font-size: 1.3rem;
            color: #f0e68c;
            margin-bottom: 3rem;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            font-size: 1.2rem;
            font-weight: bold;
            color: #1a1a1a;
            background-color: #f8c12f;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: background 0.3s, transform 0.3s;
        }

        .btn:hover {
            background-color: #ffd700;
            transform: scale(1.05);
        }

        /* Footer Styling */
        .footer {
            background-color: rgba(26, 26, 26, 0.9);
            color: #f8c12f;
            padding: 2rem 1rem;
            /* Increased padding for more space */
            text-align: center;
            font-size: 1rem;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.3);
            padding-top: 2rem;
            /* Add space on top of the footer */
        }


        .footer a {
            color: #ffd700;
            text-decoration: none;
            margin: 0 0.5rem;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: #f8c12f;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <header class="header">
        <div class="logo">
            <img src="{{ asset('image/logo.png') }}" alt="Lamar Books Logo"> <!-- Ensure logo is in public/images -->
        </div>
        <nav>
            <!-- <a href="{{ route('books.index') }}">Books</a> -->
            <a href="{{ route('signin') }}">Sign In</a>
            <!--<a href="{{ route('signup') }}">Register</a>-->
        </nav>
    </header>

    <!-- Main Welcome Content -->
    <div class="welcome-container">
        <h1>Welcome to Lamar Books Admin Panel</h1>
        <p>Your gateway to a world of knowledge and imagination. Explore our vast collection of books, from classics to
            modern bestsellers.</p>
        <!-- <a href="{{ route('books.index') }}" class="btn">Browse Books</a> -->
        <a href="{{ route('signin') }}" class="btn">Sign In</a>
        <!--<a href="{{ route('signup') }}" class="btn">Register</a>-->
    </div>

    <!-- Footer Section -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} Lamar Books. All rights reserved.</p>
        <p>
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Service</a> |
            <a href="#">Contact Us</a>
        </p>
    </footer>
</body>

</html>