<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl."/css/form/form.essentials.css"); ?>

<?php $lform=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
<fieldset class="input-group">
	<legend><span>Efetuar login e finalizar compra</span><span class="right"></span></legend>
	<div class="input-group">
	<p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>

	<div class="row">
		<?php echo $lform->labelEx($loginform,'username'); ?>
		<?php echo $lform->textField($loginform,'username'); ?>
		<?php echo $lform->error($loginform,'username'); ?>
	</div>

	<div class="row">
		<?php echo $lform->labelEx($loginform,'password'); ?>
		<?php echo $lform->passwordField($loginform,'password'); ?>
		<?php echo $lform->error($loginform,'password'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>
	</div>
</fieldset>
<?php $this->endWidget(); ?>

<br />

<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'enroll-form',
    'enableClientValidation'=>true,
    'focus'=>array($client_enroll_form,'nome'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<?php echo $form->errorSummary($client_enroll_form); ?>
<fieldset class="input-group">
	<legend><span>Inscrever-me no site e finalizar minha compra</span><span class="right"></span></legend>
	<div class="input-group">
		<div class="row">
		    <?php echo $form->labelEx($client_enroll_form,'nome'); ?>
		    <?php echo $form->textField($client_enroll_form,'nome'); ?>
		    <?php echo $form->error($client_enroll_form,'nome'); ?>
		</div>
		<div class="row">
		    <?php echo $form->labelEx($client_enroll_form,'email'); ?>
		    <?php echo $form->textField($client_enroll_form,'email'); ?>
		    <?php echo $form->error($client_enroll_form,'email'); ?>
		</div>
		<div class="row">
		    <?php echo $form->labelEx($client_enroll_form,'password'); ?>
		    <?php echo $form->passwordField($client_enroll_form,'password'); ?>
		    <?php echo $form->error($client_enroll_form,'password'); ?>
		</div>
		<div class="row">
		    <?php echo $form->labelEx($client_enroll_form,'telefone'); ?>
		    <?php echo $form->textField($client_enroll_form,'telefone'); ?>
		    <?php echo $form->error($client_enroll_form,'telefone'); ?>
		</div>
		<div class="row">
		    <?php echo $form->labelEx($client_enroll_form,'endereco'); ?>
		    <?php echo $form->textField($client_enroll_form,'endereco'); ?>
		    <?php echo $form->error($client_enroll_form,'endereco'); ?>
		</div>
		<div class="row">
			<?php echo CHtml::submitButton('Inscrever-me'); ?>
		</div>
	</div>
</fieldset>
<?php $this->endWidget(); ?>