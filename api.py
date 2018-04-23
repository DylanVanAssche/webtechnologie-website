#!/usr/local/bin/python

import json
colors = ["red", "orange", "grey", "DodgerBlue", "green"]
print("content-Type: application/json\n\n")
# Read enquete data
with open("./enquete/enquete.txt", "r") as enquete:
		questions = enquete.readlines()

with open("./tmp/enqueteres.txt", "r") as enquete:
		results = enquete.readlines()
		
data = {
		"results": [],
		"colors": [],
}	
for count, q in enumerate(questions):
		slecht = 0
		matig = 0
		neutraal = 0
		voldoende = 0
		goed = 0
		values = [0, 0, 0, 0, 0]
		for r in results:
				value = r.split(":")[count]
				value = int(value)
				values[value] = values[value] + 1
		data["results"].append({"values":values, "question": q})
data["colors"] = colors

print(json.dumps(data))
