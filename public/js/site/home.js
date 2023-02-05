const el = document.querySelector("[data-go]");
const goto = document.querySelector(el.dataset.go).offsetTop;

if (el && goto) {
    el.addEventListener("click", (e) => {
        e.preventDefault();
        window.scroll({
            top: goto,
            behavior: "smooth",
        });
    });
}

function snowCanvas(obj) {
    const canvas = obj.el;

    canvas.style.backgroundColor = "rgba(0,0,0,0)";
    const fillStyle = "#821C87";
    const ctx = canvas.getContext("2d");

    const maxSpeed = 2;
    const minSpeed = 1;
    const count = 15;
    const rMax = 4;
    const rMin = 1;
    let W;
    let H;

    function setHeightWidth() {
        W = obj.width || window.innerWidth;
        H = obj.height || window.innerHeight;
        canvas.width = W;
        canvas.height = H;
    }

    setHeightWidth();

    window.onresize = setHeightWidth;

    function initialEverySnow() {
        return {
            x: Math.random() * W - rMax,
            y: Math.random() * H - rMax,
            r: Math.random() * (rMax - rMin) + rMin,
            s: Math.random() * (maxSpeed - minSpeed) + minSpeed,
            xChangeRate: Math.random() * 1.6 - 0.8,
        };
    }

    const snowGroup = [];
    let s;
    for (s = 0; s < count; s++) {
        snowGroup.push(initialEverySnow());
    }

    let delta = 0;
    function update() {
        delta += 0.01;
        let p;
        for (let i = 0; i < snowGroup.length; i++) {
            p = snowGroup[i];
            p.y += p.s;
            p.x += Math.sin(delta + p.xChangeRate) * p.xChangeRate;
            if (p.x > W + p.r || p.y > H + p.r || p.x < -p.r) {
                snowGroup[i] = initialEverySnow();
                const randomStartPostion = Math.ceil(Math.random() * 3);
                switch (randomStartPostion) {
                    case 1:
                        snowGroup[i].x = Math.random() * W;
                        snowGroup[i].y = -rMax;
                        break;
                    case 2:
                        snowGroup[i].x = -rMax;
                        snowGroup[i].y = Math.random() * H;
                        break;
                    case 3:
                        snowGroup[i].x = W + rMax;
                        snowGroup[i].y = Math.random() * H;
                        break;
                    default:
                        snowGroup[i].x = W + rMax;
                        snowGroup[i].y = Math.random() * H;
                        break;
                }
            }
        }
    }

    function draw() {
        ctx.clearRect(0, 0, W, H);
        ctx.beginPath();

        let p;
        for (let ix = 0; ix < snowGroup.length; ix++) {
            p = snowGroup[ix];
            ctx.fillStyle = fillStyle;
            ctx.moveTo(p.x, p.y);
            ctx.arc(p.x, p.y, p.r, 0, 2 * Math.PI);
        }
        ctx.fill();
        update();
    }

    setInterval(draw, 1000 / 60);
}

const snow = document.querySelectorAll(".snow");

if (snow) {
    snow.forEach((el) => {
        snowCanvas({
            el,
        });
    });
}

function typeWrite(e) {
    const textArray = e.innerHTML.split("");
    e.innerHTML = " ";
    textArray.forEach((l, i) => {
        setTimeout(() => {
            e.innerHTML += l;
        }, 80 * i);
    });
}

const phrase = document.querySelector(".headline");

if (phrase) {
    typeWrite(phrase);
}
