# Overview

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
* Planned Mobile Detection &amp; Theme Switching (that will support view caching) using subdomains.

# Instructions

1. Clone into your root plugins directory into /plugins/bakingplate folder
2. Open up your terminal and make sure you have the cake bake console installed
3. Run `cake plate bake <project_path>` in your terminal
4. Change to the newly baked project
    a. Run `cake plate submodules all` 
    b. Run `cake plate submodules add <Submodule#>` or `git submodule add git-uri (plugins|vendors)/submodule_camel_name` (if you have trouble with the first option)
5. Run `cake schema creations`
	
Voila!

Please if you have ideas fork it, commit, push it, send pull request

enjoy

## todo:

1. Make mobile detect a plugin using remain cakephp native
2. Dynamic Pages (if derived app does not need just remove) (this will become a process option)
3. More dirs in tmp
4. Libs - initial PageRoute exists
5. i18n/l10n stuff
6. Html5 Boilerplate Theme Finish
7. Default (Non Themed views should use Best Practices
8. More work on Admin Theme
9. Settings
    1. Decide upon a Setting/Config setup (using Nick Bakers now may change)
    2. Decide upon Config Key convention Using Site.theme, Site.author now (or should Config.language be the way)
10. More Server Cfg Options (Apache2.2, Nginx, .htaccess)
11. Add information to Readme
    1. Updating a derived project; using git to ease this burden
    2. Remove stuff from derived project delete from your active branch
    3. Selecting a wysiwyg editor for use within the app.
    4. Customising the skel
12. This plugin prevents cake bake from being able create plugins - clash with tasks? 
13. More see comments
