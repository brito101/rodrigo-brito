const img = document.querySelectorAll("img");
if (img) {
  img.forEach((i) => {
    i.classList.add("lazyload");
  });
}

const link = document.querySelectorAll(".htmlChars a");
if (link) {
  link.forEach((i) => {
    i.setAttribute("rel", "noreferrer");
    i.setAttribute("title", i.textContent);
  })
}
