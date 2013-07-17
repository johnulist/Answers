<?php //debug(get_defined_constants()); ?>
<div id="formBuilder">
<div class="container">
  <div class="row clearfix">
    <!-- Building Form. -->
    <div class="span6">
      <div class="clearfix">
        <h2>Your Form</h2>
        <hr>
        <div id="build">
          <form id="target" class="form-horizontal">
          	
          </form>
        </div>
      </div>
    </div>
    <!-- / Building Form. -->

    <!-- Components -->
    <div class="span6">
      <h2>Drag & Drop components</h2>
      <hr>
      <div class="tabbable">
        <ul class="nav nav-tabs" id="navtab">
          <!-- Tab nav -->
        </ul>
        <form class="form-horizontal" id="components">
          <fieldset>
            <div class="tab-content">
              <!-- Tabs of snippets go here -->
            </div>
          </fieldset>
        </form>
      </div>
    </div>
    <!-- / Components -->

  </div>

</div> <!-- /container -->
</div>

<hr />


<div class="container">
	<div class="row clearfix">
		<div class="span12">
			<?php echo $this->Form->create('Answer');
				echo '<div class="row-fluid">';
				echo '<div class="span3">';
				echo $this->Form->input('Answer.id', array('type' => 'hidden'));
				echo $this->Form->input('Answer.plugin', array('type' => 'hidden', 'value' => 'Answers'));
				echo $this->Form->input('Answer.title', array('label' => 'Form Name', 'type' => 'text', 'required' => true));
				echo $this->Form->label('Choose where the form saves');
				echo $this->Form->select('Answer.model', $models, array('id' => 'modelSelect', 'required' => true, 'empty' => '-- Choose --'));
				echo '<div id="actionSelect"></div>';
				echo $this->Form->input('Answer.content', array('label' => false, 'type' => 'textarea', 'id' => 'render'));
				echo $this->Form->input('Answer.content_json', array('label' => false, 'type' => 'textarea', 'id' => 'renderJson'));
			    echo $this->Form->label('Success Message');
			    echo $this->Form->textArea('Answer.success_message', array('class' => 'clearfix'));
				echo $this->Form->label('Redirect');
				echo $this->Form->select('redirect', $urls, array('id' => 'redirectSelect', 'required' => true, 'empty' => false));
				echo $this->Form->input('Answer.success_url', array('type' => 'text', 'label' => 'url', 'div' => array('id' => 'urlSelect', 'style' => 'display:none;')));
			    echo $this->Form->input('Answer.allowed_user_submissions', array('label' => 'Allowed User Submissions', 'type' => 'text'));
				echo '<p>If set to 0 users can submit unlimited times, if guest can submit form this has no effect</p>';
			    echo '</div>';
				echo '<div class="span4">';
			    echo '<label class="checkbox">';
			    echo $this->Form->checkbox('Answer.send_email', array('hiddenField' => false));
			    echo 'Send Email</label>';
				echo '<div id="responseEmailDiv" style="display:none;">';
				echo $this->Form->label('Emails (seperated by a comma)');
				echo $this->Form->text('Answer.response_email');
			    echo $this->Form->label('Email Subject');
			    echo $this->Form->text('Answer.response_subject');
				echo '</div>';
				 echo '<label class="checkbox">';
			    echo $this->Form->checkbox('Answer.auto_respond', array('hiddenField' => false));
			    echo 'Auto Respond</label>';
				echo '<div id="autoEmailDiv" style="display:none;">';
				echo $this->Form->label('Auto Email Field. Please enter the id of the field for autoresponder');
					echo $this->Form->text('Answer.auto_email');
				echo $this->Form->label('Auto Response Subject');
				echo $this->Form->text('Answer.auto_subject');
			    echo $this->Form->label('Auto Response Body');
			    echo $this->Form->textArea('Answer.auto_body');
				echo '</div>';
				echo $this->Element('forms/alias', array('formId' => '#AnswerAddForm', 'nameInput' => '#AnswerTitle', 'prefix' => 'form/')); // must have the alias behavior attached to work
				echo '</div></div>';
				echo '<div class="row-fluid">';
			    echo $this->Form->submit('Save Form', array('class' => 'btn pull-right'));
				echo '</div>';
			?>
			<div id="labelTextArea">
				<?php echo $this->Form->input('Fake.labelEditor', array('type' => 'richtext')); ?>
				<a class="btn" href="#" id="ckeditorInsert">Insert</a>
				<a class="btn" href="#" id="ckeditorCancel">Cancel</a>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<hr />
 
<script type="text/javascript">
//<![CDATA[
$(document).ready(function () {
	if($('#redirectSelect').val() == 'url') {
		$('#urlSelect').show();
	}
	if($('#AnswerSendEmail').is(':checked')) {
		$('#responseEmailDiv').show();
	}
	if($('#AnswerAutoRespond').is(':checked')) {
		$('#autoEmailDiv').show();
	}
	$("#modelSelect").bind("change", function (event) {
		$.ajax({
  			type: "POST",
  			url: "/answers/answers/getActions",
  			data: { plugin: $(this).val() }
				}).done(function( returnhtml ) {
  				$('#actionSelect').html(returnhtml);
			});
		return false;
		});
	$('#redirectSelect').bind("change", function(event) {
		if($(this).val() == 'url') {
			$('#urlSelect').show('fast');
			$('#AnswerSuccessUrl').val('');
		}else {
			$('#urlSelect').hide();
			$('#AnswerSuccessUrl').val($(this).val());
		}
	});
	
	$('#AnswerSendEmail').bind("change", function(event) {
		if($(this).is(":checked")) {
			$('#responseEmailDiv').show('fast');
		}else{
			$('#AnswerResponseEmail').val();
			$('#responseEmailDiv').hide();
		}		
	});
	
	$('#AnswerAutoRespond').bind("change", function(event) {
		if($(this).is(":checked")) {
			$('#autoEmailDiv').show('fast');
		}else{
			$('#autoEmailDiv').hide();
		}		
	});
	
});
//]]>
</script>