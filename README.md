# Simple-Rest-Api-Pure-PHP

A simple RESTful API PHP without Frameworks with vanilla PHP, to help you to understand  the concepts and the structure used. This way, you can use this example to develop your own API. 

## Installation

1. Clone/download this folder to your computer.
2. Save this folder in your Apache root directory.
3. Use rest_api.sql file to create your database.
4. Change the connection data in database/db.php

## How does it work

In this api, CURD operations are performed on the database. Token authorization is also used for Update, Create and Delete operations. To insert information in the database, update and delete, you need to send the Authorization token in your request header. You need to Login to get a valid token for 1 hour.

We have 6 methods of access the API:

1. (GET) Get all users http://localhost:8000/get_users.php
2. (GET) Get one user based on ID http://localhost:8000/get_user.php?id=userid
3. (POST) Login to get a Token http://localhost:8000/login.php
4. (POST) Create new user http://localhost:8000/add_user.php (Token required)
5. (POST) Update a user http://localhost:8000/update_user.php?id=userid (Token required)
6. (GET) Delete a user http://localhost:8000/delete_user.php?id=userid (Token required)


## Credits

- [Mojtaba Matboyi](https://github.com/mojipo)