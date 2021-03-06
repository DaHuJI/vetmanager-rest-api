# vetmanager-rest-api

![GitHub CI](https://github.com/otis22/vetmanager-rest-api/workflows/CI/badge.svg)
[![Coverage Status](https://coveralls.io/repos/github/otis22/vetmanager-rest-api/badge.svg?branch=main)](https://coveralls.io/github/otis22/vetmanager-rest-api?branch=main)


Vetmanager - CRM for veterinary with REST API. vetmanager-rest-api is library will help work with them.


[vetmanager.ru](https://vetmanager.ru/)

[vetmanager REST API Docs](https://vetmanager.ru/knowledgebase/rest-api-osnovnaya-informatsia)

[vetmanager REST API in Postman](https://god.postman.co/run-collection/64d692ca1ea129218ccb)

## Installation

```bash
composer require otis22/vetmanager-rest-api
```

## Usage 

* [For auth](#usage-for-auth)
    1. [Api key auth](#api-key-auth)
    1. [With custom timezone](#with-custom-timezone)
    1. [Token auth](#token-auth)
* [For create valid URI](#usage-for-create-valid-uri)
    1. [Only model](#only-model)
    1. [Model with particular id](#model-with-particular-id)
* [For filtering and sorting data](#usage-for-filtering-and-sorting)  
    1. [Filter example](#how-to-use-filters)
    1. [Full available filter list](#full-filter-list)
    1. [Sorts example](#how-to-use-sorts)
    1. [Both example](#how-to-use-both-sorts-and-filters)

### Usage for auth
#### Api key auth
```php
$client = new GuzzleHttp\Client(['base_uri' => 'http://some.vetmanager.ru']);

$authHeaders = new Otis22\VetmanagerRestApi\Headers\WithAuth(
    new \Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey(
        new \Otis22\VetmanagerRestApi\Headers\Auth\ApiKey('test-key')
    )
);

$client->request(
    'GET',
    '/rest/api/user/1',
    ['headers' => $authHeaders->asKeyValue()]
);    
```
or with function 
```php
$authHeaders = Otis22\VetmanagerRestApi\byApiKey('test-key');
# use this after ['headers' => $authHeaders->asKeyValue()]
```
#### With custom timezone
```php
$client = new GuzzleHttp\Client(['base_uri' => 'http://some.vetmanager.ru']);

$myHeaders = [
    'X-REST-TIME-ZONE' => '+02:00'
];
$allHeaders = new Otis22\VetmanagerRestApi\Headers\WithAuthAndParams(
    new \Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey(
        new \Otis22\VetmanagerRestApi\Headers\Auth\ApiKey('test-key')
    ),
    $myHeaders  
);

$client->request(
    'GET',
    '/rest/api/user/1',
    ['headers' => $allHeaders->asKeyValue()]
);    
```
#### Token auth
```php
$client = new GuzzleHttp\Client(['base_uri' => 'http://some.vetmanager.ru']);

$authHeaders = new Otis22\VetmanagerRestApi\Headers\WithAuth(
    new \Otis22\VetmanagerRestApi\Headers\Auth\ByToken(
        new \Otis22\VetmanagerToken\Credentials\AppName("myapp"),
        new \Otis22\VetmanagerToken\Token\Concrete("mytoken")
    )
);

$client->request(
    'GET',
    '/rest/api/user/1',
    ['headers' => $authHeaders->asKeyValue()]
); 
```

or with function
```php
$authHeaders = Otis22\VetmanagerRestApi\byToken('myapp', 'mytoken');
# use this after ['headers' => $authHeaders->asKeyValue()]
```

### Usage for create valid URI
#### Only model
```php
$client = new GuzzleHttp\Client(['base_uri' => 'http://some.vetmanager.ru']);

$uri = new \Otis22\VetmanagerRestApi\URI\OnlyModel(
    new \Otis22\VetmanagerRestApi\Model('invoice')
);

// request to /rest/api/invoice
$client->request('GET', $uri->asString()); 
 ```
or with function 
```php
$uriString = \Otis22\VetmanagerRestApi\uri('invoice')->asString();
```

#### Model with particular id
```php
$client = new GuzzleHttp\Client(['base_uri' => 'http://some.vetmanager.ru']);

$uri = new \Otis22\VetmanagerRestApi\URI\WithId(
    new \Otis22\VetmanagerRestApi\Model('invoice'),
    5
);

// request to /rest/api/invoice/5
$client->request('GET', $uri->asString()); 
```

or with function
```php
$uriString = \Otis22\VetmanagerRestApi\uri('invoice', 5)->asString();
```

### Usage for filtering and sorting
#### How to use Filters

```php
$client = new GuzzleHttp\Client(['base_uri' => 'http://some.vetmanager.ru']);

$filters = new \Otis22\VetmanagerRestApi\Query\Filters(
    new \Otis22\VetmanagerRestApi\Query\Filter\EqualTo(
        new \Otis22\VetmanagerRestApi\Model\Property('propertyName'),
        new \Otis22\VetmanagerRestApi\Query\Filter\Value\StringValue('propertyValue')
    )
    # ... we can use mach more filters new Filters($filterOne, $filterTwo, ... );
);

$client->request(
    'GET',
    '/rest/api/user/1',
    [
        'headers' => $authHeaders->asKeyValue(),
        'query' => $filters->asKeyValue()
    ]
); 
```
#### Full filter list
* Otis22\VetmanagerRestApi\Query\Filter\EqualTo - where property is equal to value
* Otis22\VetmanagerRestApi\Query\Filter\InArray - where property is in list
* Otis22\VetmanagerRestApi\Query\Filter\LessOrEqualThan - where property is less or equal than value
* Otis22\VetmanagerRestApi\Query\Filter\LessThan - where property is less than value
* Otis22\VetmanagerRestApi\Query\Filter\Like - where property is like value(for using MySQL LIKE)
* Otis22\VetmanagerRestApi\Query\Filter\MoreOrEqualThan - where property is more or equal than value
* Otis22\VetmanagerRestApi\Query\Filter\MoreThan - where property more than value
* Otis22\VetmanagerRestApi\Query\Filter\NotEqualTo - where propery is not equal to value
* Otis22\VetmanagerRestApi\Query\Filter\NotInArray - where property is not in list

#### How to use Sorts
```php
$client = new GuzzleHttp\Client(['base_uri' => 'http://some.vetmanager.ru']);

$sorts = new \Otis22\VetmanagerRestApi\Query\Sorts(
    new \Otis22\VetmanagerRestApi\Query\Sort\AscBy(
        new \Otis22\VetmanagerRestApi\Model\Property('propertyName')
    ), 
    new \Otis22\VetmanagerRestApi\Query\Sort\DescBy(
        new \Otis22\VetmanagerRestApi\Model\Property('property2Name')
    )
);

$client->request(
    'GET',
    '/rest/api/user/1',
    [
        'headers' => $authHeaders->asKeyValue(),
        'query' => $sorts->asKeyValue()
    ]
); 
```
#### How to use both Sorts and Filters
```php
$client = new GuzzleHttp\Client(['base_uri' => 'http://some.vetmanager.ru']);

$query = new \Otis22\VetmanagerRestApi\Query\Query(
    new \Otis22\VetmanagerRestApi\Query\Filters(),
    new \Otis22\VetmanagerRestApi\Query\Sorts()
);


$client->request(
    'GET',
    '/rest/api/user/1',
    [
        'headers' => $authHeaders->asKeyValue(),
        'query' => $query->asKeyValue()
    ]
); 
```

## Contributing

Local run in docker
```
cd docker
docker-compose up
```
now you can connect to container
```
docker exec -it vetmanager-rest-api /bin/bash
```
Run tests
```
#run all tests

composer check-all
```
