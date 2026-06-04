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
        <p class="text-muted">Create your free account</p>
      </div>

      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <h5 class="card-title mb-4 font-weight-bold">Register</h5>

          <?= $error ?>

          <form action="<?= base_url('register') ?>" method="POST">
            <div class="form-group">
              <label>Full Name</label>
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                <input type="text" name="name" class="form-control" placeholder="Ahmad Husain"
                       value="<?= set_value('name') ?>" required>
              </div>
            </div>

            <div class="form-group">
              <label>Email Address</label>
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                <input type="email" name="email" class="form-control" placeholder="you@email.com"
                       value="<?= set_value('email') ?>" required>
              </div>
            </div>

            <div class="form-group">
              <label>Password</label>
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                <input type="password" name="password" class="form-control" placeholder="Min 6 characters" required>
              </div>
            </div>

            <div class="form-group">
              <label>Confirm Password</label>
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                <input type="password" name="confirm_password" class="form-control" placeholder="Repeat password" required>
              </div>
            </div>

            <button type="submit" class="btn btn-success btn-block mt-3">
              <i class="fas fa-user-plus mr-1"></i> Create Account
            </button>
          </form>
        </div>
      </div>

      <p class="text-center mt-3 text-muted">
        Already have an account? <a href="<?= base_url('login') ?>">Login here</a>
      </p>

    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>