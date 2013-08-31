<?php

class WeRelateTreebranch_treebranch extends WeRelateCore_base {

	protected $tag = 'treebranch';
	
	protected $observers = array();
	
	public function addObserver($callback) {
		$this->observers[] = $callback;
	}

	protected function notify($title) {
		foreach ($this->observers as $callback) {
            call_user_func($callback, $title);
		}
	}

    public function traverse() {
		$this->load();
		foreach ($this->xml->ancestors as $a) {
			$ancestor = Title::makeTitle(NS_WERELATECORE_PERSON, (string)$a);
			$this->traverseAncestors($ancestor);
		}
		foreach ($this->xml->descendants as $d) {
			$descendant = Title::makeTitle(NS_WERELATECORE_PERSON, (string)$d);
			$this->traverseDescendants($descendant);
		}
	}

    protected function traverseAncestors(Title $ancestor) {
		$this->notify($ancestor);
		$person = new WeRelateCore_person($ancestor);
		if (!$person->load()) return;
		foreach ($person->getFamilies('child') as $family) {
			$this->notify($family->getTitle());
			if ($h = $family->getSpouse('husband')) $this->traverseAncestors($h->getTitle());
			if ($w = $family->getSpouse('wife')) $this->traverseAncestors($w->getTitle());
		}
    }

    protected function traverseDescendants(Title $descendant) {
		$this->notify($descendant);
		$person = new WeRelateCore_person($descendant);
		if (!$person->load()) return;
		foreach ($person->getFamilies('spouse') as $family) {
			$this->notify($family->getTitle());
			foreach ($family->getChildren() as $child) {
				$this->traverseDescendants($child->getTitle());
			}
		}
    }

    public function getAncestors() {
        if (!$this->load()) return false;
        $ancestors = array();
        foreach ($this->xml->ancestors as $a) {
            $title = Title::makeTitle(NS_WERELATECORE_PERSON, $a);
            $ancestors[] = new WeRelateCore_person($title);
        }
        return $ancestors;
    }

    public function getDescendants() {
        if (!$this->load()) return false;
        $descendants = array();
        foreach ($this->xml->descendants as $d) {
            $title = Title::makeTitle(NS_WERELATECORE_PERSON, $d);
            $descendants[] = new WeRelateCore_person($title);
        }
        return $descendants;
    }

}
