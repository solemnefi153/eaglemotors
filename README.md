## Eagle Motors PHP 


# Environment Set Up 
If you are using XAMPP to host this application on your machine got to XAMPP > etc > httpd.conf and open that file. Scroll to the bottom of the file and paste these lines: 
```
#Set environment variables
SetEnv ENVIRONMENT development
SetEnv DATABASE_USERNAME <YOUR DATABASE USERNAME>
SetEnv DATABASE_USERNAME <YOUR DATABASE PASSWORD>
```
This will set the ENVIRONMENT variable in the Apache server used by XAMPP

If this application is hosted on heroku, go to  [heroku](https://dashboard.heroku.com/apps) and  login. Click on the name of your application and go to the Settings tab. Click on the button that says "Reveal Config Vars". 
In there  create a new variable with the Key "ENVIRONMENT" and  the value of "production". Remember to click on the add button.

