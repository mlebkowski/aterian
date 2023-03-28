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
