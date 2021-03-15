<?php

namespace app\widgets\SimpleDynamicForm;

use yii\base\Widget;
use app\widgets\SimpleDynamicForm\assets\SimpleDynamicFormAsset;
use maybeworks\minify\MinifyHelper;
use yii\helpers\Json;

class SimpleDynamicFormWidget extends Widget
{
    public $id;
    public $layout;
    public $item;
    public $title;
    public $values = [];
    public $btn_text = "Add";
    public $remove_text = "Remove";
    public $btn_class = "btn btn-primary";
    public $class_error = "invalid-feedback";
    public $template_btn = null;
    public $template_remove = null;
    public $remove_class = "";
    public $after_add = "{}";
    public $default_remove = true;

    public function run()
    {
        $this->id = $this->id ? $this->id : "add-more-simple-".uniqid();
        // /** @var View */
        $this->view = $this->getView();

        

        AddMoreSimpleAsset::register($this->view);
        $this->item = '<div class=\"add-more-item-simple\">' . $this->item . "</div>"; 
        $this->item = MinifyHelper::html($this->item);
        
        $this->values = $this->values ? json_encode($this->values) : "[]";
        $this->registerJsWidget($this);

        return $this->render('layout', [
            'id' => $this->id,
            'title' => $this->title,
            'btn_text' => $this->btn_text,
            'btn_class' => $this->btn_class,
            'template_btn' => $this->template_btn,
        ]);
    }

    /**
     * @param      $id
     * @param View $view
     */
    protected function registerJsWidget($widget)
    {
        $widget->view->registerJs("
            
            jQuery('#$widget->id').addMoreSimple({
                item: '$widget->item',
                template_remove: '$widget->template_remove',
                remove_class: '$widget->remove_class',
                class_error: '$widget->class_error',
                remove_text: '$widget->remove_text',
                values: '$widget->values',
                default_remove: '$widget->default_remove',
                after_add: $widget->after_add
            });
        ");
    }
}
