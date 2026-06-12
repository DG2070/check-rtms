$(".pme_radio_input").on("click", function () {
    console.log("loaded");
    var current_radio_data_is_checked = $(this).attr("data-is-checked");

    var milestone_id = $(this).attr("data-milestone-id");
    var current_radio_value = $(this).val();

    /* Checking if the radio button is checked or not.  If it is checked, it will uncheck it. */
    if (current_radio_data_is_checked.toString() === "true") {
        console.log("uncheck it");
        //-- Uncheck Radio
        $(this).prop("checked", false);
        $(this).attr("data-is-checked", false);

        if (current_radio_value == "achived") {
            $("#not_achived_pme_radio_input_" + milestone_id).attr(
                "data-is-checked",
                false
            );
        }
        if (current_radio_value == "not_achived") {
            $("#achived_pme_radio_input_" + milestone_id).attr(
                "data-is-checked",
                false
            );
        }
    }

    /* Checking if the radio button is checked or not. If it is not checked, it will check it. */
    if (current_radio_data_is_checked.toString() === "false") {
        console.log("check it");
        //-- Uncheck Radio
        $(this).prop("checked", true);
        $(this).attr("data-is-checked", true);

        if (current_radio_value == "achived") {
            $("#not_achived_pme_radio_input_" + milestone_id).attr(
                "data-is-checked",
                false
            );
        }
        if (current_radio_value == "not_achived") {
            $("#achived_pme_radio_input_" + milestone_id).attr(
                "data-is-checked",
                false
            );
        }
    }
});
