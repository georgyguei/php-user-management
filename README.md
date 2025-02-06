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

## Usage
1. Access the web interface:

Open your browser and go to [http://localhost](http://localhost).

2. **Add**, **update**, **delete**, and **list** users:

Use the web interface to manage users.

## Running Tests
Run tests locally by ensure the MySQL server is running on localhost and run:

```sh
composer test
```

## Project Structure
- [src](`src`) : Contains the PHP source code.
- [tests](`tests`) : Contains the PHPUnit test cases.
- [docker-compose.yml](`docker-compose.yml`) : Docker Compose configuration file.
- [composer.json](`composer.json`) : Composer configuration file.

## Contributing
Contributions are welcome! Please open an issue or submit a pull request.

## License
This project is licensed under the MIT License. See the LICENSE file for details.