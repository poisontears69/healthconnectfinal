<!-- Main Content Area -->
<main class="container mt-4">

    <!-- Dynamic Content -->
    <div id="dynamic-content">
        <?php
        // Check if a 'page' query parameter is set and load the corresponding content
        if (isset($_GET['page'])) {
            $page = $_GET['page'];

            // Check for valid page to avoid direct access to arbitrary files
            if ($page == 'messages') {
                include('messages_user.php');
            } else if ($page == 'clinics') {
                include('clinics.php');
            } else if ($page == 'settings') {
                include('settings_user.php');
            } else {
                echo "<p>Page not found.</p>";
            }
        } else {
            // Default content when no page is specified
            echo "<p>Welcome to your dashboard. Choose an option from the sidebar.</p>";
        }
        ?>
    </div>
</main>