<div class="container">
    <div class="error-page" style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh;">
        <div class="error-code" style="font-size: 80px; text-align: center; margin-bottom: 10px;">404</div>
        <div class="error-message" style="text-align: center; margin-bottom: 10px;"><?= __("Page Not Found") ?></div>
        <div class="error-description" style="text-align: center;"><?= __("The requested page could not be found.") ?></div>
        <div class="error-links" style="text-align: center; margin-top: 20px;">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="/app"><?= __("Return to App") ?></a>
        <?php else: ?>
            <a href="/login">Login</a>
        <?php endif; ?>
        </div>
    </div>
</div>