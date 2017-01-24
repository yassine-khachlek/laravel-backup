# Laravel Backup

This laravel package create a backup of your database. Backup files are stored in json files instead of sql for less size and easy access to the backuped data for any other treatments than importation in mysql database.

### Installation

Install wia composer:

```
composer require yk/laravel-backup
```

And add the service provider in config/app.php:

```php
Yk\LaravelBackup\LaravelBackupProvider::class,
```

### How to use

The package expose 2 commands.

To export you database use:

```
php artisan backup:export
```

To import the last backup use:

```
php artisan backup:import
```

## Note

You can found your backups in your application storage folder inside the backups folder.

When you use the importation command, all tables are erased, so only the imported backup data will be present.

## TODO
1. Change or make selectable, the number of records per json file.
2. Add files backup compression using gz or zip.
3. Add a command for files backup.
4. Some applications use more than database, so maybe should support for multiple databases backup.

## License

### GPLv2

Copyright (c) 2016 Yassine Khachlek <yassine.khachlek@gmail.com>

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.