var nav = document.querySelector('.nav-links');
var burger = document.querySelector('.burger');

burger.addEventListener('click', () => {
    nav.classList.toggle('nav-active');
})