const resize = function() {
  if (!intro.classList.contains("display") && window.screen.width >= 1400) {
    intro.querySelector("h2").innerHTML = "Intro";
  } else {
    intro.querySelector("h2").innerHTML = "Introduction";
  }
};

function display(article) {
  let frame = article.querySelector(".frame");

  console.log("and here too");

  if (frame.classList.contains("hide")) {
    const lastArticle = document.querySelector(".display");
    const lastFrame = document.querySelector(".frame:not(.hide)");

    if (lastArticle) {
      lastArticle.classList.remove("display");
      lastArticle.removeEventListener("click", lastArticleClickAction);
    }
    if (lastFrame) {
      lastFrame.classList.add("hide");
    }

    article.classList.add("display");
    frame.classList.remove("hide");

    const removeClose = document.querySelector(".close:not(.hide)");
    if (removeClose) {
      removeClose.classList.add("hide");
    }

    const hiddenCloseIcon = article.querySelector(".close.hide");
    if (hiddenCloseIcon) {
      hiddenCloseIcon.classList.remove("hide");
    }
    resize();

    const closeIcon = article.querySelector(".close");
    closeIcon.addEventListener("click", closeIconClickAction);
  }
}

function clickAction(article) {
  return function () {
    display(article);
    this.removeEventListener("click", clickAction);
  };
}

function closeIconClickAction() {
  display(intro);
  console.log("I'm here");
}

const introClickAction = clickAction(intro);
const article2ClickAction = clickAction(article2);
const article3ClickAction = clickAction(article3);
const article4ClickAction = clickAction(article4);
const article5ClickAction = clickAction(article5);
const article6ClickAction = clickAction(article6);

a1.addEventListener("click", introClickAction);
a2.addEventListener("click", article2ClickAction);
a3.addEventListener("click", article3ClickAction);
a4.addEventListener("click", article4ClickAction);
a5.addEventListener("click", article5ClickAction);
a6.addEventListener("click", article6ClickAction);

intro.addEventListener("click", introClickAction);
article2.addEventListener("click", article2ClickAction);
article3.addEventListener("click", article3ClickAction);
article4.addEventListener("click", article4ClickAction);
article5.addEventListener("click", article5ClickAction);
article6.addEventListener("click", article6ClickAction);

window.addEventListener("resize", resize);

const heart = document.querySelectorAll(".icon-heart");

heart.forEach((heartIcon) =>
  heartIcon.addEventListener("click", function () {
    heartIcon.classList.toggle("icon-like");
    console.log("LIKE");
  })
);