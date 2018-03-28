var slideIndex = 0;
var slides = ["./images/ddt-2.jpg", "./images/ddt-3.jpg", "./images/ddt-1.jpg"]

function nextSlide() {
	document.getElementById("img-1").src = slides[slideIndex];
	slideIndex++;
	console.log("Next slide");
	if(slideIndex >= slides.length) {
		slideIndex = 0;
	}
}

setInterval(nextSlide, 3333);