# Eagle Motors PHP 

## XAMPP Set Up 

### Set up the application in XAMPP 
XAMPP is an application that will allow you to host this application with an Apache server on your machine. XAMPP will provide you with a database that you will use as well. There are many resources online to set up XAMPP. I would recommend the following videos to set up XAMPP.<br>
[Set up XAMPP on Mac](https://youtu.be/ZknM6ud1va0)<br>
[Set up XAMPP on Windows](https://youtu.be/f3sWx3EixPI)<br>
Credit to: Blaine Robertson

Once XAMPP has been setup go to XAMPP > htdocs and move the main folder of this application to that location. You can also clone this application directly to that location. 

### Set up the database in XAMPP
To create a new database in XAMPP go to http://localhost/phpmyadmin. In this portal click on the 'Databases' tab and create a new database called 'eaglemotors'. 

You will need to create a proxy user in  Maria DB. You can do that through the myadmin tool in XAMPP. This proxy user is necessary for the database connection from this application. Save the username and password that you create, you will need them to set up the environment variables.<br> 
[Set up a proxy user](https://youtu.be/9UxdVpgibWM)<br> 
Credit to: Blaine Robertson

Now that the database and the proxy user have been created, you need to fill your database with tables and data. Click on the database name and go to the 'Import' tab. Choose the 'xampp_eaglemotors_sharable_setup.sql' file, leave the default settings and click on 'Go'. After that, your database should be completely set up. 

### Set Up Environment Variables for XAMPP
If you are using XAMPP to host this application on your machine got to XAMPP > etc > httpd.conf and open that file. Scroll to the bottom of the file and paste these lines: 
```
#Set environment variables
SetEnv ENVIRONMENT development
SetEnv DATABASE_USERNAME <YOUR DATABASE USERNAME>
SetEnv DATABASE_USERNAME <YOUR DATABASE PASSWORD>
```
This will set the ENVIRONMENT variable in the Apache server used by XAMPP

## Heroku Set Up 

### Set up the application in Heroku 
The first thing that you need is to create an account with Heroku. Go to https://signup.heroku.com/login to create an account. Once you have created an account you will need to install the CLI on your computer. Go to this [link](https://devcenter.heroku.com/articles/heroku-cli) and follow the instructions to install the CLI on your computer. By the end of the instructions, you should be logged in through the Heroku CLI. <br>

The next step is to create a new application in Heroku. To do that open the terminal and go to the main file of this application. Run the following command in the command prompt:

```
heroku create <optional app name>
```

You do not need to include an app name.

Assuming that you have cloned this project, that git has been initiated, that there is at least one commit and that your current branch is called 'master',  push the code of this application  to Heroku by running the following command in the terminal: 

```
git push heroku master
```

### Set up the database in Heroku
To create a database in Heroku run this command on your terminal: 
```
heroku addons:create heroku-postgresql:hobby-dev
```
To fill your database with tables and data you will import the 'heroku_eaglemotors_sharable_setup.sql' into the database. You do that by running this on the terminal:
```
heroku pg:psql --app YOUR_APP_NAME_HERE < ./sql/heroku_eaglemotors_sharable_setup.sql
```

### Set The Environment Variables For Heroku
If this application is hosted on Heroku, go to  [heroku](https://dashboard.heroku.com/apps) and log in. Click on the name of your application and go to the Settings tab. Click on the button that says "Reveal Config Vars". Create a new variable with the Key "ENVIRONMENT" and the value of "production". Remember to click on the add button.

