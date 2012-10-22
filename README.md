README
======

This is an example application exploring design pattern usage in a PHP
application.  This application is built off a fictitious problem
described below.  It would be your job to complete the problem in a way
that employs the use of any number of patterns, also listed below.
While the default application excludes "Models", any aspect of the
application can be swapped out for a more "pattern centric" solution.

This application was used as the basis for a talk at ZendCon 2012 by
@weierophinney, @ezimuel, and myself @ralphschindler.

Problem Domain
--------------

I, as your fictitious employer, are contracting you to build out a
prototype of an application that I am building a business upon. I
don't know the full problem area as this is a startup.  What I do
know I will tell you so you can start building and decide how much
abstraction is needed.

* The application/business is centered around Playlist sharing.
* The informtion about tracks/arists/albums, currently, will only
  need to be accessible from a Playlist object.
* The database is already filled out with a single playlist, there
  will be more at some point
* The application will likely need to be available via the command
  line or as a web service API at some point in the future, so plan
  abstraction accordingly.
* The "Aggregate Root" is the Playlist and is demonstrated via this
  UML of the Aggregate of objects. See the file DomainModelPlaylist.png
  in the ./dev/ directory.

Things to Know Before You Start
-------------------------------

* Most classes will have a docblock with a @pattern-notes in the
  comment. This has more information on the patterns in use.
* This is an MVC application, very minimal, framework-free.
* It uses Service Location to get application services into controllers,
  there are notes on this in the actual code.
* It has a pre-made sqlite database to use in /data/application.sqlite
* Patterns To Potentially use and identify:
  - Repository pattern
  - Entity, Value Objects
  - Mapper / Data Mapper
  - Lazy loading
  - Dependency Injection
  - etc.

Your Tasks
----------

1) Build out a Domain Model for this application.  The controllers,
   a service layer, and views are already complete in master, you
   just need to build the models.

2) Create a command line verison of this application

3) Build a new Playlist repository that utilizes a web-api to get
   Album and Artist information for a given track