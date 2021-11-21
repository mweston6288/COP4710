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