### Running project
* Clone repo
* Run ```php bin/console server:start``` to start development server (server:stop to stop if needed)
* Run ```composer install``` to install dependencies (composer update every other time we have dependencies updates)
* Run ```php bin/console doctrine:schema:update --force``` to execute migrations (each time we have migrations 
you run this command)

## Tests
If you want to test project run ```php bin/phpunit``` (add path to file or folder after command to execute 
only one test file or test folder)


### API usage
To get API results make GET request on localhost:{port}/score?term={term}
where {port} is port which listens to your server
and {term} is term you want to perform search.

## Example
```http:localhost:8000/score?term=php```

```http:localhost:8000/score?term=js```

```http:localhost:8000/score?term=symfony```

## Response
Expected response is JSON object with keys term and score.
Term is string representing term you searched and score
is integer from 0 to 10 which represents popularity of word.

e.g. ```{"term":"symfony","score":2.71}```

If you don't send term query param response will contain error key
which will have keys field with value term and status with value missing
which indicated that you have to send term query param.

e.g. ```{"errors":{"field":"term","status":"missing"}}```

If term can't be fetched at the moment you will receive response
with key errors which will have key content with value not found.

e.g. ```{"errors":{"content":"not found"}}```
