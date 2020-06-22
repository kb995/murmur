
    <footer class="footer py-5 mt-5 text-center bg-light">
    copyright
    </footer>
</body>

<script>
    $(".delete_btn").on('click', function() {
        alert($(this).data('id'));
        const post_id = $(this).data('id');
        window.location.href = "./index.php?action=delete&post_id=" + post_id;
      });
</script>
</html>