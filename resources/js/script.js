const alertWindow = document.getElementById('alertWindow');

if (alertWindow) { // only run if alert exists
    const closeBtn = document.getElementById('closeAlert');

    alertWindow.style.display = 'block';

    setTimeout(() => {
        alertWindow.style.display = 'none';
    }, 3000);

    closeBtn.addEventListener('click', () => {
        alertWindow.style.display = 'none';
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('mode-btns');
    const img = document.getElementById('modes');

    btn.addEventListener('click', () => {
        const moon = btn.dataset.moon;
        const sun = btn.dataset.sun;
        const mode = btn.dataset.mode;

        if (mode === 'dark') {
            img.src = sun;
            btn.dataset.mode = 'light';
            btn.classList.add('light');
        } else {
            img.src = moon;
            btn.dataset.mode = 'dark';
            btn.classList.remove('light');
        }
    });
});

const ddBtn = document.getElementById('dd-btn');
const dropdown = document.querySelector('.drop-down-window');

ddBtn.addEventListener('click', (e) => {
    e.stopPropagation(); // prevent document click
    ddBtn.classList.toggle('active');

    if (dropdown.style.display === 'flex') {
        dropdown.style.display = 'none';
    } else {
        dropdown.style.display = 'flex';
    }
});

dropdown.addEventListener('click', (e) => {
    e.stopPropagation(); // allow clicking inside dropdown
});

document.addEventListener('click', () => {
    dropdown.style.display = 'none';
    ddBtn.classList.remove('active');
});

document.querySelectorAll('.size-menu').forEach(menu => {
    const buttons = menu.querySelectorAll('.sizes');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            // remove active from all buttons in THIS size-menu
            buttons.forEach(b => b.classList.remove('active'));

            // add active to clicked button
            btn.classList.add('active');
        });
    });
});