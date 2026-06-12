// $(function () {
//     /**
//      *   For Home Filters
//      */

//     // Select2 setups
//     $(".dashboard_filter_select2").select2({
//         closeOnSelect: true,
//     });

//     //change district when province changed
//     $("#dashboard_filter_province_select").on("change", function () {
//         var province_code = $("#dashboard_filter_province_select").val();
//         // console.log(province_code);
//         //get all district for province selected.
//         $.ajax({
//             url: "/api/province/" + province_code + "/district",
//             success: function (result) {
//                 // console.log(result);
//                 if (!result) {
//                     alert("Error while fetching district.");
//                 }
//                 var districts = result;
//                 $("#dashboard_filter_district_select")
//                     .find("option")
//                     .remove()
//                     .end();
//                 $("#dashboard_filter_district_select").append(
//                     $("<option>", {
//                         value: null,
//                         text: "--SELECT DISTRICT--",
//                         selected: true,
//                         disabled: true,
//                     })
//                 );
//                 districts.forEach((district) => {
//                     //add district name on select
//                     $("#dashboard_filter_district_select").append(
//                         $("<option>", {
//                             value: district,
//                             text: district,
//                         })
//                     );
//                 });
//             },
//         });
//     });

//     //change town when district changed
//     $("#dashboard_filter_district_select").on("change", function () {
//         var province_code = $("#dashboard_filter_province_select").val();
//         // console.log(province_code);
//         // console.log($(this).val());

//         //change api_endpoint depending on province_code
//         var api_endpoint = "/api/town-by-district";
//         if (province_code != null) {
//             api_endpoint = "/api/town-by-district-province";
//         }

//         //get all district
//         $.ajax({
//             method: "POST",
//             url: api_endpoint,
//             data: {
//                 district_name: $(this).val(),
//                 province_code: province_code,
//             },
//             success: function (result) {
//                 // console.log(result);
//                 if (!result) {
//                     alert("Error while fetching town names.");
//                 }
//                 var towns = result;
//                 $("#dashboard_filter_town_select")
//                     .find("option")
//                     .remove()
//                     .end();
//                 $("#dashboard_filter_town_select").append(
//                     $("<option>", {
//                         value: null,
//                         text: "--SELECT TOWN--",
//                         selected: true,
//                         disabled: true,
//                     })
//                 );
//                 towns.forEach((district) => {
//                     //add district name on select
//                     $("#dashboard_filter_town_select").append(
//                         $("<option>", {
//                             value: district,
//                             text: district,
//                         })
//                     );
//                 });
//             },
//         });
//     });

//     function getStats() {}
// });
