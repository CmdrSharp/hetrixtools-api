# About
[![Latest Stable Version](https://poser.pugx.org/cmdrsharp/hetrixtools-api/v/stable)](https://packagist.org/packages/cmdrsharp/hetrixtools-api)
[![Build Status](https://travis-ci.org/CmdrSharp/hetrixtools-api.svg?branch=master)](https://travis-ci.org/CmdrSharp/hetrixtools-api)
[![StyleCI](https://styleci.io/repos/127169208/shield?branch=master)](https://styleci.io/repos/127169208)
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](./LICENSE)

This is an API for HetrixTools V2 API, aiming to make dealing with creating/updating and deleting monitors easier and more fluent.

# Requirements
* PHP 7.1 or higher

# Installation
Via composer
```bash
$ composer require cmdrsharp/hetrixtools-api
```

# Usage
Include the factory that you need (either Uptime or Blacklist), then spawn up an instance of the class, supplying your API Key as the only argument. Finally, build out your request.
```php
// Example Uptime Monitor creation (adding a ping monitor to 8.8.8.8)
use CmdrSharp\HetrixtoolsApi\Uptime\Factory as HetrixTools;

$monitor = new HetrixTools('myApiKey');

try {
	$result = $monitor->type('service')
	    ->name('Greatest Monitor')
	    ->target('8.8.8.8')
	    ->timeout(10)
	    ->frequency(1)
	    ->failsBeforeAlert(1)
	    ->public(false)
	    ->showTarget(false)
	    ->locations([
	        'dal' => true,
	        'msw' => true,
	        'nyc' => true
	    ])->create();
} catch(\Exception $e) {
	print($e->getMessage());
}

// Example Blacklist Monitor creation (adding a monitor to 192.168.0.0/24)
use CmdrSharp\HetrixtoolsApi\Blacklist\Factory as HetrixTools;

$monitor = new HetrixTools('myApiKey');

try {
	$result = $monitor->target('192.168.0.0/24')
	    ->label('Blacklist Monitor 1')
	    ->contact(1)
	    ->create();
} catch(\Exception $e) {
	print($e->getMessage());
}
```

The client returns a normal PSR ResponseInterface. This means you interact with the response as you would with any Guzzle response.
```php
$result->getStatusCode(); // 200
$result->getBody(); // {"status":"SUCCESS","monitor_id":"exampleMonitorId","action":"added"}
```

Now that we have created a monitor, we may want to modify it. This is almost identical to the regular request. For Uptime Monitors, the ID field must be supplied. For Blacklist Monitors, the Target field is required. Apart from that, include what you want to change.
```php
// Example for modifying Uptime Monitors
try {
	// Changing the target, category and locations
	$result = $monitor->id('exampleMonitorId')
	    ->target('8.8.4.4')
	    ->category('My awesome monitor')
	    ->locations([
	        'dal' => true,
	        'msw' => true,
	        'nyc' => true,
	        'mos' => true
	    ])->patch();

	// Changing the name only.
	$result = $monitor->id('exampleMonitorId')
		->name('New awesome monitor')
		->patch();

} catch(\Exception $e) {
	print($e->getMessage());
}

// Example for modifying Blacklist Monitors
try {
	$result = $monitor->target('192.168.0.0/24')
	    ->label('Blacklist Monitor 113')
	    ->contact(5)
	    ->patch();
} catch(\Exception $e) {
	print($e->getMessage());
}
```

The `CREATE`, `PATCH` and `DELETE` methods should always be at the end of the procedure call. All methods can be chained together. Some parameters are optional, and which ones are required will differ depending on what type of monitor you're creating. For a full overview of this, review the [HetrixTools API Documentation](https://gist.github.com/hetrixtools/3789e032af9224be2cdf49e557a7d484).

# Available methods
```php

// Common Methods (for both Blacklist and Uptime)
create();
patch();
delete();
target(String $target);

// Uptime Monitoring Methods
id(String $id);
type(String $type);
name(String $name);
timeout(int $timeout);
frequency(int $frequency);
failsBeforeAlert(int $fails);
failedLocations(int $failed);
contactList(int $contactList);
category(String $category);
alertAfter(int $time);
repeatTimes(int $times);
repeatEvery(int $every);
public(bool $public);
showTarget(bool $show);
verify_ssl_certificate(bool $verify);
verify_ssl_host(bool $verify);
locations(array $locations);
keyword(String $keyword);
maxRedirects(int $redirects);
port(int $port);
checkAuth(bool $check);
smtpUser(String $user);
smtpPass(String $pass);

// Blacklist Monitoring Methods
label(String $label);
contact(int $contact);
```

# Errors
Upon receiving input that fails validation, a `InvalidArgumentException` will be thrown. Upon receiving a response from the API which translates to an error, an `ErrorException` is thrown.
It is therefore recommended to run the operations within a try/catch statement.

# Test Suite
The included tests only verify that expected input/output to the interface work as intended. No tests are run toward the HetrixTools API itself, as this is currently not possible without making actual live changes.

# Versioning
This package follows [Explicit Versioning](https://github.com/exadra37-versioning/explicit-versioning).

# Authors
[CmdrSharp](https://github.com/CmdrSharp)

# Credits
Many thanks to [HetrixTools](https://hetrixtools.com), a service I fully endorse and recommend everyone to use for their uptime and blacklist monitoring needs!

# License
[The MIT License (MIT)](LICENSE)