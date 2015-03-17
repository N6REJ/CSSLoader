# CSSLoader
Custom CSS Loader

Provides - the ability to load any css file in front-end, in flexible and dynamic ways without hacking the core or modifying the template css files.
How To Use
You can enter the filename in several ways, making your custom css safe from Joomla & template updates.
 

Use Folder: This will load EVERY .css file found in the path specified! NOTE: path must be preceded by a /
For example: if you have a folder in /media/custom/css it will look for the name of each css file and add it to the used .css files

Single File: It will look in the current template for the selected file and use ONLY that file

URL: Lastly if you wish you can use a reference a URL a remote location, and it will attempt to load it. Server settings on the remote site may prevent this however.

Debugging: The built in Debugger can help with troubleshooting any issue you might have. To activate it simply set the Show Errors parameter in advanced options to 'yes'.  It will then attempt to explain via front end error messages, any validation issues it is experiencing.

you may use as many of the methods as you want including all 3 if desired.
