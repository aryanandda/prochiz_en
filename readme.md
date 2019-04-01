# Installation

Install composer packages :

```
composer install
```

Copy .env.example ke .env. Lalu generate app key :

```
php artisan key:generate
```

Link public storage :

```
php artisan storage:link
```

Install node modules :

```
npm install
```

Watch and compile frontend assets for production :

```
npm run watch
```

Compile frontend assets for production :

```
npm run prod
```

Note : 
* Because the frontend assets will be included in git, try to compile the assets for production only.
* If you are not changing anything in frontend assets, don't ever run the npm run. Because it will make a conflict in git.
