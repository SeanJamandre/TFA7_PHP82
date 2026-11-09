# TFA7 Laravel POS

 Open http://127.0.0.1:8000 in your browser. VS Code Live Server does not run PHP or Laravel.



```powershell
composer install
Copy-Item .env.example .env
New-Item database/database.sqlite -ItemType File
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Use Copy-Item and New-Item only on the first setup; do not overwrite an existing .env or database. If storage:link fails on Windows, enable Windows Developer Mode or run the terminal with the permissions needed to create a symlink. If pictures do not load, check the link and APP_URL. Ensure PHP upload_max_filesize is at least 2M and post_max_size is larger, such as 8M.

## Pages

- /customers — list customers
- /customers/create — create a customer
- /customers/{id}/edit — edit a customer
- /users — list user accounts and avatars
- /users/create — create a user
- /users/{id}/edit — edit a user and upload an avatar

The sample data uses fictional customers and two sample user records. These are account records, not login credentials. This standalone classroom demo does not include login or a full sales/checkout module.

## Upload handling

Images must be JPG or PNG, at most 2 MB and at most 4096 pixels on either side. Intervention Image decodes, crops and re-encodes a 256 × 256 JPEG. Storage::disk('public') stores the result under a UUID filename. Only the relative path is saved. A blank upload keeps the current avatar. Replacement removes the previous file only after the record is saved. Blade escapes displayed values and forms use CSRF tokens.

The assignment requires an instructor-approved image package. This project uses Intervention Image; confirm that your instructor accepts it. No claim of approval is made here.

## Tests

```powershell
.\vendor\bin\phpunit
```

Or on macOS/Linux: `./vendor/bin/phpunit`. Tests cover customer validation and updates, duplicate usernames, avatar processing and replacement, oversized and invalid files, and placeholder display. PHP/Composer were unavailable in the build environment, so these runtime tests have not been executed. Run them after setup.

## Extending your TFA6 project

Your TFA6 source was not supplied, so this is a standalone implementation of the requested TFA7 features. To extend an existing project, back it up first. Merge controllers, requests, service, views, routes and assets. Keep your existing user model/authentication and database migrations. Add missing username/full_name fields using new migrations rather than recreating existing tables. Apply the separate avatar migration only if the column is missing. Keep your existing authentication/authorization on these management routes. Do not overwrite existing data or run migrate:fresh.

## Submission

The teacher requires BOTH a GitHub repository link and a hosted working application link. This ZIP does not create those links.

1. Run and test locally. Commit the raw project, migrations, seeders, README and generated composer.lock to your GitHub repository. Do not commit .env, vendor or the local database.
2. Deploy to a PHP 8.2+ Laravel-capable host with GD and persistent storage, using public/ as the web root. Install production dependencies with composer install --no-dev --optimize-autoloader. Set APP_ENV=production, APP_DEBUG=false, a unique APP_KEY, the real APP_URL and secure session cookies under HTTPS. Create the SQLite file on persistent storage, run php artisan migrate --force and php artisan storage:link. Give Laravel write access to storage/, bootstrap/cache/ and the database directory. Prevent script execution in uploaded storage.
3. This demo has public management routes. Add your TFA6 authentication/authorization or protect the entire demo with host-level access control before public deployment; share assessment access with your instructor. Use sample data only.
4. Test create, edit, validation and avatar upload on the hosted site, then submit the repository and application URLs.

## References

- https://laravel.com/docs/12.x/validation
- https://laravel.com/docs/12.x/filesystem
- https://image.intervention.io/v3
