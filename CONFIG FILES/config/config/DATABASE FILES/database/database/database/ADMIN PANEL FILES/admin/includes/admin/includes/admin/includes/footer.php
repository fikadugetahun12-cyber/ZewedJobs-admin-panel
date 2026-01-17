            <?php if (!isset($hideLayout) || !$hideLayout): ?>
            </div> <!-- End content -->
        </div> <!-- End main -->
    </div> <!-- End wrapper -->
    <?php endif; ?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="../assets/js/admin.js"></script>
    
    <?php if (isset($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <?php if (isset($custom_script)): ?>
        <script>
            <?php echo $custom_script; ?>
        </script>
    <?php endif; ?>
</body>
</html>
