

--Sixth query
UPDATE inventory 
SET invImage =  REPLACE(invImage, "/eaglemotors/", ""), 
	invThumbnail = REPLACE(invThumbnail, "phpmotors", "eaglemotors");

