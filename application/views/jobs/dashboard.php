<div class="row mb-4">
  <div class="col-12">
    <h4 class="font-weight-bold">
      <i class="fas fa-tachometer-alt text-primary mr-2"></i>
      Welcome back, <?= $this->session->userdata('user_name') ?>!
    </h4>
    <p class="text-muted">Here's a snapshot of your job search activity.</p>
  </div>
</div>

<!-- Follow-up Alerts -->
<?php if (!empty($followups)): ?>
<div class="row mb-3">
  <div class="col-12">
    <div class="alert alert-warning">
      <i class="fas fa-bell mr-2"></i>
      <strong>Follow-up Reminder:</strong> You have <?= count($followups) ?> application(s) due for follow-up today.
      <a href="<?= base_url('jobs?status=Applied') ?>" class="alert-link ml-2">View them &rarr;</a>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Stats Cards -->
<div class="row mb-4">
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="stat-card card border-0 shadow-sm text-center py-3">
      <div class="stat-number text-dark"><?= $total ?></div>
      <div class="stat-label text-muted">Total</div>
    </div>
  </div>
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="stat-card card border-0 shadow-sm text-center py-3 border-left-warning">
      <div class="stat-number text-warning"><?= $shortlisted ?></div>
      <div class="stat-label text-muted">Shortlisted</div>
    </div>
  </div>
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="stat-card card border-0 shadow-sm text-center py-3 border-left-info">
      <div class="stat-number text-info"><?= $interviews ?></div>
      <div class="stat-label text-muted">Interviews</div>
    </div>
  </div>
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="stat-card card border-0 shadow-sm text-center py-3 border-left-success">
      <div class="stat-number text-success"><?= $offers ?></div>
      <div class="stat-label text-muted">Offers</div>
    </div>
  </div>
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="stat-card card border-0 shadow-sm text-center py-3 border-left-danger">
      <div class="stat-number text-danger"><?= $rejected ?></div>
      <div class="stat-label text-muted">Rejected</div>
    </div>
  </div>
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <a href="<?= base_url('jobs/add') ?>" class="card border-0 shadow-sm text-center py-3 d-flex flex-column justify-content-center align-items-center text-decoration-none add-card">
      <i class="fas fa-plus-circle fa-2x text-primary mb-1"></i>
      <small class="text-primary font-weight-bold">Add New</small>
    </a>
  </div>
</div>

<!-- Chart + Recent Table -->
<div class="row">
  <!-- Doughnut Chart -->
  <div class="col-md-5 mb-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-white border-0 font-weight-bold">
        <i class="fas fa-chart-pie text-primary mr-2"></i> Application Status
      </div>
      <div class="card-body d-flex align-items-center justify-content-center">
        <canvas id="statusChart" width="280" height="280"></canvas>
      </div>
    </div>
  </div>

  <!-- Recent Applications -->
  <div class="col-md-7 mb-4">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <span class="font-weight-bold"><i class="fas fa-clock text-primary mr-2"></i> Recent Applications</span>
        <a href="<?= base_url('jobs') ?>" class="btn btn-sm btn-outline-primary">View All</a>
      </div>
      <div class="card-body p-0">
        <?php if (empty($recent_jobs)): ?>
          <div class="p-4 text-center text-muted">
            <i class="fas fa-inbox fa-3x mb-2"></i>
            <p>No applications yet. <a href="<?= base_url('jobs/add') ?>">Add your first one!</a></p>
          </div>
        <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th>Company</th>
                <th>Role</th>
                <th>Status</th>
                <th>Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recent_jobs as $job): ?>
              <tr>
                <td class="font-weight-bold"><?= htmlspecialchars($job->company_name) ?></td>
                <td class="text-muted small"><?= htmlspecialchars($job->job_title) ?></td>
                <td>
                  <span class="badge badge-status badge-<?= strtolower($job->status) ?>">
                    <?= $job->status ?>
                  </span>
                </td>
                <td class="text-muted small"><?= date('d M', strtotime($job->applied_date)) ?></td>
                <td>
                  <a href="<?= base_url('jobs/view/' . $job->id) ?>" class="btn btn-xs btn-outline-secondary">
                    <i class="fas fa-eye"></i>
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Chart Script -->
<script>
$(document).ready(function() {
  $.ajax({
    url: BASE_URL + 'jobs/get_stats',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      var labels = Object.keys(data);
      var values = Object.values(data);
      var colors = ['#007bff','#ffc107','#17a2b8','#28a745','#dc3545','#6c757d'];

      var ctx = document.getElementById('statusChart').getContext('2d');
      new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: labels,
          datasets: [{
            data: values,
            backgroundColor: colors,
            borderWidth: 2,
            borderColor: '#fff'
          }]
        },
        options: {
          responsive: true,
          legend: { position: 'bottom', labels: { fontSize: 12, padding: 15 } },
          cutoutPercentage: 60
        }
      });
    }
  });
});
</script>