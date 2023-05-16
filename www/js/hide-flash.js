function hideFlash() {

    let flash = document.querySelector(".flash");

    if (flash) {
        setTimeout(() => {
            fadeAway();
        }, 5000)
    }

    function fadeAway() {
        flash?.classList.remove("visible");
    }

}
hideFlash();