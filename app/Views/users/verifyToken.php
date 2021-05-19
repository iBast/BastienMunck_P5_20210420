<?php
if (isset($errorMessage)) : ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($errorMessage); ?>
        <br>
    </div>
<?php endif; ?>
<?php
if (isset($successMessage)) : ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($successMessage); ?>
        <br>
    </div>
<?php endif; ?>