<li class="dd-item">
    <div class="pull-right item_actions">
        <div class="btn btn-sm btn-danger pull-right delete-block">
            <i class="voyager-trash"></i> Удалить
        </div>
        <div class="btn btn-sm btn-primary pull-right edit-block js-projects-block" data-toggle="modal" data-target="#modal-edit-object-item">
            <i class="voyager-edit"></i> Редактирование
        </div>
    </div>
    <div class="dd-handle">
        <span><?= htmlspecialchars($data[array_keys($data)[0]]) ?></span>
    </div>
    <div class="item-fields" style="display: none;">
        <?=$html?>
    </div>
</li>