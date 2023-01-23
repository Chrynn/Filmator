function uploadPoster() {
    let resetButton = document.querySelector(".js-upload-file-reset-poster");
    let imageText = document.querySelector(".js-upload-file-text-poster");
    let image = document.querySelector(".js-upload-file-image-poster");
    let input = document.querySelector(".js-input-poster");

    input?.addEventListener("change", () => {
        let file = input.files[0];
        let fileName = file.name;
        let fileNameLimit = 30;

        // load image name
        if (fileName.length > fileNameLimit) {
            fileName = fileName.substring(0,fileNameLimit) + "...";
        }
        imageText.innerHTML = fileName;

        // load image preview
        var fileReader = new FileReader();
        fileReader.readAsDataURL(file);

        fileReader.onload = function (oFREvent) {
            image.src = oFREvent.target.result;
        };
    });

    resetButton?.addEventListener("click", () => {
        imageText.textContent = "Soubor není vybrán"; // restore og text
        image.src = "../../img/filmator/unknown-image.png"; // restore og image
        input.value = ""; // delete files
    });
}
uploadPoster();

function uploadBanner() {
    let resetButton = document.querySelector(".js-upload-file-reset-banner");
    let imageText = document.querySelector(".js-upload-file-text-banner");
    let image = document.querySelector(".js-upload-file-image-banner");
    let input = document.querySelector(".js-input-banner");

    input?.addEventListener("change", () => {
        let file = input.files[0];
        let fileName = file.name;
        let fileNameLimit = 30;

        // load image name
        if (fileName.length > fileNameLimit) {
            fileName = fileName.substring(0,fileNameLimit) + "...";
        }
        imageText.innerHTML = fileName;

        // load image preview
        var fileReader = new FileReader();
        fileReader.readAsDataURL(file);

        fileReader.onload = function (oFREvent) {
            image.src = oFREvent.target.result;
        };
    });

    resetButton?.addEventListener("click", () => {
        imageText.textContent = "Soubor není vybrán";
        image.src = "../../img/filmator/unknown-image.png";
        input.value = "";
    });
}
uploadBanner();