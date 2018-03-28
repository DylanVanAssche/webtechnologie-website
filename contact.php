<!DOCTYPE html>
<html lang="nl">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script src="./js/html5.js"> </script>
  <link href="./css/stylesheet.css" rel="stylesheet" type="text/css">
       <title>DDT Ok&eacute; Cars</title>
</head>
	<body>
		<!--Header-->
		<?php include("header.php")?>
		<section>
		<h1>Contact</h1>
        <p>
            U kan ons steeds contacteren via het onderstaande formulier. We streven er steeds naar u vraag zo snel mogelijk te behandelen.
        </p>
		 <form action="./contact.php" onsubmit="return validateForm();" id="contact-form">
			<fieldset>
				<legend>Aanspreking</legend>
				<input type="radio" name="gender" value="male" checked>Dhr.<br>
				<input type="radio" name="gender" value="female">Mevr.
			</fieldset>
			<fieldset>
				<legend>Naam</legend>
				<input type="text" name="name">
			</fieldset>
			<fieldset>
				<legend>Contactmogelijkheden</legend>
                <!--telephone-->
                <div class="form-wrapper">
                    <div class="form-check">
                        <input type="checkbox" name="telCheck">
                        <label for="telCheck">Tel/GSM</label>
                    </div>
                    <div class="form-field">
                        <input type="text" name="tel">
                    </div>
                </div>
                <!--email-->
                <div class="form-wrapper">
                    <div class="form-check">
                        <input type="checkbox" name="emailCheck">
                        <label for="emailCheck">E-Mail</label>
                    </div>
                    <div class="form-field">
                        <input type="text" name="email">
                    </div>
                </div>
                <!--post-->
                <div class="form-wrapper">
                    <div class="form-check">
                        <input type="checkbox" name="postCheck" value="male">
                        <label for="postCheck">Post</label>
                    </div>
                    <div class="form-field">
                        <ul class="hidden-ul">
    					    <li>
                                <label for="straat">Straat</label>
                                <input type="text" name="straat">
                            </li>
    					    <li>
                                <label for="postcode">Postcode</label>
                                <input type="text" name="postcode">
                            </li>
    					    <li>
                                <label for="gemeente">Gemeente</label>
                                <input type="text" name="gemeente">
                            </li>
    				    </ul>
                    </div>
                </div>
			</fieldset>
			<fieldset>
				<legend>Onderwerp</legend>
				 <select>
					<option value="aankoop">Aankoop nieuwe wagen</option>
					<option value="onderhoud">Onderhoud</option>
					<option value="schade">Schadegeval</option>
					<option value="tweedehands">Tweedehandswagen</option>
				</select>
			</fieldset>

            <fieldset>
				<legend>Uw vraag</legend>
				<textarea name="message" rows="10"></textarea>
			</fieldset>

			<div class="form-buttons">
				<input type="submit" value="Verstuur">
				<input type="reset" value="Reset">
			</div>
		</form>
	  </section>
	  <script>
		// HTML5: required doet exact hetzelfde
		var form = document.getElementById("contact-form");
		function validateForm() {
			var name = form.elements["name"].value;
			if(name == "") {
				alert("Naam is verplicht!");
				return false;
			}
			
			if(form.elements["telCheck"].checked && form.elements["tel"].value == "") {
				alert("Telefoon is verplicht!");
				return false;
			}
			
			if(form.elements["emailCheck"].checked && form.elements["email"].value == "") {
				alert("Email is verplicht!");
				return false;
			}
			
			var ingevuldPost = form.elements["straat"].value == "" && form.elements["postcode"].value == "" && form.elements["gemeente"].value == "";
			if(form.elements["postCheck"].checked && ingevuldPost) {
				alert("Adres is verplicht!");
				return false;
			}
			
			if(form.elements["message"].value == "") {
				alert("Wat is u vraag?");
				return false;
			}
		}
		</script>
  </body>
</html>
