# REST API in PHP

This project is a simple REST API built with PHP, designed to manage products in a database. It uses MySQL as the database and Docker for containerization.

## Features

- CRUD operations for products (Create, Read, Update, Delete).
- Error handling for exceptions and invalid requests.
- Environment variable support for database configuration.
- Dockerized setup for easy deployment.

## Prerequisites

- Docker and Docker Compose installed on your system.
- PHP 8.2 or higher (if running locally without Docker).
- MySQL database.

## Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/daryl-maviance/rest_api_php.git
   cd rest_api_php
   ```

2. Start the Docker containers:
   ```bash
   docker-compose up -d
   ```

3. Access the API at `http://localhost:8080`.

## API Endpoints

### Product Endpoints

- **GET /product**: Retrieve all products.
- **GET /product/{id}**: Retrieve a specific product by ID.
- **POST /product**: Create a new product.
  - Request body (JSON):
    ```json
    {
      "name": "Product Name",
      "price": "Product Price"
    }
    ```
- **PUT /product/{id}**: Update an existing product.
  - Request body (JSON):
    ```json
    {
      "name": "Updated Name",
      "price": "Updated Price"
    }
    ```
- **PATCH /product/{id}**: Partially update a product.
  - Request body (JSON):
    ```json
    {
      "field": "value"
    }
    ```
- **DELETE /product/{id}**: Delete a product by ID.

## Environment Variables

The following environment variables are used for database configuration:

- `MYSQL_HOST`: Database host (default: `db`).
- `MYSQL_DATABASE`: Database name (default: `practice`).
- `MYSQL_USER`: Database user (default: `daryl`).
- `MYSQL_PASSWORD`: Database password (default: `daryl`).

## Project Structure

- `src/`: Contains the PHP source code.
- `index.php`: Entry point for the API.
- `Dockerfile`: Docker configuration for the PHP application.
- `docker-compose.yml`: Docker Compose configuration for the app and database.

