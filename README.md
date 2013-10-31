xhprof.io
=========

GUI to analyze the profiling data collected using XHProf – A Hierarchical Profiler for PHP.

This fork was intially started because of a lack of time by the origin author to maintain the codebase (see credits).
Let's try to get this great app to the next level, which will also help bring your own apps one step closer to performance heaven ;-).

With the changes applied to this fork, we were able to reduce the impact of profiling in our scenario from 10-20s down to 500-800ms.


Changes since forked
====================

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
