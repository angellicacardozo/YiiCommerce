<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'enroll-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'focus'=>array($client_enroll_form,'nome'),
)); ?>

<?php echo $form->errorSummary($client_enroll_form); ?>

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
<?php $this->endWidget(); ?>
