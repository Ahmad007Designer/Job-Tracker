<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? $title : 'JobTracker' ?></title>
  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <a class="navbar-brand font-weight-bold" href="<?= base_url('dashboard') ?>">
    <i class="fas fa-briefcase mr-2"></i>JobTracker
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMenu">
    <span class="navbar-toggler-icon"></span>
  </button>

  <?php if ($this->session->userdata('user_id')): ?>
  <div class="collapse navbar-collapse" id="navMenu">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?= (uri_string() == 'dashboard') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('dashboard') ?>"><i class="fas fa-tachometer-alt mr-1"></i> Dashboard</a>
      </li>
      <li class="nav-item <?= (strpos(uri_string(), 'jobs') !== false) ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('jobs') ?>"><i class="fas fa-list mr-1"></i> Applications</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('jobs/add') ?>"><i class="fas fa-plus mr-1"></i> Add New</a>
      </li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userMenu" data-toggle="dropdown">
          <i class="fas fa-user-circle mr-1"></i>
          <?= $this->session->userdata('user_name') ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <span class="dropdown-item-text text-muted small"><?= $this->session->userdata('user_email') ?></span>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
            <i class="fas fa-sign-out-alt mr-1"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </div>
  <?php endif; ?>
</nav>

<!-- Flash Messages -->
<div class="container-fluid mt-3">
<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle mr-2"></i><?= $this->session->flashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
  </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i><?= $this->session->flashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
  </div>
<?php endif; ?>
</div>

<div class="container-fluid py-4">