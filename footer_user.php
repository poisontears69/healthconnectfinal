
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>
    <script>
        document.getElementById("toggle-sidenav").addEventListener("click", function () {
            const sidenav = document.getElementById("sidenav");
            const toggleIcon = document.getElementById("toggle-icon");
            
            // Toggle hidden class
            sidenav.classList.toggle("hidden");
            
            // Update the button icon
            if (sidenav.classList.contains("hidden")) {
                toggleIcon.innerHTML = "&gt;";
            } else {
                toggleIcon.innerHTML = "&lt;";
            }
        });
    </script>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>