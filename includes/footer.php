        </div>
        </main>

        <!-- Footer -->
        <footer class="site-footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section">
                        <h3><i class="fas fa-quote-left"></i> <?= SITE_NAME ?></h3>
                        <p>Bagikan kutipan dan pemikiran inspiratif Anda dengan dunia.</p>
                    </div>
                    <div class="footer-section">
                        <h4>Tautan Cepat</h4>
                        <ul>
                            <li><a href="index.php">Beranda</a></li>
                            <li><a href="pages/about.php">Tentang</a></li>
                            <li><a href="pages/contact.php">Kontak</a></li>
                        </ul>
                    </div>
                    <div class="footer-section">
                        <h4>Hubungi Kami</h4>
                        <p><i class="fas fa-envelope"></i> CreateQuotes@gmail.com</p>
                        <p><i class="fab fa-github"></i> <a href="https://github.com/apqGuns" target="_blank">github.com/apqGuns</a></p>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="assets/js/main.js"></script>
        <?php if (isset($extra_js)): ?>
            <?php foreach ($extra_js as $js): ?>
                <script src="<?= $js ?>"></script>
            <?php endforeach; ?>
        <?php endif; ?>
        </body>

        </html>