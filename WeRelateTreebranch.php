<?php
if (!defined('MEDIAWIKI')) die(0);

/**
 * Extension metadata
 */
$wgExtensionCredits['other'][] = array(
    'path' => __FILE__,
    'name' => 'WeRelateTreebranch',
    'author' => "Sam Wilson <[mailto:sam@samwilson.id.au sam@samwilson.id.au]>",
    'url' => "http://www.mediawiki.org/wiki/Extension:WeRelate",
    'descriptionmsg' => 'werelatetreebranch-desc',
    'version' => 0.1,
);

/**
 * Messages
 */
$wgExtensionMessagesFiles['WeRelateTreebranch'] = __DIR__ . '/WeRelateTreebranch.i18n.php';

/**
 * Class loading
 */
$wgAutoloadClasses['WeRelateTreebranch_treebranch'] = __DIR__.'/model/treebranch.php';

/**
 * Tag hook
 */
class WeRelateTreebranch extends WeRelateCore_Tags {
	protected $extension = 'WeRelateTreebranch';
    protected $tags = array('treebranch');
}
$tags = new WeRelateTreebranch();
$wgHooks['ParserFirstCallInit'][] = array($tags, 'init');
