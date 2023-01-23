function showPassword() {

    // login form
    var loginPasswordShow = document.querySelector(".js-password-login");
    var loginPassword = document.getElementById("auth__form-password-login");

    // register form
    var registerPasswordShow = document.querySelector(".js-password-register");
    var registerPassword = document.getElementById("auth__form-password-register");

    var registerPasswordAgainShow = document.querySelector(".js-password-again-register");
    var registerPasswordAgain = document.getElementById("auth__form-password-again-register");

    loginPasswordShow?.addEventListener("click", () => {

        if (loginPassword?.type === "password") {
            loginPassword.type = "text";
        } else {
            loginPassword.type = "password";
        }

    });
    registerPasswordShow?.addEventListener("click", () => {

        if (registerPassword?.type === "password") {
            registerPassword.type = "text";
        } else {
            registerPassword.type = "password";
        }

    });
    registerPasswordAgainShow?.addEventListener("click", () => {

        if (registerPasswordAgain?.type === "password") {
            registerPasswordAgain.type = "text";
        } else {
            registerPasswordAgain.type = "password";
        }

    });

}
showPassword();