<!-- Footer Section -->
<div class="footer">
    <div class="footer-content">
        <!-- Left Section: Contact Us -->
        <div class="footer-contact">
            <p> &copy; 2024 Lamer Books. All rights reserved. <br>Contact Us: <a href="tel:+251 94 803 5055"
                    class="footer-phone">+251 94 803 5055</a></p>
        </div>

        <!-- Center Section: Copyright -->

    </div>
</div>
<style>
    /* Footer CSS */
    .footer {
        background-color: #1a1a1a;
        color: #d4af37;
        padding: 15px 20px;
        position: fixed;
        bottom: 0;
        left: 260px;
        /* Matches sidebar width */
        width: 100%;
        /* Full width minus sidebar width */
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1001;
        /* Higher than sidebar */
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
        /* Optional: add subtle shadow */
    }

    .footer-content {
        display: flex;
        width: 100%;
        max-width: 1200px;
        align-items: center;
        justify-content: space-between;
    }

    .footer-contact {
        /* display:; */
        align-items: center;
    }

    .footer-phone {
        color: #d4af37;
        text-decoration: none;
        margin-left: 10px;
        font-weight: bold;
        transition: color 0.3s;
    }

    .footer-phone:hover {
        color: #fff;
    }

    .footer-links {
        /* display: flex; */
        gap: 15px;
    }

    .footer-link {
        color: #d4af37;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s;
    }

    .footer-link:hover {
        color: #fff;
    }

    .footer p {
        margin: 0;
        font-size: 14px;
    }
</style>