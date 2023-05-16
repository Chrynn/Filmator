function contentSwap() {
    var buttonShowMovie = document.querySelector(".js-swap-movie");
    var buttonShowSerial = document.querySelector(".js-swap-serial");

    var contentMovie = document.querySelector(".watch__content-movie");
    var contentSerial = document.querySelector(".watch__content-serial");

    buttonShowMovie?.addEventListener("click", () => {
        if (contentMovie?.classList.contains("watch__content-movie--hidden")) {
            contentSerial?.classList.add("watch__content-serial--hidden");
            contentMovie?.classList.remove("watch__content-movie--hidden");

            buttonShowSerial?.classList.add("watch__link-picker--active");
            buttonShowMovie?.classList.remove("watch__link-picker--active");
        }
    });

    buttonShowSerial?.addEventListener("click", () => {
        if (contentSerial?.classList.contains("watch__content-serial--hidden")) {
            contentSerial?.classList.remove("watch__content-serial--hidden");
            contentMovie?.classList.add("watch__content-movie--hidden");

            buttonShowSerial?.classList.add("watch__link-picker--active");
            buttonShowMovie?.classList.remove("watch__link-picker--active");
        }
    });

}
contentSwap();