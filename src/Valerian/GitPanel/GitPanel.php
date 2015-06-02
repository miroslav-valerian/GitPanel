<?php

namespace Valerian\GitPanel;

/**
 * Git panel
 * 
 * @author Ing. Miroslav Valerián <info@miroslav-valerian.cz>
 * 
 */
use Tracy\IBarPanel;
use Nette\Application\Application;
use Nette\Http\Request;
use Nette\Application\UI\Control;

class GitPanel extends Control implements IBarPanel
{
    /** @var Application */
    private $application;

    /** @var Request */
    private $request;

    /** @var string */
    private $branch;

    /** @var Valerian/Git/Git */
    private $git;

    /** @var integer */
    public $logHistory = 3;
	
	/** @var string */
    public $gitPath;

    public function __construct(Application $application, Request $request)
    {
        $this->application = $application;
        $this->request = $request;

    }

    public function getPanel()
    {
        $branch = $this->getCurrentBranch();
		$branches = $this->getGit()->getLocalBranches();
        $remoteBranches = $this->getGit()->getRemoteBranches();
		$logs = $this->getGit()->log($this->logHistory);

        ob_start();
        $template = clone $this->application->getPresenter()->template;
        $template->setFile(__DIR__.'/GitPanel.latte');
        $template->currentBranch = $branch;
		$template->logs = $logs;
		$template->branches = $branches;
        $template->remoteBranches = $remoteBranches;
		$template->gitPath = $this->gitPath;
        $template->logHistory = $this->logHistory;
        $template->render();
        return ob_get_clean();
    }

	private function getGit()
    {
		if (!$this->git) {
		    $this->git = new \Valerian\Git\Git($this->gitPath);
        }
        return $this->git;
	}
	
	private function getCurrentBranch()
    {
        if (!$this->branch) {
            $this->branch = $this->getGit()->getCurrentBranch();
        }
        return $this->branch;
    }

    public function getTab()
    {
        return '<img  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAYdEVYdFNvZnR3YXJlAHBhaW50Lm5ldCA0LjAuNWWFMmUAAAFVSURBVDhPjZI7TsNAEIadMGs7oglCuQFUSEjJ7jpC1DSICyDRIZQT5AJchUPQUNJRIPESBdSUFKCIlzLM7Iy95uHII/2yvbP/N+PZTZoCh90+WkD0pOFgWZfbBe6SnEEsMtE4Z0hP04uDKic4hj663rQCtIUEszNfstkAFp1t9Oa0FUTNz+hpk+hSUwlBnsJahGhGQ82P6GlDCeAZjEDyDnbQpzHHkM2VkCNzh833cQM/VQ4mOMoGNBPuYg9d+hELKIQWr3+Y6nJwgDZdpwIzLJakoM9PKog3b0y++NfMEsBaeLddBZjj2AXM6RdWuYurP2aWg0MCbMh3/ok2O5PLFcyv1JW2JZAbGSIrmGlYKVfknJhiZToR8VahkNsK4rIHTdE6nC80l6GQu9hJdkSGfbqVdbMMoykEks8ipEXl38Hny0dUM89bm8vALZKFFzK/N7edJN+0GT3X7WfPOgAAAABJRU5ErkJggg==" /> GIT'.
            '('.$this->getCurrentBranch().')';
    }
}