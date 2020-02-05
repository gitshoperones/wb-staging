=== Installation ===

1. Run composer Install
2. Run npm install -g yarn // in case yarn is not yet installed in your machine
3. Run yarn install
4. Configure .env file
   Make sure the following env attributes are configures properly:
   * APP_ENV
   * APP_URL
   * DB_CONNECTION=mysql
   * DB_HOST=127.0.0.1
   * DB_PORT=3306
   * DB_DATABASE=
   * DB_USERNAME=
   * DB_PASSWORD=

   Note: For security, do not remove .env from gitignore file to avoid adding
   committing sensitive info into the repository.

5. Run php artisan migrate:fresh --seed
6. Run npm run dev // or you may also run npm run watch

=== Troubleshooting ===
* If you are having problem with compiling after running npm run dev, run npm install node-sass
* If the admin dashboard has missing assets, run php artisan vendor:publish --provider="JeroenNoten\LaravelAdminLte\ServiceProvider" --tag=assets --force