
<?php if (count($treebranch->getAncestors()) > 0): ?>
<p><strong>Ancestors:</strong></p>
<ul>
<?php foreach ($treebranch->getAncestors() as $ancestor): ?>
<li><?php echo Linker::link($ancestor->getTitle(), $ancestor->getFulLName()) ?></li>
<?php endforeach ?>
</ul>
<?php endif ?>

<?php if (count($treebranch->getDescendants()) > 0): ?>
<p><strong>Descendants:</strong></p>
<ul>
<?php foreach ($treebranch->getDescendants() as $descendant): ?>
<li><?php echo Linker::link($descendant->getTitle(), $descendant->getFulLName()) ?></li>
<?php endforeach ?>
</ul>
<?php endif ?>

<p>
<?php
$title = 'WeRelateBook/'.$treebranch->getTitle()->getPrefixedURL();
echo Linker::specialLink($title, 'exportall');
?>
</p>
