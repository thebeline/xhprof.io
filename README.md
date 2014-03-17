xhprof.io
=========

GUI to analyze the profiling data collected using XHProf – A Hierarchical Profiler for PHP.

This fork was intially started because of a lack of time by the origin author to maintain the codebase (see credits).
Let's try to get this great app to the next level, which will also help bring your own apps one step closer to performance heaven ;-).

With the changes applied to this fork, we were able to reduce the impact of profiling in our scenario from 10-20s down to 500-800ms.


Changes since forked
====================

- profilling improvements
  - use PreparedStatements only in places where we actually execute them more than once.
  - Do also profile scripts which are terminated with exit() or die().
  - by default the xhprof.io UI is not profilled to reduce unnecessary load on dev machines. 
- lots of performance improvements
- easier debugging, better exception handling in shutdown functions
- more comfortable configuration, like apache does with allow override
- ZendDebugger support (no profilling while debugger is running)
- PHP5.3 compatibility
- charts
  - faster generation
  - more usable for big profiles
  - new context rooted charts
  - more chart types in the works
- UI changes
  - More navigation options
  - Fixed non-utf8 characters
  - Added autocompletion capabilities
  - More descriptive labels
  
INSTALL
=======

For installation instructions see https://github.com/staabm/xhprof.io/blob/master/INSTALL.md
  
DEMO
====

At the moment, the fork looks more or less like the original version.
Most changes occured under the hood to boost performance.
To get an idea how thinks look like see http://xhprof.io/.

We will setup our own demo version shortly.

Contribute
==========

Feel free to contribute! PRs are welcome. Bring this project one step closer to heaven by providing a PR for issues tagged as "accepted".

DEVELOPERS
==========

Make sure to install a less compiler
`npm install -g less`

You might also like it integrated in your favorite IDE, e.g. phpstorm http://www.jetbrains.com/phpstorm/webhelp/transpiling-sass-less-and-scss-to-css.html#d151302e510

CREDITS
=======

This fork started from the great code base of Gajus Kuizinas (@gajus), see https://github.com/gajus/xhprof.io

This fork is maintained by Markus Staab (@staabm)
