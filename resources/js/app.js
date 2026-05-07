import '@tailwindplus/elements';

function fadeOutNotification(notification) {
    if (!notification) return;
    notification.style.transition = 'opacity 0.5s ease';
    notification.style.opacity = '0';
    notification.addEventListener('transitionend', () => {
        notification.remove();
    }, { once: true });
}

document.querySelectorAll('.notification').forEach(notification => {
    setTimeout(() => fadeOutNotification(notification), 3000);

    const closeBtn = notification.querySelector('.closeNotification');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => fadeOutNotification(notification));
    }
});