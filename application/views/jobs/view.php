<div class="row mb-3 align-items-center">
  <div class="col">
    <h4 class="font-weight-bold mb-0">
      <i class="fas fa-briefcase text-primary mr-2"></i>
      <?= htmlspecialchars($job->company_name) ?>
    </h4>
    <nav aria-label="breadcrumb" class="mt-1">
      <ol class="breadcrumb bg-transparent p-0 mb-0 small">
        <li class="breadcrumb-item"><a href="<?= base_url('jobs') ?>">Applications</a></li>
        <li class="breadcrumb-item active"><?= htmlspecialchars($job->company_name) ?></li>
      </ol>
    </nav>
  </div>
  <div class="col-auto">
    <a href="<?= base_url('jobs/edit/' . $job->id) ?>" class="btn btn-warning btn-sm">
      <i class="fas fa-edit mr-1"></i> Edit
    </a>
    <a href="<?= base_url('jobs') ?>" class="btn btn-outline-secondary btn-sm ml-1">
      <i class="fas fa-arrow-left mr-1"></i> Back
    </a>
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body">

        <div class="d-flex align-items-start justify-content-between mb-3">
          <div>
            <h5 class="font-weight-bold mb-1"><?= htmlspecialchars($job->job_title) ?></h5>
            <p class="text-muted mb-0">
              <i class="fas fa-building mr-1"></i><?= htmlspecialchars($job->company_name) ?>
              <?php if ($job->location): ?>
              &nbsp;&bull;&nbsp;<i class="fas fa-map-marker-alt mr-1"></i><?= htmlspecialchars($job->location) ?>
              <?php endif; ?>
            </p>
          </div>
          <span class="badge badge-status badge-<?= strtolower($job->status) ?> badge-lg">
            <?= $job->status ?>
          </span>
        </div>

        <hr>

        <div class="row">
          <div class="col-6 col-md-3 mb-3">
            <small class="text-muted d-block">Job Type</small>
            <strong><?= $job->job_type ?></strong>
          </div>
          <div class="col-6 col-md-3 mb-3">
            <small class="text-muted d-block">Salary / CTC</small>
            <strong><?= $job->salary_range ?: '—' ?></strong>
          </div>
          <div class="col-6 col-md-3 mb-3">
            <small class="text-muted d-block">Applied On</small>
            <strong><?= date('d M Y', strtotime($job->applied_date)) ?></strong>
          </div>
          <div class="col-6 col-md-3 mb-3">
            <small class="text-muted d-block">Follow-up</small>
            <strong class="<?= ($job->follow_up_date && $job->follow_up_date <= date('Y-m-d')) ? 'text-danger' : '' ?>">
              <?= $job->follow_up_date ? date('d M Y', strtotime($job->follow_up_date)) : '—' ?>
            </strong>
          </div>
          <div class="col-6 col-md-3 mb-3">
            <small class="text-muted d-block">Resume Version</small>
            <strong><?= $job->resume_version ?: '—' ?></strong>
          </div>
          <?php if ($job->job_url): ?>
          <div class="col-md-9 mb-3">
            <small class="text-muted d-block">Job URL</small>
            <a href="<?= htmlspecialchars($job->job_url) ?>" target="_blank" class="text-primary">
              <i class="fas fa-external-link-alt mr-1"></i>
              <?= htmlspecialchars(substr($job->job_url, 0, 60)) ?>...
            </a>
          </div>
          <?php endif; ?>
        </div>

        <?php if ($job->notes): ?>
        <hr>
        <div>
          <small class="text-muted font-weight-bold d-block mb-2"><i class="fas fa-sticky-note mr-1"></i> Notes</small>
          <p class="mb-0"><?= nl2br(htmlspecialchars($job->notes)) ?></p>
        </div>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card border-0 shadow-sm mb-3">
      <div class="card-body">
        <h6 class="font-weight-bold mb-3">Quick Status Update</h6>
        <div class="d-flex flex-column gap-1" id="statusButtons">
          <?php
          $statuses = ['Applied','Shortlisted','Interview','Offer','Rejected','Withdrawn'];
          $btnMap = ['Applied'=>'primary','Shortlisted'=>'warning','Interview'=>'info','Offer'=>'success','Rejected'=>'danger','Withdrawn'=>'secondary'];
          foreach ($statuses as $s):
          ?>
          <button onclick="quickStatus(<?= $job->id ?>, '<?= $s ?>')"
                  class="btn btn-sm btn-<?= ($job->status == $s) ? $btnMap[$s] : 'outline-' . $btnMap[$s] ?> mb-1 w-100 text-left"
                  id="btn-<?= strtolower($s) ?>">
            <?= ($job->status == $s) ? '&#10003; ' : '' ?><?= $s ?>
          </button>
          <?php endforeach; ?>
        </div>
        <div id="statusMsg" class="mt-2 small text-success" style="display:none"></div>
      </div>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h6 class="font-weight-bold mb-2">Actions</h6>
        <a href="<?= base_url('jobs/edit/' . $job->id) ?>" class="btn btn-warning btn-sm btn-block mb-2">
          <i class="fas fa-edit mr-1"></i> Edit Application
        </a>
        <button onclick="confirmDelete(<?= $job->id ?>, '<?= htmlspecialchars($job->company_name) ?>')"
                class="btn btn-danger btn-sm btn-block">
          <i class="fas fa-trash mr-1"></i> Delete
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h6 class="modal-title font-weight-bold text-danger">Delete Application</h6>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="deleteModalBody"></div>
      <div class="modal-footer border-0">
        <button class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
        <a id="deleteConfirmBtn" href="#" class="btn btn-sm btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>

<script>
function quickStatus(id, status) {
  var btnMap = {Applied:'primary',Shortlisted:'warning',Interview:'info',Offer:'success',Rejected:'danger',Withdrawn:'secondary'};
  $.ajax({
    url: BASE_URL + 'jobs/update_status',
    type: 'POST',
    dataType: 'json',
    data: { id: id, status: status },
    success: function(res) {
      if (res.success) {
        // reset all buttons
        $.each(btnMap, function(s, c) {
          var $b = $('#btn-' + s.toLowerCase());
          $b.removeClass('btn-' + c).addClass('btn-outline-' + c).html(s);
        });
        // activate clicked
        var $active = $('#btn-' + status.toLowerCase());
        $active.removeClass('btn-outline-' + btnMap[status]).addClass('btn-' + btnMap[status]).html('&#10003; ' + status);
        $('#statusMsg').text(res.msg).show();
        setTimeout(function(){ $('#statusMsg').fadeOut(); }, 2500);
      }
    }
  });
}

function confirmDelete(id, company) {
  $('#deleteModalBody').html('Delete application for <strong>' + company + '</strong>?');
  $('#deleteConfirmBtn').attr('href', BASE_URL + 'jobs/delete/' + id);
  $('#deleteModal').modal('show');
}
</script>