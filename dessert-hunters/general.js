const hide = function(element){
    element.classList.add('hidden');
}
const unhide = function(element){
    element.classList.remove('hidden');
}
const toggleElement = function(element){
    element.classList.toggle('hidden');
}

const nonVisible = function(element){
    element.classList.add('non-visible');
}
const visible = function(element){
    element.classList.remove('non-visible');
}



const filterBox = document.querySelector('aside:first-of-type>nav');
const filterArrow = document.querySelector('#filtering img');
const buttonMenu = document.querySelector('#buttonMenu');


if(buttonMenu){
    buttonMenu.addEventListener('click',function (e){
        e.preventDefault(e);
        toggleElement(menu);
    })
}

if(filterArrow){

let arrowActive = false;
let orientationScreen;

const arrowOrientation = function(){
    if(portrait && !arrowActive){
        filterArrow.style.transform = "rotate(0deg)";
    }else if(portrait && arrowActive){
        filterArrow.style.transform = "rotate(180deg)";
    }else if(!portrait && !arrowActive){
        filterArrow.style.transform = "rotate(-90deg)";
    }else if(!portrait && arrowActive){
        filterArrow.style.transform = "rotate(90deg)";
    }
}

const checkOrientation = function(){
    orientationScreen = screen.orientation.type;
    if(orientationScreen == "portrait-primary"){
        portrait = true;
    }else{
        portrait = false;
    }
    arrowOrientation();
}

checkOrientation();


screen.orientation.addEventListener('change',function(e){
    checkOrientation();
}) 

    filtering.addEventListener('click', function(e){
        e.preventDefault();
        toggleElement(filterBox);
        if(!filterBox.classList.contains('hidden')){
            arrowActive = true;
            arrowOrientation();
        }else{
            arrowActive = false;
            arrowOrientation();
    }})
}

const mascot =document.querySelector('#mascot');
const nextDialog =document.querySelector('#nextDialog');
const previousDialog =document.querySelector('#previousDialog');

if(mascot){
    mascot.addEventListener('click', function(){
        toggleElement(dialog);
    })
}

const changeP = document.querySelector('#dialog p');
const changeH3 = document.querySelector('#dialog h3');

if(changeP){
    const button = dialog.querySelector('.sign-in');
    nextDialog.addEventListener('click', function(){
        if(!button==0){
        unhide(button);
        }
        changeH3.innerHTML = "Join us for fun!";
        changeP.innerHTML = "Once you create an account, you'll unlock the cutest chance ever to leave reviews and answer a questionnaire, all for the most adorably sweeeeet rewards!"
        nonVisible(nextDialog);
        visible(previousDialog);
    })
    previousDialog.addEventListener('click', function(){
        if(!button==0){
            hide(button);
            }
        changeH3.innerHTML = "Welcome!";
        changeP.innerHTML = "Explore delish~ places in the Calgary Downtown. Select the ice cream cones on the map to discover the yummy desserts in the area.!"
        nonVisible(previousDialog);
        visible(nextDialog);
    })
}


const closeInfo = document.querySelector('#closeInfo');
let dialogContainer = window.parent.document.querySelector('#dialogContainer');

if(closeInfo){

    let video = document.querySelector('video');
    closeInfo.addEventListener('click',function(){
        hide(dialogContainer);
        if(video){
            video.pause();
        }
        dialogContainer.setAttribute('src','');

    })
}


const indicators = document.querySelectorAll('.indicator');

if(indicators){
    indicators.forEach(indicator=>{
        indicator.addEventListener("click", function(){
            let storeId = indicator.value;
            dialogContainer.setAttribute('src',`quick-view.php?id=${storeId}`);
            unhide(dialogContainer);
        })
    })
}

// ***** HOME PAGE *****
// Zoom in zoom out

const imageContainer = document.querySelector('#viewport');
if(imageContainer){
let image = map;
let dragging = false;
let x = 0;
let y = 0;
let offsetX = 0;
let offsetY = 0;
let scale = 1;
let cumulativeScale = 1;
console.log('Hello');

imageContainer.addEventListener('wheel', function (event) {
    event.preventDefault();
    scale += event.deltaY*-0.001;
    scale = Math.min(Math.max(0.5, scale),3)
    image.style.scale = `${scale}`;
})

const start = function (event) {
    event.preventDefault();
    // console.log("You're clicking");
    dragging = true;
    x = event.clientX - offsetX;
    y = event.clientY - offsetY;

}

const drag = function (event) {
    if (dragging) {
        offsetX = event.clientX - x;
        offsetY = event.clientY - y;
        image.style.transform = `translate(${offsetX}px,${offsetY}px)`;

        // console.log(`X = ${offsetX.toFixed(0)}, Y = ${offsetY.toFixed(0)}`);
    }
}
const end = function (event) {
    if (dragging) {
        dragging = false;
        // console.log("You're out")
    }
}

imageContainer.addEventListener('mousedown', function (event) {
    start(event);
})

imageContainer.addEventListener('mousemove', function (event) {
    drag(event);
})

document.addEventListener('mouseup', function (event) {
    end(event);
})

// touches
let initialDistance = 0;
let currentDistance = 0;
let isPinching = false;

const getDistance = function (touches) {
    var dx = touches[0].clientX - touches[1].clientX;
    var dy = touches[0].clientY - touches[1].clientY;
    return Math.sqrt(dx * dx + dy * dy);
}

imageContainer.addEventListener('touchstart', function (event) {

    if (event.touches.length === 2) {
        initialDistance = getDistance(event.touches);
        isPinching = true;
    } else if(event.touches.length === 1){
        let touch = event.touches[0];
        dragging = true;
        x = touch.clientX - offsetX;
        y = touch.clientY - offsetY;
    }
})

imageContainer.addEventListener('touchmove', function (event) {
    event.preventDefault();
    if (isPinching && event.touches.length === 2) {
            currentDistance = getDistance(event.touches);
            scale += (initialDistance - currentDistance)*-0.001;
            scale = Math.min(Math.max(0.5, scale),2)
            image.style.scale = `${scale}`;

    } else if (dragging && event.touches.length == 1) {
        let touch = event.touches[0];
        offsetX = touch.clientX - x;
        offsetY = touch.clientY - y;
        image.style.transform = `translate(${offsetX}px,${offsetY}px)`;
    }
})

document.addEventListener('touchend', function (event) {
    if (isPinching && event.touches.length < 2) {
        isPinching = false;
        initialDistance = 0;
        currentDistance = 0;
    } else if (dragging) {
        dragging = false;
        // console.log("You're out")
    }
})
}



const sortAll = document.querySelector('#sortAll');
const sortIceCream = document.querySelector('#sortIceCream');
const sortDrinks = document.querySelector('#sortDrinks');
const sortBakeries = document.querySelector('#sortBakeries');

if(sortAll){
    sortAll.addEventListener('click',function(e){
        indicators.forEach(element => {
            const ind = element.querySelector('img');
            ind.setAttribute('src','images/indicator.svg')
            visible(element);
        });
    })
}
if(sortIceCream){
    sortIceCream.addEventListener('click',function(e){
        indicators.forEach(element => {
            if(element.classList.contains('ice-cream')){
                const ind = element.querySelector('img');
                ind.setAttribute('src','images/icon-icecream.svg')
                visible(element);
            }else{
                nonVisible(element);
            }
        });
    })
}
if(sortDrinks){
    sortDrinks.addEventListener('click',function(e){
        indicators.forEach(element => {
            if(element.classList.contains('drinks')){
                const ind = element.querySelector('img');
                ind.setAttribute('src','images/icon-drink.svg')
                visible(element);
            }else{
                nonVisible(element);
            }
        });
    })
}
if(sortBakeries){
    sortBakeries.addEventListener('click',function(e){
        indicators.forEach(element => {
            if(element.classList.contains('bakery')){
                const ind = element.querySelector('img');
                ind.setAttribute('src','images/icon-cake.svg')
                visible(element);
            }else{
                nonVisible(element);
            }
        });
    })
}


const signIn = document.querySelectorAll('.sign-in');

if(signIn){
    signIn.forEach(element => {
        element.addEventListener('click',function(e){
            e.preventDefault();
            dialogContainer.setAttribute('src','sign-in.php');
            unhide(dialogContainer);
        })
    });
}


const stars = document.querySelectorAll('form .star');
const inputStars = document.querySelectorAll('main.store input[type="radio"]');

if(stars){
    inputStars.forEach(element => {
        element.addEventListener('change', function(e){
            let ratingValue = element.value;
            for (let index = 0; index < ratingValue; index++) {
                stars[index].style.background = `url('images/icon-star.svg')`;
                stars[index].style.backgroundSize= "contain";
                stars[index].style.backgroundRepeat= "no-repeat";
            }
            for(index = ratingValue; index < 5; index++){
                stars[index].style.background = `url('images/icon-star-empty.svg')`;
                stars[index].style.backgroundSize= "contain";
                stars[index].style.backgroundRepeat= "no-repeat";
            }
        })
    })
}


const submitReview = document.querySelector('#submitReview');
const reviewForm = document.querySelector('main.store section:last-of-type form');
const review = document.querySelector('#review');
const radioStars = document.querySelectorAll('main.store input[name="rate"]');
if(submitReview){
    reviewForm.addEventListener('submit',function(e){
        e.preventDefault();
        e.stopPropagation();
    })
    submitReview.addEventListener("click", (e)=>{
        e.preventDefault();
        let checked = false;
        radioStars.forEach(element => {
            if(element.checked){
                checked = true;
            }     
        });
        if(review.value && checked){
            unhide(dialogContainer);
            console.log(`You sent the form.`,reviewForm );
            reviewForm.submit();
        }
})}

const closeInfo2 = document.querySelector('#closeInfo2');

if(closeInfo2){

    closeInfo2.addEventListener('click',function(){
        parent.location.reload();

    })
}




let like = document.querySelector('main.store .title form input[type="checkbox"]');
let likeLabel = document.querySelector('main.store .heart-label');
let likeForm = document.querySelector('#heart');
if(like){
    likeForm.addEventListener('submit',function(e){
        e.preventDefault() ;
        e.stopPropagation();
    })
    like.addEventListener("change",function(e){
        if(likeForm){
            likeForm.submit();
        }
        likeLabel.classList.toggle('filled');          
    })
}
if(like==null && likeLabel){
    likeLabel.addEventListener('click',function(){
        this.classList.toggle('filled');
        window.open('warning.php','result');
        unhide(dialogContainer);
    })
}




const reviewsArray = document.querySelectorAll('.review-container');
const viewMore = document.querySelector('#viewMore');

if(viewMore){
    if(reviewsArray.length > 5){
        for (let index = 5; index < reviewsArray.length; index++) {
            hide(reviewsArray[index]);
        }
    }else{
        hide(viewMore);
    }
    viewMore.addEventListener('click',function(e){
        e.preventDefault();
        if(viewMore.innerHTML === "View more"){
            viewMore.innerHTML = 'View less';
        }else{
            viewMore.innerHTML = 'View more';
        }
        for (let index = 5; index < reviewsArray.length; index++) {
            reviewsArray[index].classList.toggle('hidden');
        }
    })
}

const slides = document.querySelectorAll('.slides');
const previous = document.querySelector('.previous');
const next = document.querySelector('.next');

if(!slides.length == 0){

    const hideSlides = function(){
        slides.forEach(slide => {hide(slide)});
    }

    hideSlides();
    unhide(slides[0]);

    let cont=0;

    previous.addEventListener('click',function(e){
        cont--;
        if(cont<0){
            cont = slides.length-1;
        }
        hideSlides();
        unhide(slides[cont]);
    })
    next.addEventListener('click',function(e){
        cont++;
        if(cont == slides.length){
            cont = 0;
        }
        hideSlides();
        unhide(slides[cont]);
    })

}

const addButton = document.querySelector('#add');

if(addButton){
    addButton.addEventListener('click', function(e){
        unhide(dialogContainer);
    })
}

const warnings = document.querySelectorAll('.warnings');

if(!warnings.length == 0){
    warnings.forEach(warning =>{
        warning.addEventListener("click", function(e){
            unhide(dialogContainer);
        })
    })
}
