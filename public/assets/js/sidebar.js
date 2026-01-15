document.addEventListener('DOMContentLoaded', function () {
    const copyBtn = document.getElementById('copy-login-link');

    if (!copyBtn) return;

    copyBtn.addEventListener('click', function () {
        const url = this.dataset.loginUrl;

        navigator.clipboard.writeText(url)
            .then(() => {
                alert('Login link copied to clipboard!');
            })
            .catch(() => {
                alert('Failed to copy link');
            });
    });
});
