# Templates Plugin for CakePHP #

This plugin allows you to quickly bake your applications with collection-like operations over your models and high test coverage (100%) for all your baked code. Basically, this plugin include custom template for the bake code generator. It also provides a wizard which will help you on the choosing of the right options for your bake commands.

Generated code focuses on the "fat models" mantra, they will have most of the logic for handling your data, and sending messages back to the controller to do the flow control.

One can ask why would I need to test model CRUD code that is already checked with cake core tests.
Answer is simple. When you extend model features with callbacks and different behavior something unexpected can happen with model configurations and some of CRUD operations can be easily broken. Same with controller level tests.

## Installation ##

Drop the templates plugin folder into your app's plugins directory, or into the global plugins directory of your cake install. Optionally you can install this plugin as a git submodule.

    git submodule add git://github.com/CakeDC/templates.git plugins/templates

## Basic Usage ##

The most easy way of using this plugin is executing via command line the following line

	cake template

It will prompt you for the name of a model to start the process of baking code for it. The template shell will ask you several questions in order to customize final code for your app needs.

After the bake don't expect all generated tests will be ready to run. You will need some fixtures preparation and tests tuning. In most cases it won't take more than 2-3 minutes to have new model and controller with 100% code coverage.

## Introduce the AppTestCase library ##

This plugin introduce additional features into your application tests.
First of all it contains AppTestCase class that extends CakeTestCase with some nice features. Also it allows to solve them problem of adding new models into app without breaking model and controller level tests. Instead of defining list of fixtures in each test file it is now possible to define just the the test scope.
So, in test case file it is enough to define $plugin = 'app' for app level tests or $plugin = 'plugin_name' for plugin level tests.
The APP/tests/config/fixtures.php should looks like 

	$config = array(
		'app.article',
		'app.comment',
		'plugin.users.user');
		
The AppTestCase also introduces plugin fixtures dependency resolving.
To use it the APP/tests/config/dependent.php should looks like 

	$config = array(
		'friends', 'messages'); 
		
During development sometimes it is really useful to run just one test. User can use $_testsToRun array to list what test methods should be executed.

Also it provides several mock methods.
 
* AppMock::getTestModel - create a mock for a model.
* AppMock::getTestController - allow to create mocked controller object where introduced 		expectRedirect method. Together with expectRedirect necessary to use  expectExactRedirectCount at the end of tested method. Also exists expectRender, expectExactRender and expectSetAction, expectExactSetActionCount method pairs. 

Here is the sample of create mocked controller object.
	$this->Consoles = AppMock::getTestController('ConsolesController');

## Tests and fixtures conventions ##
		
Tests baked with templates plugin follow some important conventions.

Each fixture should contain at least one data record. As we use uuid as primary keys for all our models we use easy to read id keys. First record id should be named like 'article-1' or 'user-1'. So it is lower and dash delimited model name with -1 at end.
All tests are baked so that this record is used for testing different model and controller operations.
If slugs is used during the bake this field should contain 'first_article' or 'first_comment' on this fixture.
No other requirements exists.

Add and edit tests checks both valid and invalid user actions. To test invalid passed morel data we need to setup fixture record using unset of fixture fields.
So if Article.title is required and validation rule created for it then this field is good candidate to unset in second part of testAdd method. You just need to add "unset($data['Article']['title']);" to make this test pass. In generated test files such string exists both in testAdd and testEdit method but commented out. The reason for it is very simple - not all models have title field, and during the bake template have no information what fields are supposed to be required.

When fixture is configured, model test case is updated, the tests should be all green and show 100% code coverage.
In other case if some tests are failing then fixture is not set up correctly or something is missing in model class

By default you are required to add fixture name into APP/tests/config/fixtures.php file after the bake.

## Command line modifiers ##

 * -user UserModelName - generated model code contain userId parameter for all CRUD methods. Controller pass userId (as Auth->user('id') value) to the models.
 * -slug - make the generator do all model searches using a slug field instead of an id.
 * -noAppTestCase - generate test that extend CakeTestCase instead of AppTestCase.
 * -parent - introduce Parent - Child model structure into cakephp code.
 * -parentSlug - make the generator do all parent model searches using a slug field on controller index.
 * -subthemes - allow to inject additional features into the baked code. For example introduce Search capabilities

## Usage Example ##
    
The following lines will generate the code for Author model, it's associated controller and views.

    cake bake model Author                -theme cakedc -slug 
    cake bake controller Authors public   -theme cakedc -slug 
    cake bake view Authors                -theme cakedc -slug 

The -slug modifier will make the generator do all model searches using a slug field instead of an id. Additionally controller actions will take model slug as parameters and those will get propagated in links into the view templates,

If you have classic Parent - Child model structure you can execute the following commands

    cake bake model Article                  -theme cakedc -parent Author -parentSlug -appTestCase
    cake bake controller Article public     -theme cakedc -parent Author -parentSlug -appTestCase
    cake bake view Article                  -theme cakedc -parent Author -parentSlug -appTestCase

The previous commands will generate the code Article model using as a requisite the Author slug in function parameters.

### Integrating with Search plugin ###

CakeDC Search plugin can be easily integrated into baked code, first grab the code and put it into your plugins folder (git://github.com/CakeDC/search.git) and add the subtheme option to your commands:

    cake bake model Article                  -theme cakedc -parent Author -parentSlug -subthemes Templates.search 
    cake bake controller Article public     -theme cakedc -parent Author -parentSlug -subthemes Templates.search 
    cake bake view Article                  -theme cakedc -parent Author -parentSlug -subthemes Templates.search 
    cake bake view Article find             -theme search

### User dependent actions ###

If you want to restrict actions or data modification only to the owning users of each record you should add the -user option to your commands, this options takes a parameter as the name of the model that represents users in your applications.

    cake bake model Article                  -theme cakedc -parent Author -parentSlug -subthemes Templates.search -user User -appTestCase
    cake bake controller Article public     -theme cakedc -parent Author -parentSlug -subthemes Templates.search -user User -appTestCase
    cake bake view Article                  -theme cakedc -parent Author -parentSlug -subthemes Templates.search -user User -appTestCase
    cake bake view Article find             -theme search

## Requirements ##

* PHP version: PHP 5.2+
* CakePHP version: Cakephp 1.3 Stable

## Support ##

For support and feature request, please visit the [Templates Plugin Support Site](http://cakedc.lighthouseapp.com/projects/59612-templates-plugin/).

For more information about our Professional CakePHP Services please visit the [Cake Development Corporation website](http://cakedc.com).

## License ##

Copyright 2009-2010, [Cake Development Corporation](http://cakedc.com)

Licensed under [The MIT License](http://www.opensource.org/licenses/mit-license.php)<br/>
Redistributions of files must retain the above copyright notice.

## Copyright ###

Copyright 2009-2010<br/>
[Cake Development Corporation](http://cakedc.com)<br/>
1785 E. Sahara Avenue, Suite 490-423<br/>
Las Vegas, Nevada 89104<br/>
http://cakedc.com<br/>
