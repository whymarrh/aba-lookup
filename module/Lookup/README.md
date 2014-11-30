`Lookup` Module
===============

This folder contains the `Lookup` [Zend Framework module](http://framework.zend.com/manual/2.3/en/user-guide/modules.html).

Directory structure
-------------------

- `config/`: Module configuration
- `src/`: Module classes (e.g. controllers, forms)
- `test/`: All test related files

Model relationships and database schema
---------------------------------------

The relationship between the various models (or "entities") found under `src/Lookup/Entity` are designed around both the discussion in issue #94 as well as the actual schema (found in `$ABA_LOOKUP/scripts/schemata/*`). Some modifications have been made based on assumptions made for the first iteration of the application, for example:

1. A single user is associated with a single account even though the possibility exists for multiple users to associated with a single account.
2. A user has a single schedule created at the same time the user is created, where, again, the possibility exists for a user to have multiple schedules with different
3. The schedules are given random gibberish names (UUID to exact) as they are not currently exposed in the web app.
