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
