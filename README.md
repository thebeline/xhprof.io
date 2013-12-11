xhprof.io
=========

GUI to analyze the profiling data collected using XHProf – A Hierarchical Profiler for PHP.

This fork was intially started because of a lack of time by the origin author to maintain the codebase (see credits).
Let's try to get this great app to the next level, which will also help bring your own apps one step closer to performance heaven ;-).

With the changes applied to this fork, we were able to reduce the impact of profiling in our scenario from 10-20s down to 500-800ms.


Changes since forked
====================

- profilling improvements
  - Do also profile scripts which are terminated with exit() or die(). https://github.com/gajus/xhprof.io/pull/39
  - by default xhprof.io is not profilled to reduce unnecessary load on dev machines. https://github.com/staabm/xhprof.io/commit/cac4403768f13cfd1494ea299d36d26fb38eae97
- divers performance improvements
  - https://github.com/gajus/xhprof.io/pull/55
  - https://github.com/gajus/xhprof.io/pull/43
  - https://github.com/gajus/xhprof.io/pull/42
- easier debugging
  - https://github.com/gajus/xhprof.io/pull/56
- more comfortable configuration 
  - https://github.com/gajus/xhprof.io/pull/40
- ZendDebugger support
  - https://github.com/gajus/xhprof.io/pull/48
- PHP5.3 compatibility
- UI changes
  - https://github.com/gajus/xhprof.io/pull/44
  - https://github.com/gajus/xhprof.io/pull/37
 
Contribute
==========

Feel free to contribute! PRs are welcome. Bring this project one step closer to heaven by providing a PR for issues tagged as [https://github.com/staabm/xhprof.io/issues?labels=accepted&milestone=&page=1&state=open]("accepted").

 
  
DEMO
====

At the moment, the fork looks more or less like the original version.
Most changes occured under the hood to boost performance.
To get an idea how thinks look like see http://xhprof.io/.

We will setup our own demo version shortly.

CREDITS
=======

This fork started from the great code base of Gajus Kuizinas (@gajus), see https://github.com/gajus/xhprof.io

This fork is maintained by Markus Staab (@staabm)
