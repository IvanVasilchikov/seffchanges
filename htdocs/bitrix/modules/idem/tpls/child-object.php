<fieldset data-name="<?= $name ?>">
    <input class="default-fields" type="hidden" name="<?= $pname ?>[default]" value="<?= $default ?>">
    <legend>
        <div class="pull-right item_actions">
            <div class="btn btn-sm btn-success pull-right block-add">
                <i class="voyager-plus"></i> Добавить блок
            </div>
        </div>
        <div><?= $title ?></div>
    </legend>
    <div class="dd">
        <ol class="dd-list">
            <?=$content ?>
        </ol>
    </div>

</fieldset>
