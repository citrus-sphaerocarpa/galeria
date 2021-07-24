[日本語](https://github.com/citrus-sphaerocarpa/galeria/blob/main/README_jp.md)

# galeria (Laravel photo sharing app)

## Features
- Sharing photos
- Tagging with autocomplete
- Commenting/Notes
- Likes
- Search/Filter
- Private message
- Notifications
- User profiles
- Localization(JP/EN)

## Demo site
You can login and explore galeria on our demo site.
Note: The Post/Edit/Delete functions and notification feature are disabled for this demo.  


Demo site URL: http://galeria-demo.herokuapp.com/  
ID(E-mail Address): articfox@example.com  
Password: ofvoIaPC

## Installation

**Make sure you have git installed locally on your computer first.**
1. Clone the repository.  
    ```
    git clone https://github.com/citrus-sphaerocarpa/galeria.git
    ```
2. `cd` to the project directory and install [Composer](https://getcomposer.org/) and [NPM](https://www.npmjs.com/).  
    ```
    composer install
    ```  
    ```
    npm install
    ```
3. Make a copy of the `.env.example` file  
    ```
    cp .env.example .env
    ```
4. Generate an app encryption key  
    ```
    php artisan key:generate
    ```
5. Edit `.env` and [set your Database](#Setting-Up-Database-(SQLite)) connection details.
6. Edit `.env` and [set your Pusher](#Setting-Up-Pusher) connection details.
7. Edit `.env` and [set your Mailtrap](#Setting-Up-Mailtrap) connection details.
8. Run the application and you can get the host address.
    ```
    php artisan serve
    ```
9. Copy and paste the address into your browser.  
<img src="https://i.gyazo.com/6cf6692db764ca6e2e6f62edc17739a4.png" width="500">  

## Setting Up Database (SQLite)
1. Create a `database.sqlite` file under the `/database` directory.
    ```
    cd database
    ```
    ```
    touch database.sqlite
    ```
2. Open the `.env` file that you copied and replace `mysql` with `sqlite` in the `DB_CONNECTION` environment variable. Then, comment out other `DB_*`variables like below.
    ```
    DB_CONNECTION=sqlite
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # DB_DATABASE=galeria
    # DB_USERNAME=root
    # DB_PASSWORD=
    ```
3. `cd` back to the project root and run the migration.
    ```
    cd ..
    ```
    ```
    php artisan migrate
    ```
If you want to use other Database like MySQL, read [the Laravel Documetation](https://laravel.com/docs/8.x/database).

## Setting Up Pusher

1. Create a [Pusher](https://pusher.com/) account if you have not already. Otherwise, log in to your account.
2. Create a Channels app as seen in the screenshot below. If you don't know how to choose a cluster, read [this](https://pusher.com/docs/channels/miscellaneous/clusters#how-should-i-choose-a-cluster?).  
    <img src="https://i.gyazo.com/0dbf47cfeb0c176a001a8cacb9ec2c16.png" width="400">  
3. Install the Pusher PHP SDK using Composer.  
    ```
    composer require pusher/pusher-php-server
    ```
4. Go back to Pusher and go to the “App Keys” page for that app, and make a note of your `app_id`, `key`, `secret` and `cluster`.
5. Open the `.env` file and  fill in your Pusher app credentials. Replace the `x`s with the keys that you noted in the previoust step.  
    ```
    PUSHER_APP_ID=xxxxxx
    PUSHER_APP_KEY=xxxxxxxxxxxxxxxxxxxx　　
    PUSHER_APP_SECRET=xxxxxxxxxxxxxxxxxxxx　　
    PUSHER_CLUSTER=xx
    ```
6. Install the dependencis through `NPM`.  
    ```
    npm install
    ```
7. Install Laravel Echo and pusher-js.
    ```
    npm install --save laravel-echo pusher-js
    ```
8. Make a copy of the `bootstrap_example.js` file under the `/resources/js` directory.
    ```
    cp .bootstrap_example.js .bootstrap.js
    ```
9. Open the `resources/js/bootstrap.js` file and update the `key` and `cluster` in the Laravel Echo section like below.
    ```
    import Echo from "laravel-echo"

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'xxxxxxxxxxxxxxxxxxxx',
        cluster: 'xx',
        encrypted: true
    });
    ```
## Setting Up MailTrap
1. Create a [Mailtrap](https://mailtrap.io/) account if you have not already. Otherwise, log in to your account.
2. Go to the “My Inbox” in the “Inboxes” page and choose the “SMTP Settings” tab.
3. Click the dropdown for “Integrations” and select “Laravel 7+”.
4. Make a note of your `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, and `MAIL_PASSWORD`.
5. Open the `.env` file and set up your mailing configuration like below.
    ```
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=xxxx
    MAIL_USERNAME=xxxxxxxxxxxxxx
    MAIL_PASSWORD=xxxxxxxxxxxxxx
    MAIL_ENCRYPTION=null
    # MAIL_FROM_ADDRESS=null
    # MAIL_FROM_NAME="${APP_NAME}"
    ```
