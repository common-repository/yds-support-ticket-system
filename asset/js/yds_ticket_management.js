(function($)
{
	getCategory();
	getPriority();
	/*Create Ticket By Admin */
	$('#createbyadminNewticket').submit(function(e)
	{
		$('.msgerror').html('');
		var support_subject=$('#support_subject').val();
		var ydsts_category=$('#ydsts_category').val();
		var yds_priorityid=$('#yds_priorityid').val();
		var textmsg=$('#textmsg').val();
		var redirectUrl=$('#redirectUrl').val();
		var user_list=$('#user_list').val();
		if(user_list=='')
		{
		    $('#error_user').html("Please select a user");
			$('#user_list').focus();
			e.preventDefault();
		}else if(ydsts_category=='')
		{
			$('#error_cat').html("Please select support category");
			$('#ydsts_category').focus();
			e.preventDefault();
		}else if(yds_priorityid=='')
		{
			$('#error_priority').html("Please select priority");
			$('#yds_priorityid').focus();
			e.preventDefault();
		}else if(support_subject=='')
		{
			$('#error_sub').html("Please insert your subject");
			$('#support_subject').focus();
			e.preventDefault();
		}else if(textmsg=='')
		{
			$('#error_textmsg').html("Please insert text message");
			$('#textmsg').focus();
			e.preventDefault();
		}else 
		{
			$('.wait').show();
			 $.ajax({
            url: ydsts_ajax_data.ydsts_ajax_url,
            type: 'POST',
	        data: new FormData(this),
	        processData: false,
	        contentType: false
           }).done(function(response){
			  $('#createbyadminNewticket').get(0).reset();
		      $(location).attr('href',redirectUrl);
			  $('.wait').hide();
		  });
         e.preventDefault();
		}
	});
	/*Create Categories By Admin */
	$('#createsupportCategories').submit(function(e)
	{
		   $.ajax({
            url: ydsts_ajax_data.ydsts_ajax_url,
            type: 'POST',
	        data: new FormData(this),
	        processData: false,
	        contentType: false
           }).done(function(response){
			   location.reload();
			   });
             e.preventDefault();
	});
	$('#addPriorityForm').submit(function(e)
	{
		   $.ajax({
            url: ydsts_ajax_data.ydsts_ajax_url,
            type: 'POST',
	        data: new FormData(this),
	        processData: false,
	        contentType: false
           }).done(function(response){
		   location.reload();
      });
         e.preventDefault();
	});
	$('#filterForm').submit(function(e)
	{
		   $.ajax({
            url: ydsts_ajax_data.ydsts_ajax_url,
            type: 'POST',
	        data: new FormData(this),
	        processData: false,
	        contentType: false
           }).done(function(response){
			  $('.ticketDetail').html(response); 
			   });
             e.preventDefault();
	});
	/*editcatForm*/
})(jQuery);
function getCategory()
{
	var data={'action':'displayCat'};
	jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
	jQuery('#displayadminCat').html(response);
	});
}
/*Start PRIORITY Manegment*/
function getPriority()
{
	var data={'action':'displayPriority'};
	jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
       jQuery('#priorityList').html(response);
    });
}
function editPriority(priorityId)
{
  jQuery('#editPriorityrow'+priorityId).show();
  jQuery('#showPriorityrow'+priorityId).hide();	
}

function updatePriority(e,object)
{
	jQuery.ajax( {
    url: ydsts_ajax_data.ydsts_ajax_url,
    type: 'POST',
    data: new FormData(object),
    processData: false,
    contentType: false
   }).done(function(response) {
     	getPriority();
});
	e.preventDefault();
}

function priorityStatus(priorityId,priorityStatus)
{
	var data={'action':'updatepriorityStatus','priorityId':priorityId,'priorityStatus':priorityStatus};
	jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
	  getPriority();
	});
}
function deletPriority(priorityId)
{
	var data = {
		'action': 'deletePriority',
		'priorityId':priorityId
	};
	jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
              getPriority();
	});
}

/*End PRIORITY Manegment*/
function ticketPagination(page_no)
{
	var data = {
		'action': 'getTicketpage',
		'page_number': page_no
	};
  jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
       jQuery('.ticketDetail').html(response);
   });
}

function viewticketDetail(ticket_id)
{
        var data = {
		'action': 'ticketDetail',
		'ticket_id': ticket_id
	};
	jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
            jQuery('#ticketContainer').html(response);
	});
}
function deleteTicket(ticket_id)
{
	var data = {
		'action': 'deleteadTicket',
		'ticket_id':ticket_id
	};
	jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
       jQuery('.ticketDetail').html(response);
	});
}
/* Closed Ticket */

function closeTicket(ticket_id)
{
	
	var data = {
		'action': 'ydscloseTicket',
		'ticket_id':ticket_id
	};
	jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
	   viewticketDetail(ticket_id);
	});
}


function deletCat(catId)
{
	var data = {
		'action': 'deleteCategory',
		'catId':catId
	};
	jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
              getCategory();
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
			viewticketDetail(ticket_id);
			jQuery('.wait_replyticket').hide();
  });
	  e.preventDefault();
     }
}
function getUserticket()
{
	$('.wait_ticket').show();
	var data={'action':'getticketByuser'};
	jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {
		       $('.wait_ticket').hide();
              jQuery('#mytickets').html(response);
	});
}
function editCategory(e,object)
{
	jQuery.ajax( {
	      url: ydsts_ajax_data.ydsts_ajax_url,
	      type: 'POST',
	      data: new FormData(object),
	      processData: false,
	      contentType: false
	    }) 
	    .done(function(response) {
			getCategory();
	    });
	e.preventDefault();
}

function editCat(catId)

{

	jQuery('#showCatrow'+catId).hide();

	jQuery('#editCatrow'+catId).show();

}

function categoryStatus(cat_id,cat_status)

{

	var data={'action':'upcategoryStatus','cat_id':cat_id,'cat_status':cat_status};

	jQuery.post(ydsts_ajax_data.ydsts_ajax_url, data, function(response) {

		      getCategory();

	});

}

/*Add Form Dynamic*/

(function($)

{
	    /* Add Categories Field */
        var catDiv = $('#catfieldContainer');
        var i=1;
        i++;
        $('#addcatField').live('click', function() {
                $('<tr><td><span class="dashicons dashicons-minus cursorPointer" id="removecatField"></span></td><td>Add Category</td><td><input rel-id="'+i+'" type="text" class="yds_cat1" size="20" name="fieldValue[yds_cat'+ i+']" value="" placeholder="Issue Value" /></td> </tr>').appendTo(catDiv);
                i++;
              return false;
   });
    $('#removecatField').live('click', function() { 
            if( i > 2 ) {
                  $(this).parents('tr').remove();
                  i--;

       }
            return false;

 });

   /* Add Priority Field */

		
        var p=1;
        p++;
        $('#addprField').live('click', function() {

                $('<tr><td></td><td>Add Priority</td><td><input rel-id="'+p+'" type="text" class="yds_cat1" size="20" name="fieldValue[addprField'+ p+']" value="" placeholder="Issue Value" /></td> <td><span class="dashicons dashicons-minus cursorPointer" id="removeprField"></span></td></tr>').appendTo('#priorityfieldContainer');

                p++;

                return false;

        });
        $('#removeprField').live('click', function() { 
                if( p > 2 ) {

                        $(this).parents('tr').remove();

                        p--;

                }

                return false;

        });

		
 

})(jQuery);
/*Add More Attachement */
    var j=1;
    j++;
 function addMoreattach(e,obj)
    {
         jQuery('<div class="attachment-row" style="display: block; clear: both; "><label>&nbsp;</label><input name="attachment[]" id="attachfile" type="file"><span class="dashicons dashicons-minus cursorPointer" id="removemoreAttachment" onclick="removeMoreattach(event);"></span></div>').appendTo('#multipleAttachement');

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
 (function($){

    $( "#tabs" ).tabs();

  })(jQuery);