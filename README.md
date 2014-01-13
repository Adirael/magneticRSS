magneticRSS 
===========

magneticRSS is a small *PHP* application written using the *Fat Free Framework*. 

It stores magnet links and distributes them to compatible clients using RSS.

-----------------------

### Warning - Unstable Project

This project is in an **early development** stage, changes may be done wildly and expect things to break. Once the project advances a bit I'll start using feature branches and organizing everything a bit.

### Create a userToken and userPassword

To make requests to the server first you need to generate a `userToken` and `userPassword`. Both will be used to store new magnet links and the userToken will be needed to generate a user's RSS feed.

To generate the tokens just go to `/addUser` and both will be shown on screen.

### Add a magnet link

To add a magnet link to the database just do a `GET` or `POST` request to `/add` along with `userToken`, `userPassword` and `magnetLink` parameters.

### Get RSS feed

All RSS feeds are publicy available, the URL is generated using the userToken, as follows: `/userToken/rss` (ie: `/c973d4a3dbba1ef55d1c6044968fc305/rss`)

-----------------------

### How to

![image](https://raw2.github.com/Adirael/magneticRSS/master/pub/images/screenshot.png)

### Future releases

Future releases will include the next features:

* Let the user select a custom userToken
* Have a HTML version of the RSS
* Add a title to the magnet link
* Create a bookmarklet to quickly add new links
* Allow users to change their password
* Save the user's email (optional) to allow password recovery
* An amicable welcome page when pointing to /

-----------------------

### Library

* [Twitter Bootstrap](http://getbootstrap.com/)
* [Flatly Bootstrap theme from Bootswatch](http://bootswatch.com/flatly/)
* [Fat Free Framework](http://fatfreeframework.com/)
