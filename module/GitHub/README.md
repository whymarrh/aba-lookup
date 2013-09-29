GitHub API
==========

This folder contains a Zend Framework module for the GitHub API (v3). Currently, the ony method implemented is that to get the list of contributors.

Configuration
-------------

To set the username and repository (required) to pull information from the GitHub API, modify your `config/autoload/global.php` file to include the following:

    "GitHub" => [
        "user" => "", // Fill this in
        "repo" => "", // Fill this in
    ],

You will also need to add `GitHub` to the list of modules in your application configuration file (`config/application.config.php`).

View helper
-----------

The `avatars` view helper will return a string of HTML markup which includes the image tags for all the given contributors:

    echo $this->avatars($this->contributors);

Getting the contributors
------------------------

    $api = $this->serviceLocator('GitHub\Api');
    $contributors = $api->getContributors();
    // Or to get the list sorted by username
    $contributors = $api->getContributors($api::SORT_BY_USERNAME);
