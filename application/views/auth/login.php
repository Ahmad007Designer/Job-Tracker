<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="auth-page bg-light">

<div class="container">
  <div class="row justify-content-center align-items-center" style="min-height:100vh">
    <div class="col-md-5">

      <div class="text-center mb-4">
        <h2 class="font-weight-bold text-primary"><i class="fas fa-briefcase"></i> JobTracker</h2>
        <p class="text-muted">Track all your job applications in one place</p>
      </div>

      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <h5 class="card-title mb-4 font-weight-bold">Sign In</h5>

          <?= $error ?>

          <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
          <?php endif; ?>

          <form action="<?= base_url('login') ?>" method="POST">
            <div class="form-group">
              <label>Email Address</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="you@email.com"
                       value="<?= set_value('email') ?>" required>
              </div>
            </div>

            <div class="form-group">
              <label>Password</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" name="password" class="form-control" placeholder="Your password" required>
              </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-3">
              <i class="fas fa-sign-in-alt mr-1"></i> Login
            </button>
          </form>

          <hr>
          <div class="text-center">
            <small class="text-muted">Demo: <strong>demo@jobtracker.com</strong> / <strong>demo123</strong></small>
          </div>
        </div>
      </div>

      <p class="text-center mt-3 text-muted">
        Don't have an account? <a href="<?= base_url('register') ?>">Register here</a>
      </p>

    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>