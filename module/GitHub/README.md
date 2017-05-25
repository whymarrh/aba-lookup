GitHub API
==========

This folder contains a Zend Framework module for the GitHub API (v3). Currently, the ony method implemented is that to get the list of contributors.

Adding the module to your application
-------------------------------------

To add the GitHub module to your application, merge the following with your `config/application.config.php` file:

    'modules' => [
        'GitHub,
    ],

Configuration
-------------

To set the username and repository (required) to pull information from the GitHub API, modify your `config/autoload/global.php` file to include the following:

    'GitHub' => [
        'user' => '', // Fill this in
        'repo' => '', // Fill this in
    ],

You will also need to add `GitHub` to the list of modules in your application configuration file (`config/application.config.php`).

Getting the contributors
------------------------

    $api = $this->getServiceLocator()->get('GitHub\Api');
    $contributors = $api->getContributors();
    // Or to get the list sorted by username
    $contributors = $api->getContributors($api::SORT_BY_USERNAME);

Avatars view helper
-------------------

The `avatars` view helper will return a string of HTML markup which includes the image tags for all the given contributors:

    echo $this->avatars($this->contributors);
    // Returns
    // <ul>
    //   <li><a><img></li>
    //   <li><a><img></li>
    // </ul>

To override the default class name for the `ul`, `contributors`, pass a second argument of type string to the invocation of `avatars` view helper.
