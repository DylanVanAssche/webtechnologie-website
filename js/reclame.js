var reclame = ["50% korting op alle opties deze week!", "Gratis ruitenwissers bij een onderhoud!", "3 jaar extra garantie bij aankoop van een nieuwe wagen!"] // indien AJAX faalt

function haalReclameOp() {
	http = new XMLHttpRequest();
	http.open("GET", "data/reclame.xml");
	http.onreadystatechange = parse;
	http.send(null);
}

function parse() {
	if (http.readyState == 4) {
		var xml = http.responseXML;
		var r = xml.getElementsByTagName("reclame")[0].getElementsByTagName("aanbieding");
		reclame = []; // maak leeg
		for(var i=0; i < r.length; i++) {
			// XML parsen kan ook via de DOM tree
			reclame.push(r[i].getElementsByTagName("boodschap")[0].innerHTML);
		}
		console.log("Ontvangen via AJAX: " + reclame);
	}
}

function toonWillekeurigeReclame() {
	console.log("Reclame notificatie tonen...");
	
	// Browser support?
	if (!("Notification" in window)) {
		alert("Geen ondersteuning voor notificaties");
	}
	// Mogen we notificaties tonen?
	else if (Notification.permission === "granted") {
		tekst = reclame[Math.floor(Math.random()*reclame.length)];
		var notification = new Notification(tekst);
	}
	// Nee? Vraag permissie
	else if (Notification.permission !== "denied") {
		Notification.requestPermission(function (permission) {
			if (permission === "granted") {
				var notification = new Notification("Bedankt! We houden je op de hoogte van alle aanbiedingen.");
			}
		});
	}
}

// Haal de laatste aanbiedingen op van de server
haalReclameOp();
setInterval(toonWillekeurigeReclame, 10000);