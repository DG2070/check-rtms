require("./home");
// require("./loader");
require("./program");
require("./export");
require("./pdf");
require("./flow");

/**Number Format to NP money format*/

$(".number_format").each(function (i, obj) {
    if (Number.isInteger(parseInt($(this).html()))) {
        $(this).html(parseInt($(this).html()).toLocaleString("en-NP"));
    }
});

$(".progress").each(function () {
    var value = $(this).attr("data-value");
    var left = $(this).find(".progress-left .progress-bar");
    var right = $(this).find(".progress-right .progress-bar");

    if (value > 0) {
        if (value <= 50) {
            right.css(
                "transform",
                "rotate(" + percentageToDegrees(value) + "deg)"
            );
        } else {
            right.css("transform", "rotate(180deg)");
            left.css(
                "transform",
                "rotate(" + percentageToDegrees(value - 50) + "deg)"
            );
        }
    }
});

function percentageToDegrees(percentage) {
    return (percentage / 100) * 360;
}

/**
 * For Report month/quater filter select field
 */

$("#report-month-filter").select2({
    closeOnSelect: true,
});
$(".report-month-filter").select2({
    closeOnSelect: true,
});

/**
 *  Quater filter component reselect all options
 */
// console.log($("#reset_filters"));

$(".reset_quater_filters").on("click", function () {
    console.log("clicked");
    $(".report-month-filter")
        .select2("destroy")
        .find("option")
        .prop("selected", "selected")
        .end()
        .select2();
});

// document.getElementById("total_disbursement_amount").innerHTML =
//     number.toLocaleString("en-NP");

import Vue from "vue";
Vue.config.productionTip = false;

// import vuetify from "./vuetify";

import axios from "axios";
Vue.prototype.$axios = axios;

import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
Vue.use(VueToast);

// let token = document.head.querySelector('meta[name="csrf-token"]');

// if (token) {
//     window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
// } else {
//     // console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }

// Register Vue Components
Vue.component(
    "flow-set-target-milestone",
    require("./components/FlowMilestoneDragabble.vue").default
);

var myEle = document.getElementById("vue-for-milestone-draggable");
if (myEle) {
    // Initialize Vue
    const app = new Vue({
        el: "#vue-for-milestone-draggable",
        // vuetify,
    });
}
