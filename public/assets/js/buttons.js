function hoverFunction(btn) {
    btn.style.boxShadow = "box-shadow: 0 80px 0 0  rgba(0,0,0,0.25) inset, 0 -80px 0 0  rgba(0,0,0,0.25) inset;"
}

var btn = document.getElementById("colegas");
btn.addEventListener("mouseenter", hoverFunction(btn));

