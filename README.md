Git Panel
======================

Panel for Tracy debug panel.
Shows current branch and git log.

Installing
----------

Install library via composer:

```
composer require Valerian/GitPanel
```

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
