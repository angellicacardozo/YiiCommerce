<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl."/css/form/form.essentials.css"); ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	<fieldset class="input-group">
		<legend><span>Login</span><span class="right"></span></legend>
		<div class="input-group">
		<p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>
		<p>Por favor, preencha o formulário abaixo com sua credenciais:</p>
		<div class="row">
			<?php echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username'); ?>
			<?php echo $form->error($model,'username'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password'); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>
	
		<div class="row buttons">
			<?php echo CHtml::submitButton('Login'); ?>
		</div>
		</div>
	</fieldset>
<?php $this->endWidget(); ?>
</div><!-- form -->
