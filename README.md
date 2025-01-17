<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel API Documentation
This is a RESTful API built with Laravel that provides functionality for user authentication, profile management, post management, and token management.

## Table of Contents
- Features
- Installation
- API Endpoints
    - Open Routes
    - Protected Routes
- Authentication
- Example Responses
- Contributing

## Features
- User registration, verification, and login.
- Token-based authentication using JWT.
- Profile management.
- Post CRUD (Create, Read, Update, Delete) operations.
- Secure token refresh and logout functionality.
-logging of user activity

## Installation
- Clone the repository:
    git clone https://github.com/festorium/laravel-crud.git
    cd laravel-api

- Install dependencies:
    composer install

- Set up environment variables: Create a .env file in the root directory:
    cp .env.example .env

    Update the following variables:
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your_database_name
        DB_USERNAME=your_database_user
        DB_PASSWORD=your_database_password

    Generate the application key:
        php artisan key:generate
    
    Run migrations:
        php artisan migrate

    Start the server:
        php artisan serve

## API Endpoints
Open Routes
1. Register
    Endpoint: POST /register
    Description: Registers a new user.
    Request Body (JSON):
    {
        "name": "Festus Ojesanmi",
        "email": "john@example.com",
        "password": "password123",
        "password_confirmation": "password123"
    }

    Response:
    {
        "status": true,
        "message": "User registered successfully!",
        "data": {
            "id": 1,
            "name": "Festus Ojesanmi",
            "email": "john@example.com"
        }
    }

2. Verify Email
    Endpoint: POST /verify-user
    Description: Verifies a user's email.
    Request Body (JSON):
    {
        "email": "john@example.com",
        "verification_code": "123456"
    }

    Response:
    {
        "status": true,
        "message": "Email verified successfully!"
    }

3. Login
    Endpoint: POST /login
    Description: Authenticates a user and returns a token.
    Request Body (JSON):
    {
        "username": "john@example.com",
        "password": "password123"
    }

    Response:
    {
        "status": true,
        "message": "User logged in successfully",
        "data": {
            "token": "eyJhbGciOiJIUzI1NiIsInR...",
            "expires_in": 3600
        }
    }

## Protected Routes
Note: All protected routes require a Bearer Token in the Authorization header.

4. Get Profile
    Endpoint: GET /profile
    Description: Retrieves the authenticated user's profile.

    Response:
    {
        "status": true,
        "message": "Profile data retrieved successfully",
        "data": {
            "user": {
                "id": 1,
                "name": "Festus Ojesanmi",
                "email": "john@example.com"
            },
            "email": "john@example.com"
        }
    }

5. Refresh Token
    Endpoint: GET /refresh-token
    Description: Refreshes the authentication token.
    
    Response:
    {
        "status": true,
        "message": "Token refreshed successfully",
        "data": {
            "token": "eyJhbGciOiJIUzI1NiIsInR...",
            "expires_in": 3600
        }
    }

6. Logout
    Endpoint: GET /logout
    Description: Logs out the authenticated user.

    Response:
    {
        "status": true,
        "message": "User logged out successfully"
    }

7. CRUD Operations for Posts
1. Create a Post:

    Endpoint: POST /posts
    Request Body:
    {
        "title": "My First Post",
        "content": "This is the content of the post."
    }

    Response:
    {
        "status": true,
        "message": "Post created successfully",
        "data": {
            "id": 1,
            "title": "My First Post",
            "content": "This is the content of the post."
        }
    }

2. Get All Posts:

    Endpoint: GET /posts
    Response:
    {
        "status": true,
        "data": [
            {
                "id": 1,
                "title": "First Post",
                "content": "Content of the first post."
            },
            {
                "id": 2,
                "title": "Second Post",
                "content": "Content of the second post."
            }
        ]
    }

3. Get Post by ID:

    Endpoint: GET /posts/{id}
    Response:
    {
        "status": true,
        "data": {
            "id": 1,
            "title": "First Post",
            "content": "Content of the first post."
        }
    }

4. Update Post:

    Endpoint: PUT /posts/{id}
    Request Body:
    {
        "title": "Updated Title",
        "content": "Updated content."
    }

    Response:
    {
        "status": true,
        "message": "Post updated successfully",
        "data": {
            "id": 1,
            "title": "Updated Title",
            "content": "Updated content."
        }
    }

5. Delete Post:

    Endpoint: GET /logs
    Response:
    {
        "status": true,
        "data": [
            {
                "id": 5,
                "user_id": 1,
                "log_action": "DELETE_POST",
                "log_description": "User deleted post with ID: 3",
                "timestamp": "2025-01-17 15:47:07",
                "updated_at": "2025-01-17T15:47:07.000000Z",
                "created_at": "2025-01-17T15:47:07.000000Z",
                "user": {
                    "id": 1,
                    "first_name": "Festus",
                    "last_name": "Ojesanmi",
                    "username": "festorium",
                    "phone": "1234567890",
                    "user_id": "USER-678a6528c862c",
                    "address": "123 Main St",
                    "state": "CA",
                    "country": "USA",
                    "email": "festorium10@gmail.com",
                    "email_verification_code": "369349",
                    "is_verified": 0,
                    "last_login": "2025-01-17 15:33:23",
                    "created_at": "2025-01-17T14:11:53.000000Z",
                    "updated_at": "2025-01-17T15:33:23.000000Z"
                }
            }
        ]
    }

5. Get Logs:

    Endpoint: DELETE /posts/{id}
    Response:
    {
        "status": true,
        "message": "Post deleted successfully"
    }

## Authentication
All protected routes require a Bearer Token. Include the token in the Authorization header:
    Authorization: Bearer {your_token}

## Postman Documentation
You can find the complete API documentation, including detailed descriptions, request examples, and responses, in the Postman collection:

    Laravel API Postman Collection
        https://www.postman.com/dark-escape-433123-1/workspace/dev/collection/19478526-0af5cfdf-e2df-4cf6-a5da-0e826dd8a298?action=share&creator=19478526.

## Contributing
Contributions are welcome! To contribute:

- Fork the repository.
- Create a feature branch: git checkout -b my-feature.
- Commit your changes: git commit -m "Add a new feature".
- Push to the branch: git push origin my-feature.
- Create a pull request.


















