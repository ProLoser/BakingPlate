# Baking Plate version 0.0.4a1 

BakingPlate is a cake plugin that assists in generating/baking CakePHP projects
(by which we mean apps that use a core install of cake - see Advanced Installion of Cake) 

It contains a ***skel****leton directory* from which the derived app is created.
The **skel** comes pre-set with a great deal of *hotness baked in*.  The skel is tweaked for advanced setup.

The intention is to boost start projects giving the application additional functionality of
many popular cake plugins and vendor code that are used frequently in cakephp 1.3.* apps.

BakingPlate intends to build upon CakePHP's convention rather than configuration policy.

Some Benefits of Using BakingPlate (some features may vary depending on release - more details in to listed below. Check the open issues too)

* Since BakingPlate creates project apps upgrading cake is easier (1 cake install not many).
* Its a vanilla cake - if your familiar with cake the projects created by BakingPlate will not be new to you.
  (with some cake projects you have to learn a whole new set of conventions onto of cake);
  you can add bespoke features to your app.
* Advanced & Management of Caching.
* Preset Code to work with FCKEditor, TinyMCE or indeed Markdown.
* Lazy Model Loading.
* Option to Use Dynamic Pages.
* Site Search using CakeDC Search Plugin.
* A Html5 Boilerplate Theme (adhering to all the best practices that apply to cakeapps).
* User Login/Registration/Management System (ACL One day also) using CakeDC Ucers &amp; ProLoser Welcome plugins.
* Planned intergration with ProLoser's Cart Plugin.

## Instructions

1. Clone into your root plugins directory into `/plugins/baking_plate`
2. Open up your terminal and run `cake plate` - you should see a screeb of options
    a. Browse the available plugins and vendors (making note of corresponding names or numbers of modules to install)
    b. use `-group` to show repos by Author
    c. Show a list of available groups `cake plate browse groups`
3. Run `cake plate bake <project_path>` in your terminal
    a. the default  group is a set of core plugins; to set a different group use `-group cakedc` 
4. Change to the newly baked project
    a. Run `cake plate all` to add all plugins
    b. Run `cake plate add <#|mod_name>` or `git submodule add git-uri (plugins|vendors)/submodule_camel_name` (if you have trouble with the first option)
    c. install a CSV list of numbers to add
5. Run `cake schema create -plugin PluginName` or use the `cake migration -plugin PluginName`
6. review code in newly created app removing `[delete me]` strings to enable functionality
7. *some* configuration settings exist in `boostrap.php`

Voila! you have a baked your app and initialized it as a git repo

Please if you have ideas fork it, commit, push it, send pull request

enjoy

## todo:


1. Dynamic Pages (if derived app does not need just remove) (this will become a process option)
2. More dirs in tmp
3. Libs - initial PageRoute exists
4. i18n/l10n stuff
5. Html5 Boilerplate Theme Finish
6. Default Non Themed views should use Best Practices
7. More work on Admin Theme
8. Settings
    1. Decide upon a Setting/Config setup (using Nick Bakers now may change)
    2. Decide upon Config Key convention Using Site.theme, Site.author now (or should Config.language be the way)
9. More Server Cfg Options (Apache2.2, Nginx, .htaccess)
10. Add information to Readme
    1. Updating a derived project; using git to ease this burden
    2. Remove stuff from derived project delete from your active branch
    3. Selecting a wysiwyg editor for use within the app.
    4. Customising the skel
11. More see comments





 

# Plate Plus

A Componant and set of helpers that enable more within a bakingplate app

## The Plate Helper

**That rug really tied the room together, man!**

`var $helpers = array('BakingPlate.Plate')`;

this will output a doctype, html tag & charset
`echo $this->Plate->start();`

Its a helper that adds a number of features to apps and leaves 
your layouts clean & basic. The helper that unifies apps baked with [BakingPlate](http://github.com)

It *will*  wrap in support for other cake plugins (Media, Asset Compress).
It currently wraps in support for the HtmlPlus Helper - which is optional 
and if used will output html5 markup (or html 4.5, xhtml5 with minor switches)

## Html5 Boilerplate standards

One of the primary intentions of the plate helper is to equip cake views & helpers with 
methods to make implementing the ideology of *Paul Irish & Divya Manian's* **Html5 Boilerplate** 
the additional plugins are required to achieve this goal.

* Multi Html Conditional comments
* ChromeFrame meta
* Drew Diller's PNG Fix
* JsLib with CDN Fallback (shown below)
* Google Anlaytics script block

eg to output a scritpt source using  jquery from google hosted api (with a local fallback)
`$this->Plate->jsLib()`

* change version
* control minification
* load other js libs including Dojo, MooTool, Protype or SWFObject.
* use other content deployment networks such as Microsoft, jQuery or custom 

todo:
* jquery ui
* additional support for clientside dev/build tool

The plate plugin also includes *Chris Yure's* **Capture Element concept** 
which can be used to create vars for use in *layouts* from elements (or outputted markup) 
from within the *view*.  Also it can be used to construct markup to be passed to method 
calls.


for more information see the test cases for the helper in question


## Using the Plus Helpers

`var $helpers = array('Analogue.Analogue' => array('PlatePlus.HtmlPlus' => 'Html', 'PlatePlus.FormPlus' => 'Form'))`;

### Html Plus

this will output  a section (falling back to div with 'section' class for non (x)html5 output)
`echo $this->Html->section($section, $headers);`

@todo video, audio, source, mark, time, sectionize

### Form Plus

not there yet

## Todo

* i18n stuff
* Plate create method for showing basic vars in nice format when admin (make it update via ajax)
* Plate resolve inconsistencies with JS Paths to modernizr
* Plate resolve inconsistencies with JS Paths in fallback libs
* Plate resolve inconsistencies with syntax of html4.5 vs html5 fallback lib
* HtmlPlus Microformats
* HtmlPlus Media Plugin support
* HtmlPlus Swf Engine support (swf management & swfobject app intergration)
* HtmlPlus Asset Compress (possible other asset plugins to)
* Html5
    * HtmlPlus Video, Audio & Source
      video for all ideas
    * HtmlPlus Time
    * fallback content improvements
    * fallback scripts
* FormPlus Helper
* Plugin elements (this helper set has been converted to a plugin - you may have to copy the plugins elements to app elements)
    * make the presence of elements in app override those within this helper
* Plate has only helpers - comp, behaviours maybe later
* Add php flushing to improve performance before body and end of page (might affect what StaticCache saves to webroot/cache/)

### Made for BakingPlate (but can be used with cake apps in general).