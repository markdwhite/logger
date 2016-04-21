# Monolog Logger Extensions

Currently there is only one extension which injects the Class::function() into the log entry. Eg:

```
Log::debug('called');

[2016-04-21 23:51:42] testing.DEBUG: AdminController::home() called
```

# Laravel

This works with Laravel 5.1 (and maybe others). This can be accomplished by adding the following to AppServiceProvider:

```
use Monolog\Processor\IntrospectionProcessor;
use Somsip\Logger\Formatter\CallerInlineFormatter;
```

And in the register() method:
 
```
// Setup some custom logging
$monolog = Log::getMonolog();
// Change the default formatter
$monolog->getHandlers()[0]->setFormatter(new CallerInlineFormatter()); 
// Get all output from logger, but ignore references to non-app classes
$ignores = [
    'Writer',
    'Facade'
];
$monolog->pushProcessor(new IntrospectionProcessor(Logger::DEBUG, $ignores));
```
