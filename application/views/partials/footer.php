</div><!-- /container-fluid -->

<footer class="footer mt-auto py-3 bg-light border-top">
  <div class="container text-center">
    <span class="text-muted small">
        &copy; <?= date('Y'); ?> JobTracker. All rights reserved. Developed by <i class="fas fa-heart text-danger"></i> <strong>Ahmad Husain</strong>.
    </span>
  </div>
</footer>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<!-- Custom JS -->
<script src="<?= base_url('assets/js/app.js') ?>"></script>
<script>
  // Pass CI base_url to JS
  var BASE_URL = '<?= base_url() ?>';
</script>
</body>
</html>