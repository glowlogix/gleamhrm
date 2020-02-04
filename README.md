# GleamHRM [![StyleCI](https://github.styleci.io/repos/121434773/shield?branch=master)](https://github.styleci.io/repos/121434773) [![GitHub Issues](https://img.shields.io/github/issues/glowlogix/gleamhrm)](#github-issues) [![GPLv3 License](https://img.shields.io/github/license/glowlogix/gleamhrm.svg)](https://github.com/glowlogix/gleamhrm/blob/master/LICENSE)

> Human Resource Management (HRM) System

Laravel 5.6 version is used to create the HRM system. The purpose of this system is to effectively manage HR functions. Each module performs a separate function within the HRM that helps with information gathering or tracking. HRM modules can assist with:

* Employee Management
* Leave Management
* Attendance Management
* Team Management
* Hiring Management

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

## License

The GleamHRM is open-sourced software licensed under the [GNU GPLv3](LICENSE).
