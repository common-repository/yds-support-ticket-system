(function($)
{
	
		$('.ragister-link').click(function(){
 		$('.yds_form#yds_registration_form').show();
		$('.yds_form#yds_login_form').hide();
		return false;
		});
	
GetUserTicket();
 
$('#ydstsviewTickets').click(function()
{
	GetUserTicket();
});

$('#createTicketForm').click(function()
{
	var imgsrc=$('.wait').html();
	$('#createTicket').html(imgsrc);
	var data = {
		'action': 'showcreateTicketForm',
		
	};
	$.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
		
              $('#createTicket').html(response);
	});
	
});

$('#editProfileForm').click(function()
{
	var imgsrc=$('.wait').html();
	$('#editProfile').html(imgsrc);
	var data = {
		'action': 'showeditProfileForm',
		
	};
	$.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
		
              $('#editProfile').html(response);
	});
	
});

/*Custome Login Jquery*/

$('#yds_login_form').submit(function(e)
  { 
      var loginredirectUrl=$('#loginredirectUrl').val();
      $.ajax({
          url: ydsts_ajax_data.ydsts_ajax_url,
          type: 'POST',
	    data: new FormData(this),
	    processData: false,
	    contentType: false
           }).done(function(msg) {
			        if(msg==1)
                    {
                      $(location).attr('href',loginredirectUrl);
                    }else 
                    {
                        $('.loginError').html(msg);
                    }
		     
		    });
      e.preventDefault();
  
  });
  
  
  $('#yds_registration_form').submit(function(e)
  {
	  $('.regError').html('');
	  var nameRegex = /^[A-Za-z]+$/; 
	  var yds_user_name=$('#yds_user_name').val();
	  var yds_user_email=$('#yds_user_email').val();
	  var validEmail=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;	
	  var yds_user_first=$('#yds_user_first').val();
	  var yds_user_last=$('#yds_user_last').val();
	  var yds_user_regpass=$('#yds_user_regpass').val();
	  var yds_user_pass_confirm=$('#yds_user_pass_confirm').val();
	  var redirectUrl=$('#redirectUrl').val();
	  if(!nameRegex.test(yds_user_name))
	  {
		$('#loginregError').html('Please enter your user name only character');  
		$('#yds_user_name').focus();
		e.preventDefault();
	  }else if(!validEmail.test(yds_user_email))
	  {
		 $('#emailregError').html('Please enter vailed mail id');  
		 $('#yds_user_email').focus();
		 e.preventDefault(); 
	  }else if(!nameRegex.test(yds_user_first))
	  {
		 $('#fnameregError').html('Please enter your first name');  
		 $('#yds_user_first').focus();
		 e.preventDefault(); 
	  }else if(!nameRegex.test(yds_user_last))
	  {
		 $('#lnameregError').html('Please enter your first name');  
		 $('#yds_user_last').focus();
		 e.preventDefault(); 
	  }else if(yds_user_regpass=='')
	  {
		 $('#passregError').html('Please enter your password');  
		 $('#yds_user_regpass').focus();
		 e.preventDefault(); 
	  }else if(yds_user_pass_confirm=='')
	  {
		 $('#againpassregError').html('Please enter your password again');  
		 $('#yds_user_pass_confirm').focus();
		 e.preventDefault(); 
	  }else if(yds_user_regpass!=yds_user_pass_confirm)
	  {
		 $('#againpassregError').html('Please enter same Value');  
		 $('#yds_user_pass_confirm').focus();
		 e.preventDefault(); 
	  }else 
	  {
	  $.ajax({
          url: ydsts_ajax_data.ydsts_ajax_url,
          type: 'POST',
	    data: new FormData(this),
	    processData: false,
	    contentType: false
           }).done(function(msg) {
			  			   
			   if(msg==1)
			   {
				   $('#loginregError').html('This username already exists');  
		           $('#yds_user_name').focus();
			   }else if(msg==2)
			   {
				   $('#emailregError').html('This mail id already exists');  
		           $('#yds_user_email').focus();
			   }else 
			   {
                 $(location).attr('href',redirectUrl);
			   }
		     
		    });
          e.preventDefault();
	  }
	  
  });
  
 $( "#yds_tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
 $( "#yds_tabs li" ).removeClass( "ui-corner-top" ).addClass("ui-corner-left");

})(jQuery);


function viewticketonFront(ticket_id)
{
	var data = {
		'action': 'ticketFrontdetail',
		'ticket_id':ticket_id
	};
	jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
		
              jQuery('#mytickets').html(response);
	});
}

/* Get User Ticket */

function GetUserTicket()
{
	
	var imgsrc=jQuery('.wait').html();
	jQuery('#viewTickets').html(imgsrc);
	var data = {
		'action': 'getUsertkt',
	};
	jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
		
		     jQuery('#viewTickets').html(response);
		      
		     
              
	});
}

/* Pagination */

function userticketPagination(page_no)
{
	
	var data = {
		'action': 'getfrontTicketpage',
		'page_number': page_no
	};
	jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
		
              jQuery('#viewTickets').html(response);
	});
}

/*Add More Attachement */

          var j=1;
          j++;

		function addMoreattach(e,obj)
		{
			
		
                jQuery('<div class="attachment-row" style="display: block; clear: both; "><input name="attachment[]" id="attachfile" type="file"><span class="dashicons dashicons-minus cursorPointer" id="removemoreAttachment" onclick="removeMoreattach(event);"></span></div>').appendTo('#multipleAttachement');
				j++;
               e.preventDefault();
        
		}
        function removeMoreattach(e){
			
			
			    if( j > 2 ) {
                        jQuery('#removemoreAttachment').parents('.attachment-row').remove();
                        j--;
                }
                e.preventDefault();
        }
		
		function addfMoreattach(e,obj)
		{
			
		
                jQuery('<div class="attachment-row" style="display: block; clear: both; "><label>&nbsp;</label><input name="attachment[]" id="attachfile" type="file"><span class="dashicons dashicons-minus cursorPointer" id="removekoissueFField" onclick="removefMoreattach(event);"></span></div>').appendTo('#multiplefAttachement');
				j++;
               e.preventDefault();
        
		}
        function removefMoreattach(e,obj){
			
			
			    if( j > 2 ) {
                        jQuery('#removekoissueFField').parents('.attachment-row').remove();
                        j--;
                }
                e.preventDefault();
        }
		
		function viewticketonFront(ticket_id)
		  {
			  
				  var data = {
				  'action': 'ticketFrontdetail',
				  'ticket_id': ticket_id
			  };
			  jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
				  
						jQuery('#viewTickets').html(response);
			  });
		  }
		  
		  function replyTicket(e,object)
			{
				var textmsg=jQuery('#textmsg').val();
				if(textmsg=='')
				{
					jQuery('#msgerror_error').html("messages body can't not empty");
					e.preventDefault();
				}else {				
				jQuery('.wait_replyticket').show();
				var ticket_id=jQuery('#ticket_id').val();
				jQuery('.wait_replyticket').show();
				jQuery.ajax( {
					  url: ydsts_ajax_data.ydsts_ajax_url,
					  type: 'POST',
					  data: new FormData(object),
					  processData: false,
					  contentType: false
					}) 
					.done(function(response) {
						viewticketonFront(ticket_id);
						jQuery('.wait_replyticket').hide();
						
					});
				e.preventDefault();
				}
			}
			
			/*Create New Ticket By User*/
 function submitTicketByUser(e,object)
	{
		jQuery('.msgerror').html('');
		var ydsts_category=jQuery('#ydsts_category').val();
		var yds_priorityid=jQuery('#yds_priorityid').val();
		var support_subject=jQuery('#support_subject').val();
		var textmsg=jQuery('#textmsg').val();
		
		if(ydsts_category=='')
		{
			jQuery('#error_cat').html("Please select support category");
			jQuery('#ydsts_category').focus();
			e.preventDefault();
		}else if(yds_priorityid=='')
		{
			jQuery('#error_priority').html("Please select priority");
			jQuery('#yds_priorityid').focus();
			e.preventDefault();
		}else if(support_subject=='')
		{
			jQuery('#error_sub').html("Please insert your subject");
			jQuery('#support_subject').focus();
			e.preventDefault();
		}else if(textmsg=='')
		{
			jQuery('#error_textmsg').html("Please insert text message");
			jQuery('#textmsg').focus();
			e.preventDefault();
		}else 
		{
			jQuery('.wait').show();
		    jQuery.ajax({
            url: ydsts_ajax_data.ydsts_ajax_url,
            type: 'POST',
	        data: new FormData(object),
	        processData: false,
	        contentType: false
               
           }).done(function(response){
			   
			jQuery('#submitUsertktform' ).get(0).reset();
			jQuery('#ydstsviewTickets').trigger('click');
			jQuery('.wait').hide();
			 
		  });
             e.preventDefault();
		}
	}
/*END*/

/* Update Profile */
  function ydsUpdateUserDetail(e,object)
	{
		jQuery.ajax({
            url: ydsts_ajax_data.ydsts_ajax_url,
            type: 'POST',
	        data: new FormData(object),
	        processData: false,
	        contentType: false
               
           }).done(function(response){
			   
			 jQuery('.profileUpdated').html(response);
			   
			jQuery('#editProfileForm').trigger('click');
			
			 
		  });
             e.preventDefault();
	}
