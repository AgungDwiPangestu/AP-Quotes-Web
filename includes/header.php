<?php

/**
 * Header Template
 */

// Check login dan session timeout
if (!isset($_SESSION['user_id'])) {
    redirect('pages/login.php');
}

if (!check_session_timeout()) {
    redirect('pages/login.php', 'Sesi telah habis. Silakan login kembali.', 'warning');
}

$is_logged_in = is_logged_in();
$username = get_current_username();
$is_admin = is_admin();

// Get flash message
$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ap Quotes - Bagikan kutipan dan pemikiran inspiratif Anda">
    <meta name="author" content="Ap Quotes Team">
    <title><?= isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <link rel="stylesheet" href="<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>
    <!-- Flash Messages -->
    <?php if ($flash): ?>
        <div class="flash-message flash-<?= $flash['type'] ?>" id="flashMessage">
            <span><?= htmlspecialchars($flash['message']) ?></span>
            <button onclick="closeFlash()" class="flash-close">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Header Navigation -->
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="header-left">
                    <h1><a href="index.php" class="logo"><i class="fas fa-quote-left"></i> <?= SITE_NAME ?></a></h1>
                </div>

                <nav class="header-nav desktop-nav">
                    <a href="index.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '' ?>">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                    <?php if ($is_logged_in): ?>
                        <a href="pages/create_post.php" class="nav-link btn-create">
                            <i class="fas fa-plus-circle"></i> Buat Post
                        </a>
                        <a href="pages/my_posts.php" class="nav-link">
                            <i class="fas fa-file-alt"></i> Post Saya
                        </a>
                        <div class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle">
                                <i class="fas fa-user-circle"></i> <?= htmlspecialchars($username) ?>
                            </a>
                            <div class="dropdown-menu">
                                <a href="pages/my_profile.php"><i class="fas fa-user"></i> Profil</a>
                                <a href="pages/edit_profile.php"><i class="fas fa-edit"></i> Edit Profil</a>
                                <?php if ($is_admin): ?>
                                    <a href="pages/admin.php"><i class="fas fa-cog"></i> Admin Panel</a>
                                <?php endif; ?>
                                <hr>
                                <a href="actions/logout.php" onclick="return confirm('Yakin ingin logout?')">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="pages/login.php" class="nav-link">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="pages/register.php" class="nav-link btn-register">
                            <i class="fas fa-user-plus"></i> Daftar
                        </a>
                    <?php endif; ?>
                </nav>

                <div class="header-right mobile-nav">
                    <button class="menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle menu">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Sidebar -->
    <div id="mobileSidebar" class="mobile-sidebar">
        <div class="sidebar-header">
            <h2><?= SITE_NAME ?></h2>
            <button class="close-btn" onclick="toggleMobileMenu()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
            <?php if ($is_logged_in): ?>
                <a href="pages/create_post.php"><i class="fas fa-plus-circle"></i> Buat Post</a>
                <a href="pages/my_posts.php"><i class="fas fa-file-alt"></i> Post Saya</a>
                <a href="pages/my_profile.php"><i class="fas fa-user"></i> Profil Saya</a>
                <a href="pages/edit_profile.php"><i class="fas fa-edit"></i> Edit Profil</a>
                <?php if ($is_admin): ?>
                    <a href="pages/admin.php"><i class="fas fa-cog"></i> Admin Panel</a>
                <?php endif; ?>
                <a href="actions/logout.php" onclick="return confirm('Yakin ingin logout?')">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            <?php else: ?>
                <a href="pages/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="pages/register.php"><i class="fas fa-user-plus"></i> Daftar</a>
            <?php endif; ?>
        </nav>
    </div>

    <div class="overlay" id="overlay" onclick="toggleMobileMenu()"></div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">