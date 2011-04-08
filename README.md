# Baking Plate version 0.0.5b1

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

Please read the [GitHub Wiki](https://github.com/sams/BakingPlate/wiki/) for installation instructions. Thanks.
 

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


### Made for BakingPlate (but can be used with cake apps in general).