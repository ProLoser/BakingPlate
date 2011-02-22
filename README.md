# Overview - version 0.0.4a 

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

1. Clone into your root plugins directory into /plugins/baking_plate
2. Open up your terminal and run `cake plate` - you should see a screeb of options
    a. Browse the available plugins and vendors (making note of corresponding names or numbers of modules to install)
    b. use `-group` to show repos by Author
    c. Show a list of available groups `cake plate browse groups`
3. Run `cake plate bake <project_path>` in your terminal
    a. the default  group is a set of core plugins; to set a different group use `-group cakedc` 
4. Change to the newly baked project
    a. Run `cake plate all` 
    b. Run `cake plate add <#|mod_name>` or `git submodule add git-uri (plugins|vendors)/submodule_camel_name` (if you have trouble with the first option)
    c. install a CSV list of numbers to add
5. Run `cake schema creations` or use the `cake migration` plugin
	
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
