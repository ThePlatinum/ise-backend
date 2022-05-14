const toggle = document.getElementById("toggle");

toggle.addEventListener("click", () => {
  sidebar.classList.toggle("close");
})

// const navlinks = document.querySelectorAll('.nav-link ')
// for (let d = 0; d < navlinks.length; d++) {
//   navlinks[d].addEventListener(
//     "click",
//     function() {
//       for (let i = 0; i < navlinks.length; i++) {
//         navlinks[i].classList.remove("active");
//       }
//       this.classList.add("active");
//     }, true
//   );
// }