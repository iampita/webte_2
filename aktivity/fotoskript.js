//skript pre pracu s fotogaleriou
var img = document.getElementById("bmodalimg");

function openModal(that) {
    console.log(that);
    document.getElementById('bmyModal').style.display = "block";
    document.getElementById("bmySlides").style.display = "block";
    document.getElementById("bmodalimg").src = that;
}

function closeModal() {
    document.getElementById('bmyModal').style.display = "none";
}


