<div class="form-group">
    <? if($title && !is_int($title)): ?>
        <label for=""><?= $title ?></label>
    <? endif ?>
    <input class="form-control" type="text" name="<?= $name ?>" value="<?= htmlspecialchars($value) ?>">
</div>