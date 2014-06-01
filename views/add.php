<?php
/**
 * @var array $relations
 * @var CActiveRecord $owner
 * @var CActiveRecord $rel
 */
?>
<h2>Add relations to "<?= $owner->getLabel() ?>"</h2>
<?php if (count($relations)) { ?>
    <form class="book-author-select" method="POST">
        <?php foreach ($relations as $related) { ?>
            <input type="checkbox" name="related[]" value="<?= $related->primaryKey ?>" />
            <label><?= $related->getLabel() ?></label>
        <?php } ?>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
<?php } else { ?>
    No items to add
    <a href="<?= Yii::app()->createUrl($modelViewUrl, array('id'=>$owner->primaryKey)) ?>"
        <button type="button" class="btn btn-primary">Back</button>
    </a>
<?php } ?>
