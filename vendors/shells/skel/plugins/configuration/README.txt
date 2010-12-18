Configuration Plugin
======================
Version: 1.1
Author: Nick Baker
Email: nick@webtechnick.com
Website: http://www.webtechnick.com
Updates: http://www.webtechnick.com/blogs/view/223/CakePHP_Configuration_Plugin


Get it
======================
Download: http://projects.webtechnick.com/configuration.tar.gz
SVN: http://svn.github.com/webtechnick/CakePHP-Configuration-Plugin
GIT: git@github.com:webtechnick/CakePHP-Configuration-Plugin.git


The Configuration plugin is an extremely useful way to store site-wide configuration.  The configuration plugin stores
your configuration into your database and is made available throughout your site (views, controllers, models, tasks, etc...)


========================= Install ========================= 
1) Copy the /configuration folder into /app/plugins/
2) run "cake schema run -path /plugins/configuration/config/sql -name config" in a terminal to build your database.


========================= Setup =========================
1) Open up your app_controller.php file and add:

  var $uses = array('Configuration.Configuration');
  
  function beforeFilter(){
    //Load Configurations
    $this->Configuration->load($prefix); //$prefix is 'CFG' by default
  }
  
2) Navigate to http://www.yoursite.com/admin/configuration/configurations
3) Start adding configurations.


========================= Usage =========================
  Whatever name/value pair you save in your configuration database, you'll have access to anywhere in your site via
  
  Configure::read('[prefix].[name]'); //returns 'value';
  
  
========================= Example =========================

  Say I have a configuration table like so:
  
__ID__|_NAME______|_VALUE_________________
  1   | email     | nick@webtechnick.com
  2   | name      | Nick Baker
  
  
  I could access this data anywhere in my app by simply using Configure::read([prefix].[name]);
  (Default prefix is 'CFG', but you can change it in your app_controller.php).
  
  In a view:
  $html->link('Email ' . Configure::read('CFG.name'), 'mailto:' . Configure::read('CFG.email'));
  
  In a controller:
  $this->Email->from = Configure::read('CFG.email');
  
  In a model: 
  $this->findByEmail(Configure::read('CFG.email');
  
  
  You can get your entire Configuration table by not giving a name: 
    Configure::read('CFG'); //return an associative array of your configuraitons database.