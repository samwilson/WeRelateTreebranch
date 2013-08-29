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
			$this->ancestors($ancestor);
		}
		foreach ($this->xml->descendants as $d) {
			$descendant = Title::makeTitle(NS_WERELATECORE_PERSON, (string)$d);
			$this->descendants($descendant);
		}
	}

    protected function ancestors(Title $ancestor) {
		$this->notify($ancestor);
		$person = new WeRelateCore_person($ancestor);
		if (!$person->load()) return;
		foreach ($person->getFamilies('child') as $family) {
			if ($h = $family->getSpouse('husband')) $this->ancestors($h->getTitle());
			if ($w = $family->getSpouse('wife')) $this->ancestors($w->getTitle());
		}
    }

    protected function descendants(Title $descendant) {
		$this->notify($descendant);
		$person = new WeRelateCore_person($descendant);
		if (!$person->load()) return;
		foreach ($person->getFamilies('spouse') as $family) {
			foreach ($family->getChildren() as $child) {
				$this->descendants($child->getTitle());
			}
		}
    }

}
