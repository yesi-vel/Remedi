<nav>
    <div style="color: var(--lime); font-size: 1.2rem; font-weight: bold;">SmartTraffic Cam</div>
    <div>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="monitoring.php">Monitoring</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>