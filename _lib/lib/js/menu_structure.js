$( document ).ready(function() {

    $('.menu .menu__item--withsubmenu > .menu__link').click(function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('menu__item--active');
    });

    $('.menu .menu__toggle').click(function (e) {
        e.preventDefault();
        scToggleMenu();
    });

    $('.menu .menu__overlay').click(function (e) {
        e.preventDefault();
        scToggleMenu();
    });
});

function scToggleMenu() {
    $('.menu .menu__toggle').toggleClass('menu__toggle--active');
    $('.menu .menu__toggle').parent().toggleClass('menu--active');
}