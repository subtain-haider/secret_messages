# Introduction
This Laravel application facilitates secure, encrypted messaging between users. It features encrypted messages that expire after a set period or after being read. This README provides detailed instructions for setting up and running the application using Docker or manual setup methods.

## Minimum Requirements
- PHP: ^8.2
- MySQL: ^8.0
- Composer
- Docker: (if using Docker for setup)
- Git

## Setup and Run Application
You can set up and run the application in one of two ways: using Docker or a manual setup process.

### Method 1: Using Docker
This method simplifies the setup process and manages dependencies through Docker and Docker Compose.

#### Steps:

##### Clone the Repository
```
git clone git@github.com:subtain-haider/secret_messages.git secret_messages
cd secret_messages
```

##### Run Docker Compose
```
docker compose up
```
This command builds the Docker environment, runs migrations, executes tests, and starts the server. The application will be accessible at [http://0.0.0.0:8000](http://0.0.0.0:8000)

### Method 2: Manual Setup
For those preferring a manual setup without Docker.

#### Steps:

##### Clone the Repository
```
git clone git@github.com:subtain-haider/secret_messages.git secret_messages
cd secret_messages
```

##### Configure Environment
Copy the .env.example file to create a .env file:
```
cp .env.example .env
```
Open the .env file and adjust the database credentials and any other environment-specific settings.

##### Install Dependencies
```
composer install
```

##### Generate Application Key
```
php artisan key:generate
```

##### Running Migrations
```
php artisan migrate
```
This command sets up your database schema.

##### Run the Application
```
php artisan serve
```
This will start the Laravel development server, typically accessible at [http://127.0.0.1:8000](http://127.0.0.1:8000)

### Important Commands


##### Running Tests
```
./vendor/bin/phpunit
```
Use this command to run the PHPUnit tests and ensure all components are functioning correctly.

## Notes
- Ensure that all required PHP extensions are installed. For manual setup, you might need to install extensions like PHP GD, mbstring, and others depending on your PHP environment.
- When using Docker, the docker compose up command handles all setup steps, including running migrations and tests. Check Docker logs for any setup or test execution errors.