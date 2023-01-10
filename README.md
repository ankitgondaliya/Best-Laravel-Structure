# Laravel Structure

## 1. Download & Setup Project

Download the files above and place on your server.
OR clone project 
```
git clone https://gitlab.com/chiragjanjmera_tecocraft/laravel-structure.git
```

## 2. Composer
 project dependencies are managed through the PHP Composer tool. The first step is to install the depencencies by navigating into your project in terminal and typing this command:

```
composer install
```

## 3. Environment Files
This package ships with a .env.example file in the root of the project.

You must rename this file to just .env

[Note:] Make sure you have hidden files shown on your system.

## 4. Generate the Encryption key

The first thing we are going to do is set the key that Laravel will use when doing encryption.
```
php artisan key:generate
```
You should see a green message stating your key was successfully generated. As well as you should see the APP_KEY variable in your .env file reflected.

## 5. Create Database
You must create your database on your server and on your .env file update the following lines:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```
Change these lines to reflect your new database settings.


## 6. Migrate tables
It's time to see if your database credentials are correct.

We are going to run the built in migrations to create the database tables:
```
php artisan migrate
```
You should see a message for each table migrated, if you don't and see errors, than your credentials are most likely not correct.

## 6. Run Seeder

We are now going to set the administrator account information. To do this you need to navigate to this file and change the name/email/password of the Administrator account.

You can delete the other dummy users, but do not delete the administrator account or you will not be able to access the backend.

Now seed the database with:
```
php artisan db:seed
```
You should get a message for each file seeded, you should see the information in your database tables.

## 7. Storage:link
After your project is installed you must run this command to link your public storage folder for user avatar uploads:
```
php artisan storage:link
```

## 8. Setup Passport
After your project is installed you must run this command to generate keys for passport to authenticate the api user :
```
php artisan passport:install
```

## 9.Login
After your project is installed and you can access it in a browser, click the login button on the right of the navigation bar.

The administrator credentials are:

Username: admin@gmail.com
Password: 12345678

You will be automatically redirected to the backend. If you changed these values in the seeder prior, then obviously use the ones you updated to.

