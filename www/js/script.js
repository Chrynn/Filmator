function navigationScroll() {
  
  var header = document.querySelector('.main-menu');
  if (header) {
    window.addEventListener('scroll', check);
  }

  function check() {
    var top = (window.pageYOffset || document.documentElement.scrollTop) - (document.documentElement.clientTop || 0);
    if (top > 0) {
      header.classList.add('scroll-active');
    } else {
      header.classList.remove('scroll-active');
    }
  }

}
navigationScroll();

function navHamburger() {
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
navHamburger();

window.addEventListener('scroll',reveal);

function reveal(){
  var reveals = document.querySelectorAll('.reveal');

  for(var i = 0; i < reveals.length; i++){
    // innerHeight - výška okna, window - výška okna prohlížeče
    var windowheight = window.innerHeight;
    // getBoundingClientRect - zjišťuje aktuální umíštění na webu, .top - odsazení v PX od vzrchu
    var revealtop = reveals[i].getBoundingClientRect().top;
    var revealpoint = 100; // o kolik chci mít posunuté při animaci

    if(revealtop < windowheight - revealpoint){
      reveals[i].classList.add('active');
    }
  }
}


window.addEventListener('scroll', revealOne);

function revealOne(){
  var reveals = document.querySelectorAll('.reg-column-one');

  for(var i = 0; i < reveals.length; i++){
    var windowheight = window.innerHeight;
    var revealtop = reveals[i].getBoundingClientRect().top;
    var revealpoint = 100;

  if(revealtop < windowheight - revealpoint){
    reveals[i].classList.add('reg-one-active');
  }
}
}

  window.addEventListener('scroll',revealTwo);

function revealTwo(){
  var reveals = document.querySelectorAll('.reg-column-two');

  for(var i = 0; i < reveals.length; i++){
    var windowheight = window.innerHeight;
    var revealtop = reveals[i].getBoundingClientRect().top;
    var revealpoint = 100;

  if(revealtop < windowheight - revealpoint){
    reveals[i].classList.add('reg-two-active');
  }
}
}

window.addEventListener('scroll',revealThree);

function revealThree(){
  var reveals = document.querySelectorAll('.reg-column-three');

  for(var i = 0; i < reveals.length; i++){
    var windowheight = window.innerHeight;
    var revealtop = reveals[i].getBoundingClientRect().top;
    var revealpoint = 100;

  if(revealtop < windowheight - revealpoint){
    reveals[i].classList.add('reg-three-active');
  }
}
}



function MainSlider() {
  
  var sliderExist = document.querySelector(".slider");

  if (sliderExist){
    const slides = document.querySelector(".block-content").children;
    const prev = document.querySelector(".prev");
    const next = document.querySelector(".next");
    const indicator = document.querySelector(".indicator");
    let index=0;

       prev.addEventListener("click",function(){
          prevSlide();
          updateCircleIndicator();
          resetTimer();
       })

       next.addEventListener("click",function(){
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
                      div.className="active";
                    }
                   indicator.appendChild(div);
            }
        }
        circleIndicator();

        function updateCircleIndicator(){
          for(let i=0; i<indicator.children.length; i++){
            indicator.children[i].classList.remove("active");
          }
          indicator.children[index].classList.add("active");
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
                  slides[i].classList.remove("active");
               }

           slides[index].classList.add("active");
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


function authWindow(){
  /*

    MAC VSCode shortcuts:
    - row duplication: option - shift - arrow
    - row moving: option - arrow

  */
  var overlay = document.querySelector(".auth-overlay");

  var buttonShowLogin = document.querySelector(".login-button");
  var buttonHideLogin = document.querySelector(".hide-login");
  var buttonHideRegister = document.querySelector(".hide-register");
  var buttonHideForgotten = document.querySelector(".hide-forgotten");

  var blockLogin = document.querySelector(".block-login");
  var blockRegister = document.querySelector(".block-register");
  var blockForgotten = document.querySelector(".block-forgotten");

  var actionLogin = document.querySelector(".action-login");
  var actionRegister = document.querySelector(".action-register");
  var actionForgotten = document.querySelector(".action-forgotten");
  var actionLoginForgotten = document.querySelector(".action-login-forgotten");

  // show overlay (show login - default)
  buttonShowLogin.addEventListener("click", () => {
    overlay.classList.remove("hidden");
    blockLogin.classList.remove("hidden");
  });
  // show register (from login)
  actionRegister.addEventListener("click", () => {
    blockLogin.classList.add("hidden");
    blockRegister.classList.remove("hidden");
  });
  // show login (from register)
  actionLogin.addEventListener("click", () => {
    blockLogin.classList.remove("hidden");
    blockRegister.classList.add("hidden");
  });
  // show login (from forgotten)
  actionLoginForgotten.addEventListener("click", () => {
    blockLogin.classList.remove("hidden");
    blockForgotten.classList.add("hidden");
  });
  // show forgotten (from login)
  actionForgotten.addEventListener("click", () => {
    blockForgotten.classList.remove("hidden");
    blockLogin.classList.add("hidden");
  });
  // hide overlay (from login)
  buttonHideLogin.addEventListener("click", () => {
    overlay.classList.add("hidden");
    blockLogin.classList.add("hidden");
    blockRegister.classList.add("hidden");
    blockForgotten.classList.add("hidden");
  });
  // hide overlay (from register)
  buttonHideRegister.addEventListener("click", () => {
    overlay.classList.add("hidden");
    blockLogin.classList.add("hidden");
    blockRegister.classList.add("hidden");
    blockForgotten.classList.add("hidden");
  });
  // hide overlay (from forgotten)
  buttonHideForgotten.addEventListener("click", () => {
    overlay.classList.add("hidden");
    blockLogin.classList.add("hidden");
    blockRegister.classList.add("hidden");
    blockForgotten.classList.add("hidden");
  });
}
authWindow();


// class re-bind after ajax
$(document).ajaxComplete(function refreshAuth(){
    authWindow();
});


// ajax initialization
$(function () {
    $.nette.init();
});
