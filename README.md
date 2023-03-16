# fobi

Tabulation System for Face of Beauty International

## Development Setup
Here are the steps to set up the development environment for this project:

1. Download and install
   [XAMPP](https://www.apachefriends.org/download.html)
   and [NodeJS](https://nodejs.org/en/),
   if you haven't already.

2. Start Apache and MySQL through XAMPP if not already running.

3. Clone or download this repository to your XAMPP **htdocs** folder.
   The final path should be `path_to/xampp/htdocs/fobi`.

4. Copy [**`app/config/database.example.php`**](app/config/database.example.php)
   to **`app/config/database.php`**, then modify the database connection settings in the new file.

5. Open the terminal and navigate to the project directory **fobi**.

6. Execute the following commands to install the required dependencies:
   ```sh
   npm install
   ```

7. Compile and run the development server with hot reloading:
   ```sh
   npm run dev
   ```

8. Inside [phpMyAdmin](http://localhost/phpmyadmin),
   create a MySQL database named `fobi` and import [fobi.sql](fobi.sql) into it.

9. Open your web browser and access <http://localhost:5177/fobi> to view the application.


## Production Deployment
Here's how to compile the project for production deployment:

1. Generate the public folder by running the following command:
   ```sh
   npm run build
   ```

2. Access the application by visiting `http://[host_name]/fobi`,
   where `host_name` is the **IP address** or **host name** of the server in the network.
   For example:
     - <http://localhost/fobi>
     - <http://192.168.1.99/fobi>
