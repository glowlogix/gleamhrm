# HRM - Human Resource Management
Laravel 5.6 version is used to create the HRM system. The purpose of this system is to effectively manage HR. Each module performs a separate function within the HRM that helps with information gathering or tracking. HRM modules can assist with:
1. Employee Management
2. Leave Management
3. Attendance Management
4. Team Management
5. Hiring Management

## Official Documentation of Framework

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contribution for the project

    1. Fork it
    2. Create your feature branch (git checkout -b my-new-feature)
    3. Make your changes
    4. Run the tests, adding new ones for your own code if necessary (phpunit)
    5. Commit your changes (git commit -am 'Added some feature')
    6. Push to the branch (git push origin my-new-feature)
    7. Create new Pull Request

## Project License

The project is available to be used freely for personal and educational purposes, cloning the project does not gives you any rights to sell it online/offline.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Requirement

1. PHP version 7.2+
2. [PHP Mcrypt](http://php.net/manual/en/book.mcrypt.php)
3. [PHP Mysql](http://php.net/manual/en/ref.pdo-mysql.php)
4. [Composer](https://getcomposer.org/)
5. [mbstring](http://php.net/manual/en/mbstring.installation.php)
6. [dom extention](http://php.net/manual/en/dom.setup.php)

## Installation

It is preferred to have git setup installed on your local system.

Once downloaded/cloned go to the project directory on terminal/command line and run composer install or composer.phar install

Once composer is installed, run migration: 

    php artisan migrate

After migration, run the database seeder: 

    php artisan db:seed
    
Once done migrating and seeding you will have default user:

    email: admin@glowlogix.com
    password: admin   

## Docker installation

1. Install Docker and Docker Compose for the operating system of your choice.
2. Get into your project directory (`cd hrm`)
3. Build the docker containers using `docker-compose build --no-cache --pull --force-rm`
4. Run the containers using `docker-compose up -d`
5. Access the PHP container using `docker exec -it hrm_phpfpm_1 bash`
6. Run `composer install` to install of the composer dependencies.
7. Rename the docker example `.env` file using `cp .env.docker.example .env`
8. Run `php artisan key:generate` to generate an application key (APP_KEY)
9. Run `php artisan migrate` to run all of the migration
10. Add `127.0.0.1 hrm.local:8080` to your `/etc/hosts` file
11. Access the site using `hrm.local:8080` in your browser