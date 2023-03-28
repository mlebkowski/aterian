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

## Quickly check what phpstan thinks

It complains about the logger assignment in the constructor, saying that the
readonly property is already assigned. It’s not, but let’s please it. Explicitly
using `else` is nothing that I commonly do either way, let’s replace it with
a simple ternary.

## All done, we can start refactoring

The code „compiles”, so we can start refactoring. But let’s have a safety net:
an e2e test. Or maybe a unit test? The service does rather a lot, so let’s treat
it as a whole system. The difference between unit and e2e is not that large, we
treat the SUT as a blackbox either way.

The first challenge is to understand the requirements. Fortunately, the code is
quite easy to understand. We have some inventory, we need to update product
quantities in different channels, depending if the product should be published
in each of them.

I guess we’ll test for that alone, anticipating that any other responsibilities
will be just implementation details.

For simple units the Arrange Act Assert test format is fine, but for brevity
we’ll use gherkin-like syntax here, using descriptions closer to entire use
cases. 

A lot is happening behind the scenes: Mothers and Stubs are created to help us
keep the test case cleaner and more readable.

Meanwhile, the `AllegroSellerAccounts` stub will be converted from an interface
(it was just a stub after all) to a concrete class. It seems it is just 
a collection, so let’s slap an `IteratorAggregate` on it and be done with it.

Running tests confirms that all is green. Thank you 🙇
