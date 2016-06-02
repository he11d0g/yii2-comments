<div class="comment comment-block" data-id="<?= $model->id?>">
    <div class="content">
        <a class="author"><?= $model->getUserAttr('name') ?></a>
        <div class="subheader">
            <span class="subheader"><?= $model->getUserAttr('email') ?></span>
        </div>
        <div class="text view-form">
            <div class="comment-body"><?= $model->body ?></div>
            <?php if(!$this->context->isGuest): ?>
            <div class="actions">
                <a class="edit">Редактировать</a>
                <a class="delete">Удалить</a>
                <span class="message"></span>
            </div>
            <?php endif; ?>
        </div>

        <div class="edit-form hidden" >
            <textarea class="comment-body editing"> <?= $model->body ?></textarea>
            <?php if(!$this->context->isGuest): ?>
            <div class="actions">
                <a class="update">Сохранить</a>
                <a class="delete">Удалить</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="ui divider"></div>
</div>
