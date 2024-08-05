

document.addEventListener('DOMContentLoaded', function() {
    const menuBurger = document.querySelector('.menu-burger');
    const menu = document.querySelector('.menu');

    menuBurger.addEventListener('click', function() {
        menu.classList.toggle('active');
    });
});
