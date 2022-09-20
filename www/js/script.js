// --- header animation ---
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

// --- slider ---
function MainSlider() {
  
  var sliderExist = document.querySelector(".slider__item");

  if (sliderExist){
    const slides = document.querySelector(".slider__block-wrap")?.children;
    const prev = document.querySelector(".js-slider-prev");
    const next = document.querySelector(".js-slider-next");
    const indicator = document.querySelector(".slider__indicator");
    let index=0;

       prev?.addEventListener("click",function(){
          prevSlide();
          updateCircleIndicator();
          resetTimer();
       })

       next?.addEventListener("click",function(){
          nextSlide();
          updateCircleIndicator();
          resetTimer();
       })
       // create circle indicators
        function circleIndicator(){
            for(let i=0; i< slides.length; i++){
              const div=document.createElement("div");

                    div.id=i;
                    if(i==0){
                      div.className="slider__item--active";
                    }
                   indicator.appendChild(div);
            }
        }
        circleIndicator();

        function updateCircleIndicator(){
          for(let i=0; i<indicator.children.length; i++){
            indicator?.children[i].classList.remove("slider__item--active");
          }
          indicator?.children[index].classList.add("slider__item--active");
        }

        function prevSlide(){
            if(index==0){
              index=slides.length-1;
            }
            else{
              index--;
            }
            changeSlide();
          }

          function nextSlide(){
              if(index==slides.length-1){
                index=0;
              }
              else{
                index++;
              }
              changeSlide();
          }

       function changeSlide(){
               for(let i=0; i<slides.length; i++){
                  slides[i].classList.remove("slider__item--active");
               }

           slides[index].classList.add("slider__item--active");
       }

       function resetTimer(){
          // when click to indicator or controls button
          // stop timer
          clearInterval(timer);
          // then started again timer
          timer=setInterval(autoPlay,8000);
       }

      function autoPlay(){
          nextSlide();
          updateCircleIndicator();
      }

      let timer=setInterval(autoPlay,8000);
    }
}
MainSlider();

// --- auth window ---
function authWindow(){
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
  }

  function showRegister() {
      blockLogin?.classList.remove("auth__content--active");
      blockRegister?.classList.add("auth__content--active");
  }

  function showForgotten() {
      blockLogin?.classList.remove("auth__content--active");
      blockForgotten?.classList.add("auth__content--active");
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

// --- class re-bind after ajax ---
$(document).ajaxComplete(function refreshAuth(){
    authWindow();
});

// --- ajax initialization ---
$(function () {
    $.nette.init();
});
