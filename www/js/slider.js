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