<?php
use yii\widgets\ListView;

?>
<div class="ui two column grid">
    <div class="column">
        <div class="ui piled blue segment hd-comments">
            <h2 class="ui header">
                Комментарии
            </h2>
            <div class="ui comments hd-comment-list">
                <?=
                ListView::widget([
                    'dataProvider' => $comments,
                    'itemView' => '_oneComment',
                    'summary' => false
                ]);
                ?>
            </div>
            <?php if(!$this->context->isGuest): ?>
            <form class="ui reply form">
                <div class="field">
                    <textarea id="new-comment-form"></textarea>
                </div>
                <div class="field center aligned">
                <?php if($this->context->captcha): ?>
                    <script src='https://www.google.com/recaptcha/api.js'></script>
                <div class="g-recaptcha" data-sitekey="<?= $this->context->captcha['siteKey']?>"></div>
                    <br />
                <?php endif; ?>
                <div class="ui fluid blue labeled submit icon button add-comment">
                    <i class="icon edit"></i> Добавить комментарий
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>