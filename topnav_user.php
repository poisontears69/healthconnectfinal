<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        
        <!-- Profile Dropdown with Settings Icon -->
        <div class="dropdown ms-auto">
            <button class="btn btn-light border-0" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <!-- Settings Icon with Down Arrow -->
                <i class="fas fa-cogs"></i>
                <i class="fas fa-chevron-down ms-2"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="index_user.php?page=settings">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Include FontAwesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
