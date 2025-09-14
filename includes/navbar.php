<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Result Management</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <span class="navbar-text text-white me-3">
            Logged in as: <?php echo htmlspecialchars($_SESSION["username"]); ?>
          </span>
        </li>
        <li class="nav-item">
          <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
