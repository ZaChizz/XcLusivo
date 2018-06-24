<?php
namespace frontend\widgets;

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;

class Choose extends Select2
{
    protected function renderInput()
    {
        if ($this->pluginLoading) {
            $this->_loadIndicator = '<div class="kv-plugin-loading loading-' . $this->options['id'] . '">&nbsp;</div>';
            Html::addCssStyle($this->options, 'display:none');
        }
        $input = $this->getInput('dropDownList', true);
        ob_start();
?>
var btn<?=$this->options['id'];?> = $('<input type="button">').addClass("btn btn-sm btn-choose btn-grey").val("<?=$this->options['btnname'];?>").click(function() { console.log("click"); $("#<?=$this->options['id'];?>-styler [type=search]").keyup(); return false });
$("#<?=$this->options['id'];?>-styler [type=search]").hide().after(btn<?=$this->options['id'];?>);
<?php
        $js = ob_get_contents();
        ob_end_clean();
        $this->getView()->registerJs($js, View::POS_READY);
        echo $this->_loadIndicator . $this->embedAddon($input);
    }
}
