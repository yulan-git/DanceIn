let lien = document.getElementById("lien");
let divDates = document.getElementById("dates");

lien.addEventListener('click', function () {
    divContent = divDates.innerHTML;
    divDates.insertAdjacentHTML('afterend', divContent);
});
