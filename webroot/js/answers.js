<script type="text/javascript">
//<![CDATA[

var tokens = [];

$(document).ready(function () {
	
	$('#formOptionContent').children('div').not('.active').hide('slow');
	
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
	
	$('#target').on('change', '.popover-content #id', function(e) {
		var id = $(this).val();
		id = id.replace(" ", "_");
		$(this).val(id);
		var index = $.inArray(id, tokens);
		if(index != -1) {
			tokens[index] = id;
		}else {
			tokens.push(id);
		}
		refreshToken();
	});
	
	$('#formOptionNav li a').bind('click', function(e) {
		//hide all
		$('#formOptionContent').children('div').hide('slow');
		
		var pane = $(this).attr('href');
		$(pane).show('slow');
	});
	
	$('.token-choices').on('click', 'a', function(e) {
		e.preventDefault();
		var el = $(this).closest('.token-choices').prev('textarea').prop('id');
		var token = $(this).data('token');
		token = '*| '+token+' |*';
		repTokens(token,el);
		
	});
	
	//Below is code not used yet
	
	// $("#target").on("click", '#id', function(event){
  		// var model = $('#modelSelect').val();
  		// console.log(model);
  		// if(model !== 'Answer') {
  			// var item = $(this);
	  		// item.css('display', 'none');
		  		// $.ajax({
		  			// type: "POST",
		  			// url: "/answers/answers/getColumns",
		  			// data: { plugin: $('#modelSelect').val() }
						// }).done(function( returnhtml ) {
		  				// item.before(returnhtml);
					// });
			// }
		// return false;
	// });
// 	
	// $('#propertySelect').bind("change", function (event) {
		// $(this).next('#id').val($(this.val()));
	// });
	
});

function refreshToken() {
	var choices = '<ul class="token-nav">';
	for(var i=0 ; i<tokens.length ; i++) {
		choices += '<li><a href="#" data-token="'+tokens[i]+'">'+tokens[i]+'</a></li>';
	}
	choices += '</ul>'
	$('.token-choices').html(choices);
}

function repTokens(textValue, id) {
        //Get textArea HTML control 
        var txtArea = document.getElementById(id);
        
        //IE
        if (document.selection) {
            txtArea.focus();
            var sel = document.selection.createRange();
            sel.text = textValue;
            return;
        }
        
        //Firefox, chrome, mozilla
        else if (txtArea.selectionStart || txtArea.selectionStart == '0') {
            var startPos = txtArea.selectionStart;
            var endPos = txtArea.selectionEnd;
            var scrollTop = txtArea.scrollTop;
            txtArea.value = txtArea.value.substring(0, startPos) + textValue + txtArea.value.substring(endPos, txtArea.value.length);
            txtArea.focus();
            txtArea.selectionStart = startPos + textValue.length;
            txtArea.selectionEnd = startPos + textValue.length;
        }
        else {
            txtArea.value += textArea.value;
            txtArea.focus();
        }
}
//]]>
</script>