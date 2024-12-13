<style>
    /* Global Styles */
    */ body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #222222;
        color: #fff;
        display: flex;
    }

    /* Main Container */
    .main-container {
        display: flex;
        flex: 1;
        overflow: hidden;
    }


    /* Sidebar */
    aside {
        width: 250px;
        background-color: #333;
        color: gold;
        padding: 20px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
    }

    /* Content Container */
    .content-container {
        margin-left: 250px;
        flex: 1;
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow-y: auto;
        padding: 20px;
    }

    /* Header */
    .header {
        position: fixed;
        top: 0;
        left: 250px;
        width: calc(100% - 250px);
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #1a1a1a;
        color: #d4af37;
        z-index: 1000;
        padding: 0 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Footer */
    .footer {
        background-color: #1a1a1a;
        color: #d4af37;
        padding: 15px 20px;
        text-align: center;
        width: calc(100% - 250px);
        position: fixed;
        bottom: 0;
        left: 250px;
    }

    /* Container */
    .container {
        margin-top: 80px;
        /* Account for header height */
        margin-bottom: 80px;
        /* Account for footer height */
        background-color: #1e1e1e;
        padding: 20px;
        border-radius: 15px;
    }

    /* h2 {
        color: gold;
        margin-bottom: 20px;
    } */

    form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }

    form div {
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 8px;
    }

    input,
    select {
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #444;
        background-color: #333;
        color: #fff;
    }

    button {
        background-color: #d4af37;
        color: #000;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #f1c40f;
    }

    /* Responsive Layout */
    @media screen and (max-width: 768px) {
        aside {
            width: 200px;
        }

        .content-container {
            margin-left: 200px;
        }

        .header {
            left: 200px;
            width: calc(100% - 200px);
        }

        .footer {
            left: 200px;
            width: calc(100% - 200px);
        }
    }

    @media screen and (max-width: 576px) {
        aside {
            display: none;
        }

        .content-container {
            margin-left: 0;
        }

        .header {
            left: 0;
            width: 100%;
        }

        .footer {
            left: 0;
            width: 100%;
        }
    }

    /* Modal */
    .modal-content {
        padding: 20px;
        background-color: #333;
        color: #fff;
        border-radius: 10px;
    }

    .modal input[type="file"] {
        background-color: #444;
    }

    button[type="button"] {
        background-color: #e74c3c;
        color: white;
        padding: 10px;
        border-radius: 5px;
        border: none;
    }

    /* Table */
    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .modal-content {
        padding: 20px;
        background-color: #333;
        color: #fff;
        border-radius: 10px;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #444;
    }

    html,
    body {
        margin: 0;
        padding: 0;
        overflow: hidden;
        /* Prevent body from scrolling */
        height: 100%;
        /* Ensure full viewport height */
    }

    th {
        background-color: #333;
        color: gold;
    }

    tr:nth-child(even) {
        background-color: #333;
    }

    tr:hover {
        background-color: #444;
    }
</style>

<!-- <style>
    /* Global Styles */
/* body {
margin: 0;
padding: 0;
font-family: 'Arial', sans-serif;
background-color: #222222;
color: #fff;
display: flex;
flex-direction: column;
height: 100vh;
}

    /* Main Layout */
    .main-container {
        display: flex;
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }

    .content-container {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
    }

    /* Sidebar */
    aside {
        width: 250px;
        background-color: #333;
        color: gold;
        padding: 20px;
        height: 100vh;
        box-sizing: border-box;
        position: fixed;
        top: 0;
        left: 0;
    }

    .sidebar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .sidebar-logo {
        width: 40px;
        height: 40px;
        object-fit: cover;
        margin-right: 10px;
    }

    .sidebar-brand {
        font-size: 1.5rem;
        font-weight: bold;
        color: #d4af37;
        text-transform: uppercase;
    }

    .nav {
        list-style: none;
        padding: 0;
    }

    .nav-item {
        margin-bottom: 15px;
    }

    .nav-link {
        color: gold;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        transition: background-color 0.3s ease;
    }

    .nav-link:hover {
        background-color: #444;
        color: #fff;
    }

    .nav-item .nav-category {
        font-size: 1.1rem;
        font-weight: bold;
        margin-top: 20px;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    /* Header */
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
        height: 60px;
        z-index: 1050;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .header-search input {
        padding: 8px;
        border-radius: 5px;
        border: none;
        background-color: #333;
        color: gold;
        width: 300px;
    }

    .header-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #d4af37;
        cursor: pointer;
    }

    .profile-image {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #d4af37;
    }

    .profile-name {
        font-size: 16px;
    }

    /* Content */
    .container {
        max-width: 900px;
        padding: 30px;
        background-color: #1e1e1e;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

   

    /* Sidebar Submenu */
    .collapse {
        margin-left: 20px;
        background-color: #1a1a1a;
        border-radius: 5px;
    }

    .sub-menu .nav-item {
        padding-left: 20px;
    }

    .sub-menu .nav-link {
        font-size: 0.9rem;
    }

    .link-arrow {
        margin-left: auto;
        color: #d4af37;
    }

    /* Modal */
    .modal-content {
        padding: 20px;
        background-color: #333;
        color: #fff;
        border-radius: 10px;
    }

    .modal input[type="file"] {
        background-color: #444;
    }

    button[type="button"] {
        background-color: #e74c3c;
        color: white;
        padding: 10px;
        border-radius: 5px;
        border: none;
    }

    /* Table */
    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #444;
    }

    th {
        background-color: #333;
        color: gold;
    }

    tr:nth-child(even) {
        background-color: #333;
    }

    tr:hover {
        background-color: #444;
    }

    /* Scrollbar */
    .sidebar-body::-webkit-scrollbar {
        width: 8px;
    }

    .sidebar-body::-webkit-scrollbar-thumb {
        background-color: #d4af37;
        border-radius: 5px;
    }

    .sidebar-body::-webkit-scrollbar-track {
        background-color: #000;
    }

    /* Miscellaneous */
    .sidebar-toggler {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
    }

    .sidebar-toggler span {
        width: 25px;
        height: 3px;
        background-color: #d4af37;
        margin: 2px 0;
    }

    .sidebar-toggler.not-active {
        transform: rotate(90deg);
    }
</style> -->