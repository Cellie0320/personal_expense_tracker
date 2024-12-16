<header class="navbar">
    <div class="logo">ZarWise</div>
    <div class="user-info">
        Hi, 
        <span id="user-name">
            <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Guest'; ?>
        </span>
    </div>
</header>
