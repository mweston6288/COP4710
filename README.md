# COP4710

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

