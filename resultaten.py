#!/usr/bin/python
import sys

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

enquete_vraag_entry = """<td>{}</td>"""

#Print HTML headers
print begin_html

#Print header.php as body
with open("./header.php") as header:
    print(header.read())

#Start section
print(begin_section)

print("<h1>Resultaten enquete</h1>")

#Read the enquete.txt file
with open("./enquete/enquete.txt", "r") as enquete:
	questions = enquete.readlines()

with open("./tmp/enqueteres.txt", "r") as enquete:
	results = enquete.readlines()

#Print enquete as HTML table form
print("<table>")
for count, q in enumerate(questions):
	slecht = 0
	matig = 0
	neutraal = 0
	voldoende = 0
	goed = 0
	values = [0, 0, 0, 0, 0]
	colors = ["red", "orange", "grey", "DodgerBlue", "green"]
	for r in results:
		value = r.split(":")[count]
		value = int(value)
		values[value] = values[value] + 1
	print("<tr>")
	print(enquete_vraag_entry.format(q))
	for i in range(0,5):
		print(enquete_vraag_entry.format("""<div style="width:{}px; background-color:{}; text-align:center">{}</div>""".format(2.5*(values[i]+20), colors[i], values[i])))
	print("</tr>")
print("</table>")

#Close section
print(einde_section)

#Print HTML footers
print einde_html
