Git Panel
======================

Panel for Tracy debug panel.
Shows current branch and git log.

Requirements
============
- Git wrapper requires PHP 5.3.2 or higher and git.
- Valerian\Git

Installation
=============

Install library via composer:

```
composer require Valerian/GitPanel
```

Getting Started
===============
Register panel

```
nette:
    nette:
    	debugger:
    		bar:
    			- @gitPanel
services:
	gitPanel:
		class: Valerian\GitPanel\GitPanel
		setup:
			- $logHistory(3)
			- $gitPath(%appDir%/../)

```
