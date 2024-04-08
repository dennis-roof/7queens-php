# N Queens chess puzzle solver

This N Queens chess puzzle solver can provide all possible solutions involving placing a given number of queens on an NxN chess board so that no two queens threaten each other.

By default, the board displays all solutions to placing 7 queens on a 7x7 board. The solution can be shown either in browser on in console.

# Installation

Install dependencies using composer command: `composer install`

# Running in CLI

For PHP CLI, use the following command: `php index.php`

For running the solution in the browser, use the following command: `php -S localhost:8000 index.php`

PHP version requirement: 8.2+

Tested with PHP version 8.2.15

# Running in Docker

Using the Dockerfile in the root of this project, run these commands (might require sudo rights):
- `docker build -t queens-php .`
- `docker run -it --rm --name running-queens-php queens-php`

# Running Unit Tests

From the root of this project, run the following command: `./vendor/bin/phpunit`

# Example output

```
Solutions (0 is an empty spot, 1 is a queen piece):
---
1000000
0010000
0000100
0000001
0100000
0001000
0000010
---
Total of 40 unique solutions found for board size: 7!
```
