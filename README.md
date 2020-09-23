Setup Instructions

RUN:

    mkdir {project}; cd {project};
    git clone {repo} .
    cp .env.example .env
    
END RUN:

*** 
update .env file with proper database credentials.
I'm using docker but...
for ex, if you had a service like MAMP:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=8889
    DB_DATABASE=guild
    DB_USERNAME=root
    DB_PASSWORD=root

***

RUN:

    composer install
    php artisan key:gen 
    php artisan migrate
    npm install && npm run dev
    
END RUN:


To authenticate from the API...
=======================================

method: POST

endpoint: 
{hostUrl}/api/login

headers: 

    {
        "Content-Type": "application/json",
        "Accept": "application/json",
    }

body: 

    {
        "email": {existing user's email},
        "password": "password"
    }


AUTH TOKEN SHOULD BE COPIED FROM RESPONSE. EXAMPLE:
=======================================

    {
        "user": {
            "id": 578,
            "first": "Jessie",
            "last": "Fritsch",
            "is_subscribed": 1,
            "email": "jed14@example.org",
            "email_verified_at": "2020-08-26T06:35:09.000000Z",
            "created_at": "2020-08-26T06:35:09.000000Z",
            "updated_at": "2020-08-26T06:35:09.000000Z"
        },
        "token": "116|Sqw5xMKeIBdg5GxH1Q0EeFQctLt6INS8FBqRg3spR6MvYXQLsd4IGLTTc3qnL8Xcyf0K9dVuERCjV7jn"
    }

=======================================


All subsequent API calls should contain the following header structure:
=======================================

    {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "Authorization": "Bearer {Authentication Token. no quotes}"
    }

=======================================

To query an application's total combined income...
=======================================

method: GET

endpoint: 

    {hostUrl}/api/application/{loan_application_id}

headers: 

    {
        "Content-Type": "application/json",
        "Accept": "application/json",
    }

To run unit tests:

RUN:
- php artisan test
