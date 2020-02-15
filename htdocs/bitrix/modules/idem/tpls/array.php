<div class="panel block-panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?=$key?>">
            <a><?=$title?></a>
            <div class="panel-actions">
                <a class="panel-action voyager-angle-down" aria-hidden="true"></a>
            </div>
        </h5>
    </div>
    <div id="collapse-<?=$key?>" class="panel-collapse collapse">
        <div class="panel-body">
            <?=$content?>
        </div>
    </div>
</div>