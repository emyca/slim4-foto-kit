# Slim4 Foto Kit

UNDER DEVELOPMENT

This is only demo app. It is considered as a personal application. The app demonstrates data manipulation, CRUD operations, file uploading to external server.

The development of the application is inspired by examples of solutions
of Daniel Opitz ([Odan](https://odan.github.io/about.html)) and [Samuel Gfeller](https://samuel-gfeller.ch/docs). 


### Techstack

* [Slim (PHP micro framework).](https://www.slimframework.com/)
* [UIkit (Front-end framework).](https://getuikit.com/)
* [Twig (Template engine for PHP).](https://twig.symfony.com/)
* [MySQL.](https://www.mysql.com/)
* [jQuery.](https://jquery.com/)


### Database

This demo app uses MySQL RDBMS. SQL-query for DB table:

```sql
CREATE TABLE IF NOT EXISTS fotos
( id BIGINT NOT NULL AUTO_INCREMENT,
  img VARCHAR(255) NOT NULL,
  name VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);
```

### Admin Auth

Because of the app is considered to be as application for a single person administration, it uses JSON file (`private/admin_data.json`) to keep admin password and JWT secret key. That is the app doesn't need registration process. The admin password and JWT secret key are preinstaled during the app development.

Admin login is `admin@mail.com`. It's fiction for demo purposes.

Admin password is `abc123`, and hashed by https://www.php.net/manual/en/function.password-hash.php.

JWT secret key is made by https://www.php.net/manual/en/function.hash-hmac.php

```php
hash_hmac('sha256', 'Lorem ipsum dolor sit amet', 'onetwothree');
```

They are only for demo purposes and must be changed for use in real production app.
