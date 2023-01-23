function navigationScroll() {
    var header = document.querySelector('.header__wrap');
    if (header) {
        window.addEventListener('scroll', check);
    }

    function check() {
        var top = (window.pageYOffset || document.documentElement.scrollTop) - (document.documentElement.clientTop || 0);
        if (top > 0) {
            header?.classList.add('header__wrap--enabled');
        } else {
            header?.classList.remove('header__wrap--enabled');
        }
    }

}
navigationScroll();