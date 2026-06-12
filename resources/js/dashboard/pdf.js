/** PDF EXPORT */
// window.jsPDF = window.jspdf.jsPDF;
import jsPDF from "jspdf";
$(function () {
    function generatePdf(
        table_id = "report_table",
        orientation = "portrait",
        noOfPdf = 1
    ) {
        $("#" + table_id + "-pdfContainer").removeClass("d-none");
        // $("#" + table_id).removeClass("table-responsive");
        // $(".largetable-scroller").css({
        //     overflowX: "visible",
        // });
        window.scrollTo(0, 0);

        for (let index = 1; index <= noOfPdf; index++) {
            showLoader(true);
            $("#" + table_id + "-" + index).removeClass("d-none");
            html2canvas(document.querySelector("#" + table_id + "-" + index))
                .then((canvas) => {
                    $("#" + table_id + "-" + index).addClass(
                        "table-responsive"
                    );
                    $(".largetable-scroller").css({
                        overflowX: "auto",
                    });

                    var dataUrl = canvas.toDataURL("image/png");

                    var pdfDOC;
                    if (orientation == "portrait") {
                        pdfDOC = new jsPDF();
                    } else if (orientation == "landscape") {
                        pdfDOC = new jsPDF("l", "px", "A4");
                    } else {
                        pdfDOC = new jsPDF();
                    }

                    const width = pdfDOC.internal.pageSize.getWidth();
                    let height = pdfDOC.internal.pageSize.getHeight();
                    const input = document.getElementById(
                        table_id + "-" + index
                    );
                    const divHeight = input.clientHeight;
                    const divWidth = input.clientWidth;
                    const ratio = divHeight / divWidth;

                    height = ratio * width;
                    pdfDOC.addImage(
                        dataUrl,
                        "PNG",
                        0,
                        30, // Adjust the top margin as needed
                        width ,
                        height - 50 // Adjust the bottom margin as needed
                    );
                    // pdfDOC.addImage(dataUrl, "JPEG", 1,1);
                    pdfDOC.save(index + "_export.pdf"); //Download the rendered PDF.

                    //-- Hide Table
                    $("#" + table_id + "-" + index).addClass("d-none");

                    if (index == noOfPdf) {
                        // hide loader
                        showLoader(false);
                    }
                })
                .catch((error) => {
                    console.log("Unable to export the report");
                    console.log(error);
                    //-- Hide Loader
                    $("#global-loader").addClass("d-none");
                });
        }
    }

    function getOrientation(newthis) {
        var orientation = "portrait";
        var pdf_direction = newthis.attr("data-pdf-orientation");
        if (pdf_direction == "portrait") {
            orientation = "portrait";
        }
        if (pdf_direction == "landscape") {
            orientation = "landscape";
        }
        return orientation;
    }

    function getChunkSize(newthis) {
        return newthis.attr("data-chunk-size") ?? 1;
    }

    function showLoader(show = false) {
        if (show) {
            //-- Show Loader
            $("#global-loader").removeClass("d-none");
        } else {
            //-- Hide Loader
            $("#global-loader").addClass("d-none");
        }
    }

    if ($(".export_pdf_btn")[0]) {
        $(".export_pdf_btn").on("click", function () {
            generatePdf("report_table", getOrientation($(this)));
        });
    }

    /**
     * For Internal Projects ( same page with different ids)
     */
    if ($(".export_pdf_btn-internal-target-report")[0]) {
        $(".export_pdf_btn-internal-target-report").on("click", function () {
            //-- Show Loader
            showLoader(true);
            generatePdf(
                "report_table-internal-target-report",
                getOrientation($(this)),
                getChunkSize($(this))
            );
        });
    }
    if ($(".export_pdf_btn-internal-progress-report")[0]) {
        $(".export_pdf_btn-internal-progress-report").on("click", function () {
            //-- Show Loader
            showLoader(true);
            generatePdf(
                "report_table-internal-progress-report",
                getOrientation($(this)),
                getChunkSize($(this))
            );
        });
    }
    if ($(".export_pdf_btn-internal-pme-final-report")[0]) {
        $(".export_pdf_btn-internal-pme-final-report").on("click", function () {
            //-- Show Loader
            showLoader(true);
            generatePdf(
                "report_table-internal-pme-final-report",
                getOrientation($(this)),
                getChunkSize($(this))
            );
        });
    }
});

//    html2canvas(document.querySelector("#" + table_id + "-" + index))
//        .then((canvas) => {
//            console.log("ok");
//            $("#" + table_id).addClass("table-responsive");
//            $(".largetable-scroller").css({
//                overflowX: "auto",
//            });

//            var dataUrl = canvas.toDataURL("image/png");
//            var pdfDOC;
//            if (orientation == "portrait") {
//                pdfDOC = new jsPDF();
//            } else if (orientation == "landscape") {
//                pdfDOC = new jsPDF("l");
//                // pdfDOC = new jsPDF("l", "px", "letter");
//            } else {
//                pdfDOC = new jsPDF();
//            }
//            const imgWidth = pdfDOC.internal.pageSize.getWidth();
//            const pageHeight = 290;
//            const imgHeight = (canvas.height * imgWidth) / canvas.width;
//            let heightLeft = imgHeight;
//            let position = 0;
//            pdfDOC.addImage(
//                dataUrl,
//                "PNG",
//                0,
//                position,
//                imgWidth,
//                imgHeight + 25
//            );
//            heightLeft -= pageHeight;
//            while (heightLeft >= 0) {
//                position = heightLeft - imgHeight;
//                pdfDOC.addPage();
//                pdfDOC.addImage(
//                    dataUrl,
//                    "PNG",
//                    0,
//                    position,
//                    imgWidth,
//                    imgHeight + 25
//                );
//                heightLeft -= pageHeight;
//            }
//            pdfDOC.save("export.pdf"); //Download the rendered PDF.
//            // -- Hide Loader
//            $("#global-loader").addClass("d-none");
//        })
//        .catch((error) => {
//            console.log("Unable to export the report");
//            console.log(error);
//            //-- Hide Loader
//            $("#global-loader").addClass("d-none");
//        });
