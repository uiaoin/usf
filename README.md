## About
Usf is a PHP framework based on Symfony5.4, and continuous updating...

## Requirements
* PHP 7.2.5 or higher;
* Ctype、iconv、JSON、 PCRE、Session、SimpleXML and Tokenizer; 
* More detail see [Symfony Doc](https://symfony.com/doc/5.4/setup.html)

## Installation
```base
$ git clone git@github.com:uiaoin/usf.git
$ composer install -vvv
```
## Usage
If the application is simple, you can delete **ExampleBC** directory, then retain a directory between **Entity** and Domain;
Else, you can create other BC like OrderBC,ProductBC...

### doctrine
* After defined entity, you can execute this command  helps you synchronize ddl to database.
```bash
$ php bin/console make:migration # create migration
$ php bin/console doctrine:migrations:migrate # execute migration
```
