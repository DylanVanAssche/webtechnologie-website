#!/usr/bin/python
begin_html = """content-type: text/html

<!DOCTYPE html>
<html lang="nl">
	<head>
		<script src="./js/html5.js"> </script>
		<link href="./css/stylesheet.css" rel="stylesheet" type="text/css">
		<title>Enquete</title>
	</head>
<body>
<!--Header-->
"""

einde_html = """</body></html>"""

begin_section = """<!--Content-->
	<section>"""
	
einde_section = """</section>"""

intro_section = """Beste klant, om onze dienstverlening te verbeteren hadden we graag u mening gehad over een aantal onderwerpen.
<ul>
	<li>Slecht</li>
	<li>Matig</li>
	<li>Neutraal</li>
	<li>Voldoende</li>
	<li>Zeer goed</li>
</ul>

"""


enquete_vraag_entry = """<td>{}</td>"""

#Print HTML headers
print(begin_html)

#Print header.php as body
with open("./header.php") as header:
    print(header.read())
	
#Read the enquete.txt file
with open("./enquete/enquete.txt", "r") as enquete:
	lines = enquete.readlines()

#Start section
print(begin_section)
print(intro_section)

#Print enquete as HTML table form
print("""<form action="./verwerk.py" method="post">""")
print("<table>")
for count, l in enumerate(lines):
	print("<tr>")
	print(enquete_vraag_entry.format(l))
	for i in range(0,5):
		print(enquete_vraag_entry.format("""<input type="radio" name="question{}" value="{}">""".format(str(count), str(i))))
	print("</tr>")
print("</table>")

#Print name text field
print("""<ul class="hidden">""")
print("""<li><label for="naam">Naam</label>""")
print("""<input type="text" name="naam"></li>""")

#Print car field
print("""<li><label for="merk">Merk</label>""")
print("""<input type="text" name="merk"></li>""")
print("""<li><label for="type">Type</label>""")
print("""<input type="text" name="type"></li>""")
print("""</ul>""")

#Print buttons
buttons = """
<div class="form-buttons">
	<input type="submit" value="Verstuur">
	<input type="reset" value="Reset">
</div>
"""
print(buttons)

#Close form
print("""</form>""")

#Close section
print(einde_section)
	
#Print HTML footers
print einde_html
