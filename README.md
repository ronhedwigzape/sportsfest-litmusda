# sportsfest-litmusda

Literacy, Dance, Music, and Cheerdance Sportsfest-Foundation Tabulation System 

## Development Setup
Here are the steps to set up the development environment for this project:

1. Download and install
   [XAMPP](https://www.apachefriends.org/download.html)
   and [NodeJS](https://nodejs.org/en/),
   if you haven't already.

2. Start Apache and MySQL through XAMPP if not already running.

3. Clone or download this repository to your XAMPP **htdocs** folder.
   The final path should be `path_to/xampp/htdocs/sportsfest-litmusda`.

4. Copy [**`app/config/database.example.php`**](app/config/database.example.php)
   to **`app/config/database.php`**, then modify the database connection settings in the new file.

5. Open the terminal and navigate to the project directory **sportsfest-litmusda**.

6. Execute the following commands to install the required dependencies:
   ```sh
   npm install
   ```

7. Compile and run the development server with hot reloading:
   ```sh
   npm run dev
   ```

8. Inside [phpMyAdmin](http://localhost/phpmyadmin),
   create a MySQL database named `sportsfest-litmusda` and import [sportsfest-litmusda.sql](sportsfest-litmusda.sql) into it.

9. Open your web browser and access <http://localhost:5176/sportsfest-litmusda> to view the application.


## Backend Testing
This guide will walk you through the process of testing the backend models.

### Prerequisites
Before getting started, ensure that you have [**Composer**](https://getcomposer.org/download/) installed:

### Setup
Run the following command to install the required dependencies.
```shell
composer install
```
If this command does not work, try running `composer update` instead.

### Writing Tests
To write your tests, simply add your **Unit Tests** to the
[tests/backend/**unit**](tests/backend/unit) directory
and your ***Feature Tests*** to the
[tests/backend/**feature**](tests/backend/feature) directory.

### Running Tests
1. Open a terminal window and navigate to the root directory of the project.
2. Run the following command to execute your tests:
```shell
phpunit
```
If this command does not work, try running `vendor\bin\phpunit` instead.


## Production Deployment
Here's how to compile the project for production deployment:

1. Generate the public folder by running the following command:
   ```sh
   npm run build
   ```

2. Access the application by visiting `http://[host_name]/sportsfest-litmusda`,
   where `host_name` is the **IP address** or **host name** of the server in the network.
   For example:
     - <http://localhost/sportsfest-litmusda>
     - <http://192.168.1.99/sportsfest-litmusda>
