
----
## Sections
----
* What is a Repository?
* What does this example do?
* Creating the repository / contract
* Creating the repository / contract
* Creating DoServiceA and DoServiceB
* Adding Unit Tests
* Run the tests

----
### What is a Repository?
-----

A repository is a design pattern that provides an abstraction layer between the application and the data source. It encapsulates the logic required to access and manipulate data, and provides a consistent interface for the application to work with regardless of the specific data source being used.

In the context of Laravel, repositories are often used to abstract away the details of working with different types of data sources such as databases, APIs, and third-party services. By defining a common interface for accessing data, repositories make it easy to switch out different data sources without having to modify the application code.

----
### What does this example do?
-----
In this base example, we're going to implement a ```User``` model where ```user.service.do()``` calls ```do()``` on either ```DoServiceA``` or ```DoServiceB``` of interface type ```DoService``` as a way to inject the dependency of either service. 

Since this demonstration is a base example, we're going to pass DoServiceA or DoServiceB in through the constructor of User as follows:

```php
$serviceA = new DoServiceA();
$user = new User($serviceA);
$user->doSomething(); // Calls DoServiceA::do()

$serviceB = new DoServiceB();
$user->setService($serviceB);
$user->doSomething(); // Calls DoServiceB::do()
```

> [ !! **warning** !! ]
> 
> It's not likely dependency would or even could be injected this way in a real application, so please keep this in mind.  Future branches may show more realistic implementations of this principle.

----
### Creating the repository / contract
-----
We'll start by creating the Repository, placed under the App/Contracts folder, where we're going to call DoServiceInterface.php

ensure an ```App\Contracts``` directory in the app folder exists or create it, and add DoServiceInterface.php to it

```bash
mkdir app/Contracts
touch app/Contracts/DoServiceInterface.php
```

Add the namespace and the do() method, set to return a string as follows

```php
<?php

namespace App\Contracts;

interface DoServiceInterface {

    /**
     * Minimal example of a method that returns a string
     * @return string
     */
    public function do(): string;
}
```

----
### Creating DoServiceA and DoServiceB
-----

Check for and / or create an ```App\Services``` directory in the app folder and add ```DoServiceA.php``` and ```DoServiceB.php```

```bash
mkdir app/Services
touch app/Services/DoServiceA.php
touch app/Services/DoServiceB.php
```

Add the following content to the respective files

```php
<?php

namespace App\Services;

use App\Contracts\DoServiceInterface;

class DoServiceA implements DoServiceInterface {

    /**
     * {@inheritDoc}
     * @return string the string 'DoServiceA' as the name of this service
     */
    public function do(): string {
        return 'DoServiceA';
    }
}
```

```php
<?php

namespace App\Services;

use App\Contracts\DoServiceInterface;

class DoServiceB implements DoServiceInterface {

    /**
     * {@inheritDoc}
     * @return string the string 'DoServiceB' as the name of this service
     */
    public function do(): string {
        return 'DoServiceA';
    }
}
```

----
### Adding Unit Tests
-----

```bash
php artisan make:test DoServiceTest --unit
```

Add the following to the test file you just created in the ```tests/Unit``` directory.

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\DoServiceA;
use App\Services\DoServiceB;

class DoServiceTest extends TestCase
{
    /** @test */
    public function test_do_service_a()
    {
        $doServiceA = new DoServiceA();
        $user = new User($doServiceA);
        $result = $doServiceA->do($user);
        $this->assertEquals('DoServiceA', $result);
    }

    /** @test */
    public function test_do_service_b()
    {
        $doServiceB = new DoServiceB();
        $user = new User($doServiceB);
        $result = $doServiceB->do($user);
        $this->assertEquals('DoServiceB', $result);
    }
}
```

----
### Run the tests
-----
```bash
php artisan test
```

In the above example, the ```User``` model has a ```$doService``` property that is injected via the constructor. The ```doSomething()``` method calls the ```do()``` method on the ```$doService``` implementation.

You can then create instances of the ```User``` model and inject either the ```DoServiceA``` or ```DoServiceB``` implementation as needed
