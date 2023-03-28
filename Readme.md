# Welcome!

## Let’s bootstrap the project

Some basic skeleton. We’ll use composer to manage autoloading and dependencies.

```
composer init
```

We’ll be doing some unit tests, so `phpunit` is a dev requirement, but let’s add
some static analysis and code style tools too. Add them to `scripts` section,
this way composer will be our task runner. 

Next: autoloading.

Since there are a lot of namespaces, let’s use an empty PSR-4 prefix for "src".

## Next we’re adding the existing sources

Just drop them in the src directory. It lights up like a christmas tree, but
that is ok for now, we’ll handle that in the next step.

## Provide some deps for `InventoryService`

Monolog and Guzzle are some fine implementations of the PSR standards, we will
use them. I could not find the Allegro SDK on packagist, so I will stub that
along with the Aterian dependencies.
