# COP4710
# Setup
## Insert default database
This application requires mysql
In a terminal, type the following command:
```
mysql -u <Your username> -p < path/to/this/folder/tables.sql
```

## dbLoginData
This application requires a file called dbLogiData.php.
In api/utility, make the file and insert the following code:
```php
<?php
	$hostname="host";
	$username="user";
	$password="password";
	$database="db";
?>
```
replace each value with the necessary values needed to access you mysql database.
## External Libraries
### Installation
#### Composer
* Paste the following script into the base application terminal:
```
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"
```

---

#### PHP Mailer
* Paste the following script into the base application terminal:
```
	./composer.phar require phpmailer/phpmailer
```
# Run the program
In the main folder, run the following command:
```
php -S localhost:8000
```

Then go to localhost:8000 on your browser

# Admin API
## Get All Admins
Gets usernames for all admins in db.
* **URL** : `/api/admin/get.php`
* **Auth Required**: NO
* **Data Required**: NO

### Success Response
* **Code**: `200 OK`
* **Content Examples**:
```json
{
	[
		{
			"username": "admin"
		},
		{
			"username": "superadmin"
		}
	]
}
```

### Error Response
* **Code**: `404 NOT FOUND`

## Search Admin
Gets usernames for all admins in db.
* **URL** : `/api/admin/search.php`
* **Auth Required**: NO
* **Data Required**: YES
```json
{
	"search": "your search here"
}
```

### Success Response
---
* **Code**: `200 OK`
* **Content Examples**:
On input of 'super' for 'search'
```json
{
	[
		{
			"username": "superadmin"
		}
	]
}
```

### Error Response
---
* **Code**: `404 NOT FOUND`

## Create Admin
Create an admin in database.
* **URL**: `/api/admin/create.php`
* **Auth Required**: NO
* **Data Required**: YES
```json
{
	"username": "username",
	"password": "password"
}
```

### Success Response
---
* **Code**: `201 CREATED`
### Error Response
---
* **Code**: `400 BAD REQUEST`
