# Laravel starter-kit (with Passport and Swagger)
![screenshot](https://github.com/islem-kms/l5-passport-swagger-starter/blob/master/Screenshot-Kms-Starter.png)
### Installation

Clone or download the repository, open the project folder in terminal then run:
```
sudo chmod -R 777 storage
sudo chmod -R 777 bootstrap/cache
cp .env.example .env
composer install
php artisan key:generate
``` 
Create a database and set database connection in **.env** file
```
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=homestead
```
The Passport migrations will create the tables the application needs to store clients and access tokens
```
php artisan migrate
```
Before your application can issue tokens via the password grant, you will need to create a password grant client.
```
php artisan passport:client --password
```
This command generates the encryption keys Passport needs in order to generate access token. The generated keys are not typically kept in source control
```
php artisan passport:keys
```
Can enable automatic swagger documentation (views) generation in the **.env** file:
```
L5_SWAGGER_GENERATE_ALWAYS=true
```
Or run the generate command:
```
php artisan l5-swagger:generate
```
Browse (to http://service-url) **/api/documentation** for swagger documentation. 
If everything is working fine, you should see this screen:
![screenshot](https://github.com/islem-kms/l5-passport-swagger-starter/blob/master/Screenshot-Kms-Starter.png)