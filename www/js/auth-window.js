function authWindow() {
    /*

      MAC VSCode shortcuts:
      - row duplication: option + shift + arrow
      - row moving: option + arrow

      Windows VSCode shortucts:
      - row duplication: alt + shift + arrow
      - row moving: alt + arrow

    */
    var overlay = document.querySelector(".auth");
    var bodyTag = document.querySelector("body");

    var authInput = document.querySelectorAll(".auth__form");
    var authInputError = document.querySelectorAll(".auth__label-error");
    var authCheckBox = document.querySelectorAll(".auth__check");
    var authMessage = document.querySelectorAll(".auth__message");

    // querySelectorAll - create array of appearance
    var buttonShow = document.querySelectorAll(".js-show-auth");

    var blockLogin = document.querySelector(".js-block-login");
    var blockRegister = document.querySelector(".js-block-register");
    var blockForgotten = document.querySelector(".js-block-forgotten");

    var actionLogin = document.querySelectorAll(".js-show-login");
    var actionRegister = document.querySelector(".js-show-register");
    var actionForgotten = document.querySelector(".js-show-forgotten");

    function closeAuth() {
        overlay?.classList.remove("auth--active");
        blockLogin?.classList.remove("auth__content--active");
        blockRegister?.classList.remove("auth__content--active");
        blockForgotten?.classList.remove("auth__content--active");
        bodyTag?.classList.remove("auth--active");
        clearErrors();
    }

    function showAuth() {
        overlay?.classList.add("auth--active");
        blockLogin?.classList.add("auth__content--active");
        bodyTag?.classList.add("auth--active");
    }

    function showLogin() {
        blockLogin?.classList.add("auth__content--active");
        blockRegister?.classList.remove("auth__content--active");
        blockForgotten?.classList.remove("auth__content--active");
        clearErrors();
    }

    function showRegister() {
        blockLogin?.classList.remove("auth__content--active");
        blockRegister?.classList.add("auth__content--active");
        clearErrors();
    }

    function showForgotten() {
        blockLogin?.classList.remove("auth__content--active");
        blockForgotten?.classList.add("auth__content--active");
        clearErrors();
    }

    function clearErrors() {
        authInput.forEach((input) => {
            input.classList.remove("auth__form--error");
            input["value"] = "";
        });
        authInputError.forEach((error) => {
            error.classList.remove("auth__label-error--active");
        });
        authCheckBox.forEach((checkbox) => {
            checkbox["checked"] = false;
        });
        authMessage.forEach((message) => {
            message.classList.remove("auth__message--active");
        });
    }

    buttonShow.forEach((show) => {
        show.addEventListener("click", () => {
            showAuth();
        });
    });

    actionLogin.forEach((show) => {
        show.addEventListener("click", () => {
            showLogin();
        });
    });

    actionRegister?.addEventListener("click", () => {
        showRegister();
    });

    actionForgotten?.addEventListener("click", () => {
        showForgotten();
    });

    overlay?.addEventListener("click", function(event) {
        // has to be both (box & line) or wont work
        if (event.target.matches(".js-close-auth") || event.target.matches(".auth__cross") || !event.target.closest(".auth__content-wrap")) {
            closeAuth();
        }
    });

}
authWindow();