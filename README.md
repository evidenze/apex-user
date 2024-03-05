# User Management System API

This API is responsible for managing user profiles within an application, including operations such as user registration, login, and CRUD operations on users.

## Installation

### Requirements

- PHP (>= 8.2.6)
- Composer
- MySQL or any other supported database
- Laravel Passport (for authentication)

1. Clone the repository:

```
git clone https://github.com/evidenze/apex-user.git
```

2. Navigate into the project directory:

```
cd apex-user
```

3. Install dependencies:

```
composer install
```

4. Copy the `.env.example` file to `.env`:

```
cp .env.example .env
```

5. Generate application key:

```
php artisan key:generate
```

6. Configure your database connection in the `.env` file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

## Database Migration

Run the database migrations to create the necessary tables:

```
php artisan migrate
```

## Generate Passport access token

Generate access token:

```
php artisan passport:install
```

## Starting the Server

Start the development server:

```
php artisan serve
```

The API will be available at `http://localhost:8000`.

## Running Tests

Update `.env.testing` with the test credentials. Run tests to ensure everything is working correctly: 

```
php artisan test
```

## API Endpoints

### User Registration

- **URL:** `/api/register`
- **Method:** POST
- **Request Body:**
  ```json
  {
      "name": "John Doe",
      "email": "john@example.com",
      "password": "password123",
      "role": "admin or user"
  }
  ```
- **Response:**
  ```json
  {
    "status": true,
    "message": "User registered successfully",
    "data": {
        "token": "access_token",
        "user": {
            "name": "Essien Ekanemmm",
            "email": "essien@gmail.cm",
            "role": "admin",
            "id": "dbbeda2a-e6ee-4583-bc3d-67e09d85f343",
            "updated_at": "2024-03-05T08:59:32.000000Z",
            "created_at": "2024-03-05T08:59:32.000000Z"
        }
    }
  }
  ```

### User Login

- **URL:** `/api/login`
- **Method:** POST
- **Request Body:**
  ```json
  {
      "email": "john@example.com",
      "password": "password123"
  }
  ```
- **Response:**
  ```json
  {
      "status": true,
      "message": "User logged successfully",
      "data": {
        "token": "access_token"
      }
  }
  ```

### User Logout

- **URL:** `/api/logout`
- **Method:** POST
- **Authorization Header:** Bearer access_token
- **Response:**
  ```json
  {
      "status": true,
      "message": "User logged out successfully",
      "data": null
  }
  ```

### User CRUD Operations

- **GET:** `/api/users`: Retrieve all users.
  - **Method:** GET
  - **Authorization Header:** Bearer access_token
  - **Description:** This endpoint retrieves a list of all users.
  - **Response:** Returns a JSON array containing user objects.
  ```json
    {
        "status": true,
        "message": "Users fetched successfully",
        "data": [
            {
                "id": "335e5508-a9b9-4127-a40f-ac05265a736e",
                "name": "Ekanem",
                "email": "essien@gmail.com",
                "role": "user",
                "created_at": "2024-03-04T12:00:00Z",
                "updated_at": "2024-03-04T12:00:00Z"
            },
            {
                "id": "335e5508-a9b9-4127-a40f-ac05265a736e",
                "name": "Essien ekanem",
                "email": "essien@gmail.com",
                "role": "admin",
                "created_at": "2024-03-04T12:00:00Z",
                "updated_at": "2024-03-04T12:00:00Z"
            }
        ]
    }
    ```

- **GET:** `/api/users/{id}`: Retrieve a specific user by ID.
  - **Method:** GET
  - **Authorization Header:** Bearer access_token
  - **Description:** This endpoint retrieves a specific user by their unique ID.
  - **Parameters:**
    - `id`: The ID of the user to retrieve.
  - **Response:** Returns a JSON object containing the user details if found, or a 404 error if the user does not exist.
  ```json
    {
        "status": true,
        "message": "User fetched successfully",
        "data": {
            "id": "335e5508-a9b9-4127-a40f-ac05265a736e",
            "name": "Essien Ekanem",
            "email": "essien@gmail.com",
            "role": "admin",
            "created_at": "2024-03-04T12:00:00Z",
            "updated_at": "2024-03-04T12:00:00Z"
        }
    }
    ```

- **POST:** `/api/users`: Create a new user.
  - **Method:** POST
  - **Authorization Header:** Bearer access_token
  - **Description:** This endpoint creates a new user with the provided details.
  - **Request Body:**
    ```json
    {
        "name": "Essien Ekanem",
        "email": "essien@gmail.com",
        "password": "password123",
        "role": "user"
    }
    ```
  - **Response:** Returns a JSON object containing the created user details, including the ID, name, email, and role.
  ```json
  {
    "status": true,
    "message": "User registered successfully",
    "data": {
        "token": "access_token",
        "user": {
            "name": "Essien Ekanemmm",
            "email": "essien@gmail.com",
            "role": "admin",
            "id": "dbbeda2a-e6ee-4583-bc3d-67e09d85f343",
            "updated_at": "2024-03-05T08:59:32.000000Z",
            "created_at": "2024-03-05T08:59:32.000000Z"
        }
    }
  }
  ```

- **PUT:** `/api/users/{id}`: Update an existing user by ID.
  - **Method:** PUT
  - **Authorization Header:** Bearer access_token
  - **Description:** This endpoint updates an existing user with the provided details.
  - **Parameters:**
    - `id`: The ID of the user to update.
  - **Request Body:**
    ```json
    {
        "name": "Updated Name",
        "email": "essien@gmail.com",
        "role": "admin"
    }
    ```
  - **Response:** Returns a JSON object containing the updated user details.
    ```json
    {
        "status": true,
        "message": "User updated successfully",
        "data": {
            "id": "335e5508-a9b9-4127-a40f-ac05265a736e",
            "name": "Jane Smith",
            "email": "essien@gmail.com",
            "role": "admin",
            "created_at": "2024-03-04T12:00:00Z",
            "updated_at": "2024-03-04T12:00:00Z"
        }
    }
    ```

- **DELETE:** `/api/users/{id}`: Delete a user by ID.
  - **Method:** DELETE
  - **Authorization Header:** Bearer access_token
  - **Description:** This endpoint deletes a user by their unique ID.
  - **Parameters:**
    - `id`: The ID of the user to delete.
  - **Response:** Returns a 200 Success response if the user is successfully deleted, or a 404 error if the user does not exist.
    ```json
    {
        "status": true,
        "message": "User deleted successfully",
        "data": null
    }
    ```