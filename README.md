# PHP User Management Project

This project is a PHP-based user management system that allows you to add, update, delete, and list users. It uses a MySQL database for storing user information and includes a web interface for interacting with the system.

## Features

- Add new users
- Update existing users
- Delete users
- List all users
- Form validation
- Error handling

## Requirements

- Composer
- Docker and Docker Compose

## Installation

1. **Clone the repository:**

   ```sh
   git clone https://github.com/georgyguei/php-user-management.git
   cd php-user-management
    ```
2. Install dependencies:
    ```sh
   composer install
    ```

3. Start Docker containers:
    ```sh
   docker-compose up -d
    ```

4. Set up the database:

    Access phpMyAdmin at [`http://localhost:8080`](http://localhost:8080) and log in with the following credentials:

    - Username: `root`
    - Password: `root`

    Copy and paste the following SQL script into the SQL tab in phpMyAdmin to create the database and table:

    ```sql
    CREATE DATABASE user_management;

    USE user_management;

    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE
    );
    ```

## Usage
1. Access the web interface:

    Open your browser and go to [`http://localhost`](http://localhost).

2. **Add**, **update**, **delete**, and **list** users:

    Use the web interface to manage users.

## Running Tests
Run tests locally by ensure the MySQL server is running on localhost and run:

```sh
composer test
```

## Database Hostname Configuration

In the [`UserManager.php`](src/models/UserManager.php) file, you can set the database hostname based on whether you are using Docker or not:
```php
<?php
public function setDB()
  {
    try {
      $hostname = "db"; // - // Use this hostname for the docker container
      $hostname = "127.0.0.1"; // Use this hostname for the unit tests
      (...)
    } catch (\PDOException $e) {
      (...)
    }
  }
```

## Project Structure

- [`src`](src) : Contains the PHP source code.
- [`tests`](tests) : Contains the PHPUnit test cases.
- [`docker-compose.yml`](docker-compose.yml) : Docker Compose configuration file.
- [`composer.json`](composer.json) : Composer configuration file.
- [`database.sql`](config/database.sql) :  SQL script for setting up the database.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request.

## License

This project is licensed under the MIT License. See the LICENSE file for details.