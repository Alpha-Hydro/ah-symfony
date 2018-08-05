Alpha-Hydro
===========
http://alpha-hydro.com
> PHP 7.1 / Symfony 4.1 / Doctrine 2.1 / MySql 5.1 / HTML(Twig 2.0) / CSS (Bootstrap 3, 4) / JavaScript (jQuery) / Saas / Webpack / Composer

#### Deploy production SSH
Переходим в корень папки сайта
> SSH на сайте уже должен быть настоен см. https://helpdesk.infobox.ru/PA/Knowledgebase/Article/View/601/0/ispolzovnie-sistemy-kontrolja-versijj-git-n-linux-khostinge
```cmd
cd webspace/httpdocs/test.alpha-hydro.com
git clone git@github.com:Alpha-Hydro/ah-symfony.git .
```
> ТОЧКА в конце ОБЯЗАТЕЛЬНА, указывает что мы клонируем репозоторий в текущий каталог.

т.к. настойки сервера не позволяют создать /.ssh в корне web пространства, на сообщение
```cmd
Could not create directory '/.ssh'.
Enter passphrase for key '.ssh/id_rsa':
```
вводим пароль от `id_rsa` (см. Clone, pull, fetch, push – по SSH: пароль в "Доступы для администратора сайта")

##### .env
* В корне создаем файл `.env`
* Копируем все из файла `.env.dist`
* Прописываем переменные `APP_ENV=prod, MAILER_URL=..., DATABASE_URL=...`

> т.к. опять же сервер на хостинге настоен через ж.... и "_По умолчанию в /usr/bin/php используется версия php 5.3.3.
> Для работы с кастомными версиями необходимо указывать прямой путь к интерпретатору нужной версии_", т.е. для работы с PHP, версии 7.1,
> нужно указывать `/opt/alt/php71/usr/bin/php`

Устанавливаем необходимые зависимости и оптимизируем для работы в production
```cmd
/opt/alt/php71/usr/bin/php bin/composer.phar update
/opt/alt/php71/usr/bin/php bin/composer.phar install --no-dev --optimize-autoloader
```

##### .htaccess
* В папке `./public` создаем файл `.htaccess`
* Стандартный файл для Symfony
```text
DirectoryIndex index.php

# By default, Apache does not evaluate symbolic links if you did not enable this
# feature in your server configuration. Uncomment the following line if you
# install assets as symlinks or if you experience problems related to symlinks
# when compiling LESS/Sass/CoffeScript assets.
# Options FollowSymlinks

<IfModule mod_negotiation.c>
    Options -MultiViews
</IfModule>

<IfModule mod_rewrite.c>
    RewriteEngine On

    RewriteCond %{REQUEST_URI}::$1 ^(/.+)/(.*)::\2$
    RewriteRule ^(.*) - [E=BASE:%1]

    RewriteCond %{HTTP:Authorization} .
    RewriteRule ^ - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    RewriteCond %{ENV:REDIRECT_STATUS} ^$
    RewriteRule ^index\.php(?:/(.*)|$) %{ENV:BASE}/$1 [R=301,L]

    RewriteCond %{REQUEST_FILENAME} -f
    RewriteRule ^ - [L]

    RewriteRule ^ %{ENV:BASE}/index.php [L]
</IfModule>

<IfModule !mod_rewrite.c>
    <IfModule mod_alias.c>
        RedirectMatch 307 ^/$ /index.php/
    </IfModule>
</IfModule>
```

#### Update production SSH
Сначала test.alpha-hydro.com

```cmd
cd webspace/httpdocs/test.alpha-hydro.com
git pull
```

Проверяем последние изменения структуры БД:
```cmd
/opt/alt/php71/usr/bin/php bin/console doctrine:migrations:status
```
Если есть изменения, применяем их
```cmd
/opt/alt/php71/usr/bin/php bin/console doctrine:migrations:migrate
```
Чистим кеш
```cmd
/opt/alt/php71/usr/bin/php bin/console cache:clear
```

> Если во время чистки кеша пошли ошибки или предупреждения: `/opt/alt/php71/usr/bin/php bin/composer.phar install --no-dev --optimize-autoloader`

Проверяем работу тестового сайта, если все ОК
```cmd
cd ../ah-symfony
git pull
Could not create directory '/.ssh'.
Enter passphrase for key '.ssh/id_rsa':
.....
/opt/alt/php71/usr/bin/php bin/console doctrine:migrations:status
/opt/alt/php71/usr/bin/php bin/console doctrine:migrations:migrate
/opt/alt/php71/usr/bin/php bin/console cache:clear
```
