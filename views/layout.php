<div class="" id="<?=$id?>">

    <h1><?=$title?></h1>
    <div class="add-more-parent-simple">
    </div>

    <div class="button-add">
        <?php if($template_btn){
            echo $template_btn;
        }else{?>
            <button type='button' class="<?=$btn_class?>"> <?=$btn_text?></button>
        <?php }?>
    </div>
</div>