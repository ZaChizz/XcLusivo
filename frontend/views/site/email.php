<?php
/**
 * Created by PhpStorm.
 * User: angelus
 * Date: 31.03.2016
 * Time: 16:46
 */
?>
<div class="flash">
<?php if(Yii::$app->session->getFlash('success')): ?>
    <div id="w1-success" class="alert-success alert fade in" style="width: 350px; cursor: pointer" onclick="$('.flash').empty()">
        <i class="icon fa fa-check"></i><?= Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>
</div>
<div style="margin-left: 15px; width:350px; margin-top: 5px;">
    <form method="post">
        <label for="toEmail">TO:</label> <br />
        <input id="toEmail" name="toEmail" value="" /> <br />
        <label for="subject">Subject:</label><br />
        <input id="subject" name="subject" value="" /><br />
        <label for="msg">Message:</label>
        <textarea name="msg" id="msg" ></textarea>
        <input type="submit" name="submit" value="Send messsage" style="float: right; margin-top: 5px  "/>
    </form>
</div>
