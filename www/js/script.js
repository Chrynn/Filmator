import "./auth-window";
import "./content-swap";
import "./hamburger";
import "./hide-flash";
import "./image-upload";
import "./navigation-scroll";
import "./show-password";
import "./slider";

// --- content animation ---
window.addEventListener('scroll', contentAnimation);

function contentAnimation(){
  var reveals = document.querySelectorAll('.reveal');

  for(var i = 0; i < reveals.length; i++){
    // innerHeight - výška okna, window - výška okna prohlížeče
    var windowheight = window.innerHeight;
    // getBoundingClientRect - zjišťuje aktuální umíštění na webu, .top - odsazení v PX od vzrchu
    var revealtop = reveals[i].getBoundingClientRect().top;
    var revealpoint = 100; // o kolik chci mít posunuté při animaci

    if(revealtop < windowheight - revealpoint){
      reveals[i].classList.add('reveal--active');
    }
  }
}

function closePlay() {
  var playbutton = document.querySelector(".js-close-play");

  playbutton?.addEventListener("click", () => {
    playbutton.style.display = "none";
  });

}
closePlay();

// --- ajax initialization ---
$(function () {
    $.nette.init();
});

// --- class re-bind after ajax ---
$(document).ajaxComplete(function refreshAuth(){
    authWindow();
});

// --- hide flash ID in URL ---
// window.history.replaceState({}, null, removeFid(url, pos));
