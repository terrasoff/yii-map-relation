<?php
if (!isset($isEditable))
    $isEditable = true;

$relationName = $owner->getMapRelationNameByClass($relation);
$mapClass = lcfirst($owner->getMapRelationClass($relation));
?>

<div class="related-list">
    <?php foreach ($owner->{$relationName} as $related) { ?>
        <div class="related-item">
            <span class="related-item-name"><?= $related->name ?></span>
            <?php if ($isEditable) { ?>
                <form action="<?= Yii::app()->createUrl("{$mapClass}/delete") ?>" method="POST">
                    <input type="hidden" name="idOwner" value="<?= $owner->primaryKey ?>" />
                    <input type="hidden" name="idRelated" value="<?= $related->primaryKey ?>" />
                    <button class="btn btn-small">delete</button>
                </form>
            <?php } ?>
        </div>
    <?php } ?>
</div>