1. copy ```.env.example``` to ```.env``` file and change DB connection to yours
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news_portal
DB_USERNAME=your_username
DB_PASSWORD=your_password```

2. ```php artisan key:generate```

3. ```php artisan migrate```

4. ```php artisan db:seed```

5. start server => ```php artisan serve```

Test runs after ```php artisan test``` command