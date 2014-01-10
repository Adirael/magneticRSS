magneticRSS
===========

magneticRSS is a small *PHP* application written using the Fat Free Framework. 

It stores magnet links and distributes them to compatible clients using RSS.

-----------------------

### Create a userToken and userPassword

To make requests to the server first you need to generate a `userToken` and `userPassword`. Both will be used to store new magnet links and the userToken will be needed to generate a user's RSS feed.

To generate the tokens just go to `/addUser` and both will be shown on screen.

### Add a magnet link

To add a magnet link to the database just do a `GET` or `POST` request to `/add` along with `userToken`, `userPassword` and `magnetLink` parameters.

### Get RSS feed

All RSS feeds are publicy available, the URL is generated using the userToken, as follows: `/userToken/rss` (ie: `/c973d4a3dbba1ef55d1c6044968fc305/rss`)

-----------------------

### Future releases

Future releases will include the next features:

* Let the user select a custom userToken
* Have a HTML version of the RSS
* Add a title to the magnet link
* Create a bookmarklet to quickly add new links
* Allow users to change their password
* Save the user's email (optional) to allow password recovery
* An amicable welcome page when pointing to /
