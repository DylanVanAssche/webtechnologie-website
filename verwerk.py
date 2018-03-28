#!/usr/local/bin/python
import sys
import os

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

#Print HTML headers
print begin_html

#Print header.php as body
with open("./header.php") as header:
    print(header.read())

#Start section
print(begin_section)

print("<h1>Bedankt voor het invullen van de enquete!</h1>")

#POST data
post = []
for line in sys.stdin:
	post.append(line.split("&"))

for item in post:
	entry = ""
	for data in item:
		key, value = data.split("=")
		entry =  "{}:{}".format(entry, value)
	entry = entry[1:] + "\n" # Remove ':' from the beginning of the entry and start new line
	if not os.path.exists("tmp"):
		os.makedirs("tmp")
	f = open("tmp/enqueteres.txt", "a")
	f.write(entry)
	f.close()

#Close section
print(einde_section)

#Print HTML footers
print einde_html
