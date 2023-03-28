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

## Looking at some static analysis

At this point `phpstan` thinks everything is fine-and-dandy. 
But I know it isn’t. Let’s turn up the nitpickingness to 11.
After adding some draconian rules it starts reporting 14 issues.
They are easy to fix, no worries.

Except for one, but it’s in the class under refactoring, 
so I’ll handle that later I guess.

## Add some assertions

Ok, I cheated a little. There were no assertions in the test, so let’s quickly
fix that with a spy. The SUT’s responsibility is to send a message (have a side
effect) to the AllegroSDK, so let’s verify that it does.

```
$ phpunit
F.
```

Shit. 

## Debugging

Fortunately it was just me not knowing PHP. After fixing the spy, the test
actually passes. 

## More test cases

Let’s handle other code paths and some edge cases. For this we will need another
spy for the website sdk-thing. Same stuff, different names. While we’re at it, 
let’s fix the bug in the Http Client interface (`request` vs `sendRequest`).

This introduces a dependency on Guzzle into our SUT, but just for a little 
while, this will be fixed soon.

## Starting the refactoring

The first obvious choice would be abstracting the sales channel handlers. 
So let’s do that. The e2e will not change that much, because we want to retain
the observable behaviour — so we’re basically expecting the same side effects
for the same context.

We are doing this in steps. We will plainly move the logic to separate classes. 
Look how the creation of SUT changes — the existing deps are now passed to
additional updaters, not much changes.

## Moving the guards

Each of the sales channel implementation will have a guard at the top.
We’ll exit early if the channel is not supported for a given product. We could
be tempted to extract this guard and use a decorator pattern, and have a factory
to put it all together… I will implement that just as a showcase, but it has its
downsides, and I think the final code would lack readability. If I made such 
decision IRL, I would leave a similar comment in review.

Let’s add some negative constraints, because we are not really testing whether 
website is updated for allegro products and vice versa. That’s great: test fails
before I decorate the website updater with a guard.

We’ve combined the updater logic with the guard decorator using a factory. It’s
placed in the `Application` layer, but we have a strong argument to claim that 
this is domain logic, but let’s not dive into that right now.

And finally, since the strong type on `WebsiteUpdater` is no longer valid 
(it’s wrapped with in a guard), let’s go all the way in and remove the allegro
updater requirement and expect a generic list of updaters.
