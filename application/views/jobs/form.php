<?php $is_edit = isset($job) && $job !== NULL; ?>

<div class="row mb-3">
  <div class="col">
    <h4 class="font-weight-bold mb-0">
      <i class="fas fa-<?= $is_edit ? 'edit' : 'plus-circle' ?> text-primary mr-2"></i>
      <?= $is_edit ? 'Edit Application' : 'Add New Application' ?>
    </h4>
    <nav aria-label="breadcrumb" class="mt-1">
      <ol class="breadcrumb bg-transparent p-0 mb-0 small">
        <li class="breadcrumb-item"><a href="<?= base_url('jobs') ?>">Applications</a></li>
        <li class="breadcrumb-item active"><?= $is_edit ? 'Edit' : 'Add New' ?></li>
      </ol>
    </nav>
  </div>
</div>

<?= $error ?>

<div class="card border-0 shadow-sm">
  <div class="card-body p-4">
    <form action="<?= $is_edit ? base_url('jobs/edit/' . $job->id) : base_url('jobs/add') ?>" method="POST">

      <div class="row">
        <!-- Company Name -->
        <div class="col-md-6 form-group">
          <label class="font-weight-bold">Company Name <span class="text-danger">*</span></label>
          <input type="text" name="company_name" class="form-control"
                 placeholder="e.g. TCS, Infosys, Nagarro"
                 value="<?= $is_edit ? htmlspecialchars($job->company_name) : set_value('company_name') ?>"
                 required>
        </div>

        <!-- Job Title -->
        <div class="col-md-6 form-group">
          <label class="font-weight-bold">Job Title <span class="text-danger">*</span></label>
          <input type="text" name="job_title" class="form-control"
                 placeholder="e.g. Junior PHP Developer"
                 value="<?= $is_edit ? htmlspecialchars($job->job_title) : set_value('job_title') ?>"
                 required>
        </div>

        <!-- Location -->
        <div class="col-md-4 form-group">
          <label class="font-weight-bold">Location</label>
          <input type="text" name="location" class="form-control"
                 placeholder="e.g. Noida, UP / Remote"
                 value="<?= $is_edit ? htmlspecialchars($job->location) : set_value('location') ?>">
        </div>

        <!-- Job Type -->
        <div class="col-md-4 form-group">
          <label class="font-weight-bold">Job Type</label>
          <select name="job_type" class="form-control">
            <?php foreach ($types as $t): ?>
            <option value="<?= $t ?>"
              <?= ($is_edit && $job->job_type == $t) || (!$is_edit && set_value('job_type') == $t) ? 'selected' : '' ?>>
              <?= $t ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Salary Range -->
        <div class="col-md-4 form-group">
          <label class="font-weight-bold">Salary / CTC</label>
          <input type="text" name="salary_range" class="form-control"
                 placeholder="e.g. 3-4 LPA"
                 value="<?= $is_edit ? htmlspecialchars($job->salary_range) : set_value('salary_range') ?>">
        </div>

        <!-- Status -->
        <div class="col-md-4 form-group">
          <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control" required>
            <?php foreach ($statuses as $s): ?>
            <option value="<?= $s ?>"
              <?= ($is_edit && $job->status == $s) || (!$is_edit && (set_value('status') == $s || $s == 'Applied')) ? 'selected' : '' ?>>
              <?= $s ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Applied Date -->
        <div class="col-md-4 form-group">
          <label class="font-weight-bold">Applied Date <span class="text-danger">*</span></label>
          <input type="date" name="applied_date" class="form-control"
                 value="<?= $is_edit ? $job->applied_date : date('Y-m-d') ?>"
                 required>
        </div>

        <!-- Follow-up Date -->
        <div class="col-md-4 form-group">
          <label class="font-weight-bold">Follow-up Date</label>
          <input type="date" name="follow_up_date" class="form-control"
                 value="<?= $is_edit ? $job->follow_up_date : '' ?>">
          <small class="text-muted">Set a reminder to follow up</small>
        </div>

        <!-- Job URL -->
        <div class="col-md-6 form-group">
          <label class="font-weight-bold">Job URL</label>
          <input type="url" name="job_url" class="form-control"
                 placeholder="https://careers.tcs.com/..."
                 value="<?= $is_edit ? htmlspecialchars($job->job_url) : set_value('job_url') ?>">
        </div>

        <!-- Resume Version -->
        <div class="col-md-6 form-group">
          <label class="font-weight-bold">Resume Version</label>
          <input type="text" name="resume_version" class="form-control"
                 placeholder="e.g. v2, v3-php-focused"
                 value="<?= $is_edit ? htmlspecialchars($job->resume_version) : set_value('resume_version') ?>">
          <small class="text-muted">Track which resume you sent</small>
        </div>

        <!-- Notes -->
        <div class="col-12 form-group">
          <label class="font-weight-bold">Notes</label>
          <textarea name="notes" class="form-control" rows="4"
                    placeholder="HR contact, interview details, salary discussed, next steps..."><?= $is_edit ? htmlspecialchars($job->notes) : set_value('notes') ?></textarea>
        </div>
      </div>

      <div class="d-flex justify-content-between mt-2">
        <a href="<?= base_url('jobs') ?>" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left mr-1"></i> Cancel
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save mr-1"></i>
          <?= $is_edit ? 'Update Application' : 'Save Application' ?>
        </button>
      </div>

    </form>
  </div>
</div>