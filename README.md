# SimpleDynamicForm-yii2
Have the ability to create several dynamic forms in a simple way on yii2 with customized views and model validation. 

# View.php
```php
<?= SimpleDynamicFormWidget::widget([
    "item" => $this->render("item", [
        'models' => $models,
        'form' => $form,
        'value1' => $value1,
        'value2' => $value2,
    ]),
    'values' => $models->multiple,
    "btn_text" => "",
    "remove_text" => '',
    "default_remove" => false,
    "remove_class" => 'remove-item',
    "template_btn" => '<div class="add-more-footer mt-80">
        <a> Add more </a>
    </div>',
    "after_add" => "function (item) {
        console.log(item)
        alert('ok')
        }"
    ])
?>
```

# Item.php
```html
<div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="form-border_dashed level">
                        <?= $form->field($models, '[0]value')->textInput(['maxlength' => true])->label(false) ?>
                        <?= $form->field($models, '[0]id')->hiddenInput()->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <a href="javascript:void(0)" class="remove-item"><i class="uil uil-trash-alt"></i></a>
            </div>
        </div>
</div>
```

# ModelSimple.php
```php
<?php
namespace app\models;
use Yii;

class ModelSimple extends \yii\db\ActiveRecord
{
    public $multiple;
    
    public function loads($posts){
        if(!$posts){
            return false;
        }

        foreach ($posts as $key => $post) {
            $model = isset($post["id"]) && $post["id"] != "" ? self::findOne($post["id"]) : new ModelSimple();
            $model->value = $post["value"];

            $this->multiple[] = $model;
        }
        return true;
    }

    public function saves(){
        foreach ($this->multiple as $key => $model) {
            if(!$model->save()){
                return false;
            }
        }
        return true;
    }
}?>
```

# SimpleController.php
```php
<?php
    namespace app\controllers;
    use app/models/ModelSimple

    class SimpleController extends Controller
    {
        public function actionSave($id="")
        {
            $model = new ModelSimple()
            if (Yii::$app->request->isPost && $model->loads(Yii::$app->request->post("Model")) && $model->saves()){
                return true;
            }else{
                $model->multiple = ModelSimple::find()->where(['id' => $id])->asArray()->all();
    
                return $this->render('step5', [
                    'model' => $model,
                ]);
            }
        }
    }
?>
```