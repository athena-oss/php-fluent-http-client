# PHP Fluent Http Client

[![Build Status](https://travis-ci.org/athena-oss/php-fluent-http-client.svg?branch=master)](https://travis-ci.org/athena-oss/php-fluent-http-client)

PHP Fluent Http Client is a library for handling http requests and responses with a fluent api.

## How to install?

You have two options to use it on your project : 

* Installing via [composer](https://getcomposer.org/).

```
"require": {
    "athena-oss/php-fluent-http-client": "0.7.0",
 }
```

* Download the latest [release](https://github.com/athena-oss/php-fluent-http-client/releases/latest)

## Examples

### GET method with response assertions on : 

* header value
* content type
* status code

```php
$responseJson = (new HttpClient())->get('http://example.com')
            ->withHeader('name', 'value')
            ->withProxy('http://myproxy.com', 3128)
            ->then()
            ->assertThat()
            ->headerValueIsEqual('expected_header', 'expected_value')
            ->responseIsJson()
            ->statusCodeIs(200)
            ->retrieve()
            ->fromJson();
```

### POST method with authorization and assertion on status code :

```php
$responseString = (new HttpClient())->put('http://example.com')
            ->withUserAgent('my_user_agent_string')
            ->withDigestAuth('myusername', 'mypassword')
            ->withProxy('http://myproxy', 1234)
            ->withBody('my content', 'my content type')
            ->then()
            ->assertThat()
            ->statusCodeIs(201)
            ->retrieve()
            ->fromString();
```

## Contributing

Checkout our guidelines on how to contribute in [CONTRIBUTING.md](CONTRIBUTING.md).

## Versioning

Releases are managed using github's release feature. We use [Semantic Versioning](http://semver.org) for all
the releases. Every change made to the code base will be referred to in the release notes (except for
cleanups and refactorings).

## License

Licensed under the [Apache License Version 2.0 (APLv2)](LICENSE).
