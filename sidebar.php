<style>
    body {
    height: 100vh;
    overflow: hidden;
}

.sidebar {
    height: 100vh;
    width: 250px;
    position: fixed;
    background-color: #343a40;
    color: white;
    transition: all 0.3s ease;
}

.sidebar .nav-link {
    color: white;
}

.sidebar .nav-link:hover {
    background-color: #495057;
}

.content {
    margin-left: 250px;
    padding: 20px;
}
</style>
<div class="sidebar">
    <div class="py-4 text-center">
        <h3>Dashboard</h3>
    </div>
    <ul class="nav flex-column px-2">
        <li class="nav-item">
            <a class="nav-link" href="messages.php">
                <i class="bi bi-chat-dots me-2"></i> Messages
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="bookings.php">
                <i class="bi bi-calendar-check me-2"></i> Booking
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="clinics.php">
                <i class="bi bi-house-heart me-2"></i> Clinics
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="settings.php">
                <i class="bi bi-gear me-2"></i> Settings
            </a>
        </li>
    </ul>
</div>
