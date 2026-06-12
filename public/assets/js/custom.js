// Delete row from table
$("body").on("click", ".delete-row", function(e) {
    e.preventDefault();
    var target = this;
    if (confirm("Do you really want to delete this row")) {
        $(target).closest('form').submit();

    }
})

//Change status of row from table (switch)
$('.change-status').click(function(e) {
    var url = $(this).data('action');
    var status;
    if ($(this).prop('checked') == true) {
        status = 1;
    } else {
        status = 0;
    }
    $.ajax({
        url: url,
        data: {
            status: status
        },
        success: function(result) {
            if (!result) {
                alert("Error while changing status.")
            }
        }
    })
});

//Nepali date in navbar
$(document).ready(function() {
    $('.current-date').html(NepaliFunctions.GetBsFullDate(NepaliFunctions.GetCurrentBsDate(), true))
    // console.log(NepaliFunctions.GetBsFullDate(NepaliFunctions.GetCurrentBsDate(),true))
});
