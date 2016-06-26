var $ = jQuery;
document.addEventListener("DOMContentLoaded", function(event) { 
    // Collect DOM objects
  	var editItemContainer = $('#sb-edit-item-container');
  	var socialButtonsList = $('#sb-list');
    var socialButtonPostData = $('#fssb_social_buttons_data');
    var submitForm = $('#fssb_submit_form').get(0);
  	var listItems = $(".sb-enable-checkbox").change(function () {
      var el = $(this);
      var inputCheckbox = el.get(0);
      var parentListItem = el.closest(".sb-item");
  		parentListItem.toggleClass('sb-disabled-item');
      console.log(parentListItem);
      var checked = (inputCheckbox.checked === true ? 1 : 0);
      socialButtons[parentListItem.attr('id')].enabled = checked;
      inputCheckbox.value = checked;
  	});
  	var editItem = function editItem($itemValues) {
  		 editItemContainer.show();
  	};
    // Init draggable list
  	var editableList = Sortable.create(socialButtonsList.get(0), {
  	animation: 150,
  	chosenClass: 'chosen-item',
  	filter: '.js-remove, .js-edit',
  	onFilter: function (evt) {
          var item = evt.item,
              ctrl = evt.target;
          if (Sortable.utils.is(ctrl, ".js-remove")) {  // Click on remove button
          	Ply.dialog("confirm", "Are you sure to remove social button")
  	    		.done(function (ui) {
                delete socialButtons[item.id];
  	        		item.parentNode.removeChild(item); // remove sortable item
  	    		})
  	    		.fail(function (ui) {
          			// Cancel
     				 });
          }
          else if (Sortable.utils.is(ctrl, ".js-edit")) {  // Click on edit link
            var currentButton = socialButtons[item.id];
             $.get(currentButton.shares_count_url, function(data, status){

                alert("Data: " + data + "\nStatus: " + status);
            });
          	 console.log(item.id);
          }
  	}
  	});

    // Bind event listeners
    if(submitForm.addEventListener){
      submitForm.addEventListener("submit", onFormSubmit, false);  //Modern browsers
    }else if(submitForm.attachEvent){
      submitForm.attachEvent('onsubmit', onFormSubmit);            //Old IE
    }
    function onFormSubmit(ev) {
        socialButtonPostData.val(JSON.stringify(socialButtons));
    };
});

