# Place to Pay Online Payments Simulator

This laravel web application uses the test SOAP endpoint from Place to Play to simulate the Play to Pay online payments system.

### Dependencies:

- Composer


To run the web app:

1. Set the Database credentials in the ```.env``` file.
2. Open the Terminal.
3. Go to the app folder.
4. Run the migrations: ```php artisan migrate```
5. Start the app: ```php artisan serve```
6. Run the queue listener (for laravel Jobs [https://laravel.com/docs/5.7/queues](https://laravel.com/docs/5.7/queues ):
``` php artisan queue:listen```
7. Finally go to : [http://localhost:8000](http://localhost:8000)
