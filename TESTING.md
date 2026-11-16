# How to run Tests & Code Quality checks

Grunt is no longer used in this project for testing and code quality checks. Instead, we have replaced it with npm scripts. The following table explains how to run each of the checks using npm instead of the previous Grunt commands

| Old Grunt Command | New npm Command | Description |
|---|---|---|
| `grunt phpcs` | `npm run phpcs` | Runs PHPCodeSniffer |
| `grunt phpunit` | `npm run phpunit` | Runs the PHPUnit test suite |
| `grunt coverage` | `npm run coverage` | Runs PHPUnit with HTML code coverage report |
| `grunt test` | `npm test` | Runs PHPCS followed by PHPUnit |

The output from these commands may look slightly different from the previous Grunt actions. For example, PHPCS is less verbose, but still provides all the information needed for testing. All commands must be executed in the same folder as the package.json file (aka the root folder of the repository). If you want to run them from within `src/php` instead, you can use `npm --prefix ../.. run <TEST>`
