function fadeIn(el) {
    let opacity = 0;
    const timer = setInterval(() => {
        if (opacity < 1) {
            el.style.opacity = opacity;
            opacity += 0.1;
        } else {
            clearInterval(timer);
        }
    }, 25);
}

function checkFades(element) {
    element.forEach((el) => {
        const wHeight = parseInt(0.75 * window.innerHeight, 10);
        if (wHeight >= el.getBoundingClientRect().top) {
            if (el.style.opacity === "0") {
                fadeIn(el);
            }
        }
    });
}

const fadeInScroll = document.querySelectorAll(".fadeInScrool");

if (fadeInScroll) {
    fadeInScroll.forEach((el) => {
        el.style.opacity = 0;
    });

    checkFades(fadeInScroll);

    window.addEventListener("scroll", () => {
        let timer;
        if (timer) clearTimeout(timer);
        timer = setTimeout(() => {
            checkFades(fadeInScroll);
            timer = null;
        }, 200);
    });
}
