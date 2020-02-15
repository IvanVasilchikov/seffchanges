<div class="form-group  ">
    <label for="name"><?= $title ?></label>
    <? if($value): ?>
        <? $data = explode('.',$value) ?>
        <? if(!in_array($data[1],['jpg','jpeg','gif','png'])): ?>
            <?
                $f = explode('/',$value);
            ?>
            <div style="text-align: center;font-size: 18px;margin-bottom: 5px;">
                <a target="_blank" href="<?=$value?>"><?=array_pop($f)?></a>
            </div>
        <? endif; ?>

    <? endif; ?>
    <div class="dropzone">
        <div>
            <? if($value):?>
                <? if(in_array($data[1],['jpg','jpeg','gif','png'])): ?>
                    <img src="<?= $value ?>" alt=""><br>

                <? else: ?>
                    Перенесите файл
                <? endif; ?>
            <? else: ?>
                Перенесите файл
            <? endif ?>
        </div>
        <input type="hidden" name="<?=$name?>" value="<?=$value ?>">
        <input type="file" class="form-control" name="<?= $name ?>" placeholder="Изображение">
    </div>
    <? if($value):?>
    <div>
        <br>
        <button class="del_file btn btn-danger">Удалить файл</button>
    </div>
    <? endif; ?>
</div>