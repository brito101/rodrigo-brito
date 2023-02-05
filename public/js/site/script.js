class SimpleAnime {
    constructor() {
        this.items = document.querySelectorAll("[data-anime]");
    }

    animateItems() {
        this.items.forEach((item) => {
            const time = Number(item.getAttribute("data-anime"));
            if (!Number.isNaN(time)) {
                setTimeout(() => {
                    item.classList.add("anime");
                }, time);
            }
        });
    }

    handleVisibility() {
        if (typeof document.visibilityState !== "undefined") {
            if (document.visibilityState === "visible") {
                this.animateItems();
            }
        } else {
            this.animateItems();
        }
    }

    init() {
        this.handleVisibility = this.handleVisibility.bind(this);
        this.handleVisibility();
        document.addEventListener("visibilitychange", this.handleVisibility);
    }
}

const anime = new SimpleAnime();
anime.init();

const button = document.querySelector(".smoothscroll-top");
if (button) {
    document.addEventListener("scroll", () => {
        if (window.pageYOffset > 100) {
            button.classList.add("show");
        } else {
            button.classList.remove("show");
        }
    });
    button.addEventListener("click", () => {
        window.scroll({
            top: 0,
            behavior: "smooth",
        });
    });
}

const cookieButton = document.querySelectorAll("#cookieConsent [data-action]");

function fadeOut(el) {
    let opacity = 1;
    const timer = setInterval(() => {
        if (opacity > 0) {
            el.style.opacity = opacity;
            opacity -= 0.1;
        } else {
            clearInterval(timer);
            el.remove();
        }
    }, 25);
}

if (cookieButton) {
    cookieButton.forEach((el) => {
        el.addEventListener("click", (e) => {
            e.preventDefault();
            fetch(el.dataset.action, {
                method: "POST",
                body: new URLSearchParams({
                    cookie: el.dataset.cookie,
                }),
            })
                .then((res) => res.json())
                .then((res) => {
                    fadeOut(el.parentElement);
                    if (res.gtmHead) {
                        document
                            .querySelector("head")
                            .insertAdjacentHTML("beforeend", res.gtmHead);
                    }
                    if (res.gtmBody) {
                        document
                            .querySelector("body")
                            .insertAdjacentHTML("afterbegin", res.gtmBody);
                    }
                });
        });
    });
}

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

const openButton = document.querySelector(".j_menu_mobile_open");
const closeButton = document.querySelector(".j_menu_mobile_close");
const menuMobile = document.querySelector(".j_menu_mobile_tab");

function animateOpen(el) {
    let position = 100;
    const timer = setInterval(() => {
        if (position > 70) {
            el.style.left = `${position}%`;
            position -= 5;
        } else {
            clearInterval(timer);
            el.style.left = "auto";
            el.style.right = "0";
        }
    }, 25);
}

function animateClose(el) {
    let position = 70;
    const timer = setInterval(() => {
        if (position <= 100) {
            el.style.left = `${position}%`;
            position += 5;
        } else {
            clearInterval(timer);
            el.style.right = "auto";
            el.style.display = "none";
        }
    }, 25);
}

// mobile menu open
openButton.addEventListener("click", (e) => {
    e.preventDefault();
    animateOpen(menuMobile);
});

function closeMenu() {
    animateClose(menuMobile);
}

document.querySelector("body").addEventListener("touchstart", (e) => {
    e.preventDefault();
    const button = e.target.classList.contains("j_menu_mobile_open");
    const item = e.target.offsetParent.classList.contains("j_menu_mobile_tab");
    const drop = e.target.offsetParent.classList.contains("dropdown-menu");
    const link = e.target.classList.contains("link");
    if (!button && !item && !drop && !link) {
        if (menuMobile.style.left === "auto") {
            closeMenu();
        }
    }
});

// mobile menu close
closeButton.addEventListener("click", (e) => {
    e.preventDefault();
    closeMenu();
});

if ("serviceWorker" in navigator) {
    navigator.serviceWorker
        .register("/sw.js", { scope: "./" })
        .then((registration) => {
            console.log("Service worker registrado com sucesso:", registration);
        })
        .catch((error) => {
            console.log("Service worker falhou ao registrar:", error);
        });
} else {
    console.log("Service workers não é suportado pelo navegador!");
}
