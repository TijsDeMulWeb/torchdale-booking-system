import '@tailwindplus/elements';
const closeNotification = document.querySelector('#closeNotification') ?? null;

setTimeout(() => {
    const notification = document.querySelector('#notification');
    if (!notification) return;
    notification.style.transition = 'opacity 0.5s ease';
    notification.style.opacity = '0';
}, 3000);

if (closeNotification) {
    closeNotification.addEventListener('click', () => {
        const notification = document.querySelector('#notification');
        if (!notification) return;
        notification.style.transition = 'opacity 0.5s ease';
        notification.style.opacity = '0';
    });
};