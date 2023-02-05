const form = document.querySelector("form");
const load = document.querySelector(".ajax_load");

form.addEventListener("submit", (e) => {
  e.preventDefault();
  load.style.display = "flex";
  fetch(form.action, {
    method: "POST",
    body: new URLSearchParams({
      s: form[0].value,
    })
  })
    .then((res) => res.json())
    .then((res) => {
      load.style.display = "none";
      window.location.href = res.redirect;
    });
});
