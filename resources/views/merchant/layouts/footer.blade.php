</div>
</div>
<script src="{{ url('admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ url('admin/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('admin/assets/js/sidebarmenu.js') }}"></script>
<script src="{{ url('admin/assets/js/app.min.js') }}"></script>
<script src="{{ url('admin/assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    // Custom script to toggle dropdown
    $(document).ready(function() {
        $('.dropdown-toggle').on('click', function() {
            $(this).next('.dropdown-menu').slideToggle();
        });
    });
</script>

</body>

</html>
