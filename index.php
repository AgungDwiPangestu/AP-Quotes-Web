<?php

/**
 * Homepage - Ap Quotes
 * Menampilkan semua post dari pengguna
 */

session_start();
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';

// Check if user is logged in
if (!is_logged_in()) {
    redirect('pages/login.php');
}

// Check session timeout
if (!check_session_timeout()) {
    redirect('pages/login.php', 'Sesi telah habis. Silakan login kembali.', 'warning');
}

// Get user data
$user_id = get_current_user_id();
$username = get_current_username();
$is_admin = is_admin();

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$posts_per_page = 10;
$offset = ($page - 1) * $posts_per_page;

// Count total posts
$count_query = "SELECT COUNT(*) as total FROM posts";
$count_result = $conn->query($count_query);
$total_posts = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_posts / $posts_per_page);

// Query to get posts
$query = "
    SELECT 
        posts.id AS post_id, 
        posts.content, 
        posts.created_at, 
        posts.user_id,
        users.username, 
        (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comment_count,
        (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) AS like_count,
        (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id AND likes.user_id = ?) AS user_liked
    FROM posts
    JOIN users ON posts.user_id = users.id
    ORDER BY posts.created_at DESC
    LIMIT ? OFFSET ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $user_id, $posts_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$page_title = 'Beranda';
include __DIR__ . '/includes/header.php';
?>

<!-- Welcome Message -->
<div class="card">
    <div class="card-content text-center">
        <h2 style="color: var(--primary-color); margin-bottom: 15px;">
            <i class="fas fa-quote-left"></i> Selamat Datang di Ap Quotes! <i class="fas fa-quote-right"></i>
        </h2>
        <p style="font-size: 1.1rem; color: var(--text-secondary);">
            Bagikan inspirasi Anda kepada dunia! Klik tombol "Buat Post" untuk membuat quotes Anda sendiri
            dan lihat bagaimana kata-kata Anda dapat menyentuh hati orang lain. 🌟
        </p>
    </div>
</div>

<!-- Posts Section -->
<div class="posts-container">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($post = $result->fetch_assoc()): ?>
            <div class="card" id="post-<?= $post['post_id'] ?>">
                <div class="card-header">
                    <div class="card-user">
                        <div class="user-avatar">
                            <?= strtoupper(substr($post['username'], 0, 1)) ?>
                        </div>
                        <div class="user-info">
                            <h3><?= htmlspecialchars($post['username']) ?></h3>
                            <p class="post-date">
                                <i class="far fa-clock"></i> <?= format_date($post['created_at']) ?>
                            </p>
                        </div>
                    </div>

                    <?php if ($is_admin || $post['user_id'] == $user_id): ?>
                        <div class="card-actions">
                            <?php if ($post['user_id'] == $user_id): ?>
                                <a href="pages/edit_post.php?id=<?= $post['post_id'] ?>"
                                    class="btn-icon"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            <?php endif; ?>

                            <?php if ($is_admin || $post['user_id'] == $user_id): ?>
                                <a href="actions/delete_post.php?id=<?= $post['post_id'] ?>"
                                    class="btn-icon btn-danger"
                                    title="Hapus"
                                    onclick="return confirmDelete('Yakin ingin menghapus post ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card-content">
                    <p>"<?= nl2br(htmlspecialchars($post['content'])) ?>"</p>
                </div>

                <div class="card-footer">
                    <button class="action-btn <?= $post['user_liked'] > 0 ? 'liked' : '' ?>"
                        onclick="toggleLike(<?= $post['post_id'] ?>, this)">
                        <i class="fas fa-heart"></i>
                        <span class="like-count"><?= $post['like_count'] ?></span> Suka
                    </button>

                    <button class="action-btn"
                        onclick="toggleComments(<?= $post['post_id'] ?>)">
                        <i class="fas fa-comment"></i>
                        <span class="comment-count"><?= $post['comment_count'] ?></span> Komentar
                    </button>
                </div>

                <!-- Comments Section -->
                <div id="comments-section-<?= $post['post_id'] ?>"
                    class="comments-section"
                    style="display: none;">
                    <div class="comments-header">
                        <i class="fas fa-comments"></i> Komentar
                    </div>
                    <div id="comments-<?= $post['post_id'] ?>">
                        <!-- Comments will be loaded via AJAX -->
                    </div>

                    <!-- Comment Form -->
                    <form class="comment-form"
                        onsubmit="return submitComment(<?= $post['post_id'] ?>, this)">
                        <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
                        <textarea name="comment"
                            placeholder="Tulis komentar Anda..."
                            required
                            rows="3"></textarea>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Kirim
                        </button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>">
                        <i class="fas fa-chevron-left"></i> Sebelumnya
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <?php if ($i == $page): ?>
                        <span class="active"><?= $i ?></span>
                    <?php else: ?>
                        <a href="?page=<?= $i ?>"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?= $page + 1 ?>">
                        Selanjutnya <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <!-- Empty State -->
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Belum Ada Post</h3>
            <p>Jadilah yang pertama membagikan kutipan inspiratif!</p>
            <a href="pages/create_post.php" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Buat Post Pertama
            </a>
        </div>
    <?php endif; ?>
</div>

<?php
$stmt->close();
include __DIR__ . '/includes/footer.php';
?>