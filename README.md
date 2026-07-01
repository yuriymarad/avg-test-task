## Design overview
This test task is implemented as if the code was taken from a part of a real project, separated by layers instead of being just like bunch of files in one folder. I think this is the best way to show how the code can be structured to be maintainable, extendable and testable.

There are two models: `Document` and `Tenant`. The `Tenant` model doesn't know anything about document validation and I think it should not. In real projects models often grow into large "God objects" with too many responsibilities and dependencies which makes them hard to maintain. I don't think that models must be fully anemic, but they should contain only behavior that belongs to their own responsibility.

The entry point is `App\Actions`. This class is responsible for one specific action and works as a use case. It doesb't contain the core business logic itself. This logic is placed in `App\Core` where reusable and domain related mechanisms are located.

`App\Core` contain the document validation mechanism. This mechanism doesn't know anything about the tenant. It works only with the relations that are part of its own logic: the document and the validation rules. Because of this it can later be reused for validating documents that are not necessarily related to the `Tenant` model.

For passing input data, I use DTOs in `App\Data`. This helps keep the input data consistent, validate it in one place and keep the responsibility clear.
I also use a few value objects `App\Value` for things that have domain meaning and to avoid primitive obsession across code.

Regarding edge cases for validation, I decided to keep the checks simple. Of course outside of the test task these checks would most likely be more complex, with different scenarios and probably a separate detailed specification.

Also regarding Pest tests, in the scope of this test task I wrote Pest tests only for the core validator class and one Rule class for demonstration purposes.

## How to run

`composer install`

`php demo.php`

`composer test`
