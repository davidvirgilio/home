// Timeline Script


// Functions

// To expand he article element to fill the empty space when larger than 1400px.
const expand = function(){
    if(!articles[0].classList.contains("display") && window.screen.width >= 1400){
                buttons[0].innerHTML="Intro";
        }else{
        buttons[0].innerHTML="Introduction";
        }
}


/*This is my main function. It execute the following actions:
        1. Displaying the content selected.
        2. Hiding the rest.
        3. Showing the close button when the content is displayed.
*/
const display = function(article){
    let frame = article.querySelector(".frame");
    
    if(frame.classList.contains("hide")){
        
        const lastArticle = document.querySelector(".display");
        const lastFrame = document.querySelector(".frame:not(.hide)");
        
        if(lastArticle){
            lastArticle.classList.remove("display");
        }
        if(lastFrame){
            lastFrame.classList.add("hide");
        }
        
        article.classList.add("display");
        frame.classList.remove("hide");
        
        const removeClose = document.querySelector(".close:not(.hide)");
        if(removeClose){
            removeClose.classList.add("hide");
        }
        
        const hiddenCloseIcon = article.querySelector(".close.hide");
        if(hiddenCloseIcon){
            hiddenCloseIcon.classList.remove("hide");
        }
        expand();

        console.log("An article is been showing", article);
        
    }
};


// Listeners for the closing buttons.
const closeIcon = function(){
    let icon = document.querySelectorAll(".close");
    
    
    icon.forEach(close => {
        close.addEventListener("click", function(){
            display(articles[0])
            console.log("You close an article");
        })
    })
}

closeIcon();

const buttons = document.querySelectorAll(".articleButton");
const articles = document.querySelectorAll("article")
const navButtons = document.querySelectorAll("nav button");


//Listeners for the large buttons in the headings.
let cont = 0;
buttons.forEach(button=>{
    let article = articles[cont];
    button.addEventListener("click", function(){
        display(article)});
        cont++;
        console.log("Heading buttons ready!")
})


// Listeners for the navigation buttons on hte header.
cont = 0;
navButtons.forEach((navButton)=>{
    let article = articles[cont];
    navButton.addEventListener("click", function(){
        display(article)});
        cont++;
        console.log("Navigation buttons done.")
    })

window.addEventListener("resize",function(){
    expand()
})




// Like button

const heart = document.querySelectorAll(".icon-heart");

heart.forEach((heartIcon) => 
    heartIcon.addEventListener("click",function(){
        heartIcon.classList.toggle("icon-like");
        console.log("LIKE")

    }))