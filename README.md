# Slim4 Foto Kit

UNDER DEVELOPMENT

This is only demo app. It demonstrates data manipulation, CRUD operations, 
file uploading to external server.

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
