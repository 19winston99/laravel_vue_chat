
Before starting the website, you need to perform some preliminary actions. Follow the following steps carefully:

1. Make sure you have installed the XAMPP software platform, which is necessary to use the PHP and Perl programming languages.

2. Open the console of your operating system (e.g., the command prompt in Windows) and enter the following commands:

composer i
npm i

These commands will install the necessary dependencies for the Laravel and Vue.js project.

3. Import the tables located in the "sql_tables" folder into your MySQL database. Make sure you have previously created an empty database for the project.

4. Register on the website https://pusher.com/ and follow these steps:

    - Click on the "CREATE APP" button.
    - Fill in the required fields, such as the application name, cluster (set to "eu"), frontend (set to "vuejs"), and backend (set to "laravel").
    - Go to the "APP KEYS" section and copy the following codes into the .env file of your Laravel project (from line 46 to line 52).
    - In line 18 of the .env file, set the value of BROADCAST_DRIVER to "pusher".

Once these preliminary actions are completed, you will be ready to use the real-time functionalities of the website.

There are two example users with whom you can access the site:

USER 1:

Email: admin@gmail.com
Password: asdasdasd

USER 2:

Email: potter@gmail.com
Password: asdasdasd

The website offers several features, including:

    - Real-time messaging.
    - Visual indication of "typing..." when a user is sending a message.
    - Ability to block and unblock other users.
    - Addition of emoticons.
    - Message deletion.
    - User search by name.
    - Display of notifications for various events.

By following these steps, you will be able to launch your Laravel 9 website with Vue.js and Pusher and utilize the real-time chat functionalities.