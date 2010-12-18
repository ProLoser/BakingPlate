# Instructions

1. Clone into your root plugins directory into /plugins/bakingplate folder
2. Open up your terminal and make sure you have the cake bake console installed
3. Run 'cake bake -skel <path to /plugins/bakingplate/vendors/templates/skel>' in your terminal
4. Change to the newly baked project
    1. Remove unrequired Parts eg dynamic PagesController
    2. Add additional submodules
5. directory and run 'git submodule update --init'
6. Run cake schema creations
	
Voila!

Please if you have ideas fork it, commit, push it, send pull request

enjoy

## todo:

1. make mobile detect a plugin?
2. Add missing stuff to AppCtrlr (filter.filter, geoip, locale)
3. Slim down initial plugins
4. Dynamic Pages (if derived app does not need just remove)
5. gitmodules
    1. Is the a direct copy of repos gitmodules (if so convert plugins & vendors into submods)
    2. or is .gitmodules build by something during baking (make that happen)
6. more dirs in tmp
7. Libs - initial PageRoute Added
8. i18n/l10n stuff
9. Html5 Boilerplate Theme Finish (nearly there) - based upon Fork of CakePlate by Sams
9. Non Themed views should use Best Practices (no-started)
10. more work on Admin Theme (Truly awesome stuff admin comes is a range of colors)
11. Settings
    1. Decide upon a Setting/Config setup (using Nick Bakers now may change)
    2. Decide upon Config Key convention Using Site.theme, Site.author now (or should Config.language be the way)
12. Server Cfg
13. Add information to Readme
    1. updating a derived project; use git branches
    2. remove stuff from derived project delete from your active branch
15. more see comments