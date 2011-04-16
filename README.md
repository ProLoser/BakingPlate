# Baking Plate version 0.0.5b2

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
* User Login/Registration/Management System (ACL One day also) using CakeDC Users &amp; ProLoser Welcome plugins.
* Planned intergration with ProLoser's Cart Plugin.
* Planned Mobile Detection &amp; Theme Switching (that will support view caching) using subdomains (moving to a revised version of plateplus).

## Instructions

Please read the [GitHub Wiki](https://github.com/sams/BakingPlate/wiki/) for installation instructions. Thanks.
 

# Plate Helper & Comp

The Plate Comp and Helper help keep controllers & views clean respectively.

## The Plate Helper

**That rug really tied the room together, man!**

`var $helpers = array('BakingPlate.Plate')`;

Its a helper that adds a number of features to apps and leaves 
your layouts clean & basic.

## Html5 Boilerplate standards

One of the primary intentions of the plate helper is to equip cake views & helpers with 
methods to make implementing the ideology of *Paul Irish & Divya Manian's* **Html5 Boilerplate** 
the additional plugins are required to achieve this goal.

* Multi Html Conditional comments
* ChromeFrame meta
* Drew Diller's PNG Fix
* Js Libs with CDN Fallback (shown below)
* Google Anlaytics script block

eg to output a script source using  jquery from google hosted api (with a local fallback)
```
  echo $this->Plate->lib('jquery', array('fallback' => 'lib/jquery-1.5.2.min'));
  echo $this->Plate->lib('swfobject', array('fallback' => 'lib/swfobject'));
```

will create (swfobject should be placed in the head of document)
```
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/lib/jquery-1.5.2.min.js">\x3C/script>')</script>
<script src="//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
<script>window.swfobject || document.write('<script src="/js/lib/swfobject2.2.js">\x3C/script>')</script>

```

you can use the same method to add additional js libs commonly used in the modern web.

* change version
* control minification
* the BakingPlate default cdn is Google Hosted Api - all google hosted apis and firebug-lite and yahoo profiler are available in BakingPlate

todo:
* additional support for clientside dev/build tool

## Using the Plate Componant

## Using the Helpers

`var $helpers = array('Analogue.Analogue' => array(array('helper' => 'BakingPlate.HtmlPlus', 'rename' => 'Html'), array('helper' => 'BakingPlate.FormPlus', 'rename' => 'Form')));`

if the Plate, HtmlPlus or FormPlus helpers lack functionality you desire create your own copies within app and have theme 
extend the BakingPlate helper class and then use Analogue to rename it to the ref that BakingPlate expects.

`array('Analogue.Analogue' => array(array('helper' => 'MyPlate', 'rename' => 'Plate')));`

### Plate

## Html Method

Outputs a sequence of Html tags with classes used to target browsers - see http://github.com/paulirish/html5-boilerplate/
you can also set lang, a manifest for the document

## Start and Stop methods

Based upon ideas by Chris Yure and xx you use these methods to start capturing output to a named var
stop then sets this var.  This means you can:

* Build complex structures of markup to pass to pass as args to Helper methods and use within elements
* Build a custom 'for_layout' var witin a cake action view and have the layout use the var (the layout would have to expect it)

A View Action eg posts/index.ctp
```
  $this->Plate->start('sidebar');
  echo $this->Html->tag('h2', __('My Badass Sidebar'));
  echo $this->Html->div('gold', $this->WidgetBuilder->template('sidebar', $widgets));
  echo $this->Html->div('silver', $this->element('layout/sidebar-foot'));
  ?><div class="bronze"><h3>A gem</h3></div><?php
  $this->Plate->stop();
```

A Cake Layout
```
 if(!empty($sidebar_for_layout)) {
   echo $this->Html->div('sidebar', $sidebar_for_layout);
   echo $this->Html->div('main', $content_for_layout);
 } else {
   echo $content_for_layout;
 }
```


### Html Plus

This helper extends Cake's core Html Helper and overrides methods to support html5

* no type attributes for page assets
* html5 charset
* external js can be provided using http(s) independent uris

### Form Plus

Adds new input types and attributes to Cake's core Form Helper.
It does not place fallbacks for browsers that don't support them but html5 degrades gracefully
and you could add js fallbacks to enable this functionality

getting closer

