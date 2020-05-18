Реализация тестового задания. Простой REST CRUD на Symfony3

**Installation:**

```
git clone https://github.com/NotBadCode/Etest.git
cd Etest
composer install
```
Set DB config in ```config/db.php  ```
```
vendor/bin/doctrine orm:schema-tool:create
php ./console/generate_user.php
```
**Api:**  
Category:  
 * /category              GET       List of categories
 * /category{id}/products GET       List of products by category
 * /category              POST      Add category
 * /category/{id}         PUT/PATCH Update category
 * /category/{id}         DELETE    Delete category  
    
Post example:
```
    {
       "title": "title"
    }
```


Product:
 * /product      GET        List of products
 * /product      POST       Add product
 * /product/{id} PUT/PATCH  Update product
 * /product/{id} DELETE     Delete product
   
Post example:
```
    {
       "title": "title",
       "price": 128,
       "categories": [{"title": "categoryTitle"}
    }
```  

POST, PUT, PATCH, DELETE needs Bearer Authorization with user token.
