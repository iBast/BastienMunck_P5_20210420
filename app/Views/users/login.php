<?php
if (isset($successMessage)) : ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($successMessage); ?>
        <br>
    </div>
<?php endif; ?>
<?php
echo "hello world!";
?>