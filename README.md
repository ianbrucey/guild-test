Setup Instructions

RUN:
- mkdir {project}; cd {project};
- git clone {repo} .
END RUN:

*** update .env file with proper database credentials

RUN:
- composer install
- php artisan key:gen (if needed)
- npm install && npm run dev
- php artisan migrate
END RUN:


To authenticate from the API...
=======================================
method: POST

endpoint: {hostUrl}/api/login

headers: {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

body: {
    "email": {existing user's email},
    "password": "password"
}
=======================================



TOKEN SHOULD BE COPIED FROM RESPONSE. EXAMPLE:
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

To run unit tests:

RUN:
- php artisan test
