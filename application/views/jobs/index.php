<!-- Page Header -->
<div class="row mb-3 align-items-center">
  <div class="col">
    <h4 class="font-weight-bold mb-0">
      <i class="fas fa-list text-primary mr-2"></i> My Applications
    </h4>
  </div>
  <div class="col-auto">
    <a href="<?= base_url('jobs/add') ?>" class="btn btn-primary">
      <i class="fas fa-plus mr-1"></i> Add New
    </a>
  </div>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm mb-4">
  <div class="card-body py-3">
    <form method="GET" action="<?= base_url('jobs') ?>" id="filterForm">
      <div class="row align-items-end">
        <div class="col-md-4 mb-2 mb-md-0">
          <label class="small text-muted mb-1">Search</label>
          <input type="text" name="search" class="form-control form-control-sm"
                 placeholder="Company, role, location..."
                 value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
        </div>
        <div class="col-md-3 mb-2 mb-md-0">
          <label class="small text-muted mb-1">Status</label>
          <select name="status" class="form-control form-control-sm">
            <option value="">All Statuses</option>
            <?php foreach ($statuses as $s): ?>
            <option value="<?= $s ?>" <?= ($filters['status'] == $s) ? 'selected' : '' ?>><?= $s ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3 mb-2 mb-md-0">
          <label class="small text-muted mb-1">Job Type</label>
          <select name="job_type" class="form-control form-control-sm">
            <option value="">All Types</option>
            <?php foreach ($types as $t): ?>
            <option value="<?= $t ?>" <?= ($filters['job_type'] == $t) ? 'selected' : '' ?>><?= $t ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-outline-primary btn-sm btn-block">
            <i class="fas fa-filter mr-1"></i> Filter
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Applications Table -->
<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <?php if (empty($jobs)): ?>
      <div class="p-5 text-center text-muted">
        <i class="fas fa-search fa-3x mb-3 d-block"></i>
        <h5>No applications found</h5>
        <p>Try adjusting your filters or <a href="<?= base_url('jobs/add') ?>">add a new application</a>.</p>
      </div>
    <?php else: ?>
    <div class="table-responsive">
      <table class="table table-hover mb-0" id="jobsTable">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Company</th>
            <th>Role</th>
            <th>Location</th>
            <th>Type</th>
            <th>Status</th>
            <th>Applied</th>
            <th>Follow-up</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; foreach ($jobs as $job): ?>
          <tr id="row-<?= $job->id ?>">
            <td class="text-muted small"><?= $i++ ?></td>
            <td class="font-weight-bold"><?= htmlspecialchars($job->company_name) ?></td>
            <td><?= htmlspecialchars($job->job_title) ?></td>
            <td class="text-muted small"><?= $job->location ?: '—' ?></td>
            <td><span class="badge badge-light border"><?= $job->job_type ?></span></td>
            <td>
              <!-- AJAX inline status dropdown -->
              <select class="status-select form-control form-control-sm status-<?= strtolower($job->status) ?>"
                      data-id="<?= $job->id ?>" style="min-width:120px">
                <?php foreach ($statuses as $s): ?>
                <option value="<?= $s ?>" <?= ($job->status == $s) ? 'selected' : '' ?>><?= $s ?></option>
                <?php endforeach; ?>
              </select>
            </td>
            <td class="text-muted small">
              <?= date('d M Y', strtotime($job->applied_date)) ?>
            </td>
            <td class="small <?= ($job->follow_up_date && $job->follow_up_date <= date('Y-m-d')) ? 'text-danger font-weight-bold' : 'text-muted' ?>">
              <?= $job->follow_up_date ? date('d M', strtotime($job->follow_up_date)) : '—' ?>
            </td>
            <td>
              <div class="btn-group btn-group-sm">
                <a href="<?= base_url('jobs/view/' . $job->id) ?>" class="btn btn-outline-info" title="View">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="<?= base_url('jobs/edit/' . $job->id) ?>" class="btn btn-outline-warning" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <button onclick="confirmDelete(<?= $job->id ?>, '<?= htmlspecialchars($job->company_name) ?>')"
                        class="btn btn-outline-danger" title="Delete">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="px-3 py-2 text-muted small border-top">
      Showing <?= count($jobs) ?> application(s)
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- Delete Confirm Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h6 class="modal-title font-weight-bold text-danger">Delete Application</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="deleteModalBody"></div>
      <div class="modal-footer border-0 pt-0">
        <button class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
        <a id="deleteConfirmBtn" href="#" class="btn btn-sm btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>

<script>
// AJAX inline status update
$(document).on('change', '.status-select', function() {
  var id     = $(this).data('id');
  var status = $(this).val();
  var $sel   = $(this);

  $.ajax({
    url: BASE_URL + 'jobs/update_status',
    type: 'POST',
    dataType: 'json',
    data: { id: id, status: status },
    success: function(res) {
      if (res.success) {
        $sel.removeClass().addClass('status-select form-control form-control-sm status-' + status.toLowerCase());
        // Show small toast
        showToast(res.msg, 'success');
      }
    },
    error: function() {
      showToast('Update failed. Please try again.', 'danger');
    }
  });
});

function confirmDelete(id, company) {
  $('#deleteModalBody').html('Are you sure you want to delete the application for <strong>' + company + '</strong>?');
  $('#deleteConfirmBtn').attr('href', BASE_URL + 'jobs/delete/' + id);
  $('#deleteModal').modal('show');
}

function showToast(msg, type) {
  var $toast = $('<div class="alert alert-' + type + ' alert-toast">' + msg + '</div>');
  $('body').append($toast);
  setTimeout(function() { $toast.fadeOut(400, function() { $(this).remove(); }); }, 2500);
}

// Status options color
var statusColors = {
  'applied':     { statuses: ['Applied'],     cls: 'primary' },
  'shortlisted': { statuses: ['Shortlisted'], cls: 'warning' },
  'interview':   { statuses: ['Interview'],   cls: 'info' },
  'offer':       { statuses: ['Offer'],       cls: 'success' },
  'rejected':    { statuses: ['Rejected'],    cls: 'danger' },
  'withdrawn':   { statuses: ['Withdrawn'],   cls: 'secondary' },
};
</script>