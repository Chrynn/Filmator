// --- hamburger menu ---
function navigationHamburger() {
    var menuLine2 = document.querySelector('.hamburger-div2');
    var menuOpen2 = false;
    menuLine2.addEventListener('click', () => {
        if (!menuOpen2){
            menuLine2.classList.add('open2');
            menuOpen2 = true;
        } else {
            menuLine2.classList.remove('open2');
            menuOpen2 = false;
        }
    });

    const menuBtnTwo = document.querySelector('.hamburger-div2');
    let menuOpenTwo = false;
    var navULTwo = document.querySelector(".window-two");
    menuBtnTwo.addEventListener('click', () => {
        if (!menuOpenTwo) {
            menuBtnTwo.classList.add('open');
            menuOpenTwo = true;
            navULTwo.classList.add('window-two-active');
        } else {
            menuBtnTwo.classList.remove('open');
            menuOpenTwo = false;
            navULTwo.classList.remove('window-two-active');
        }
    });
}
navigationHamburger();