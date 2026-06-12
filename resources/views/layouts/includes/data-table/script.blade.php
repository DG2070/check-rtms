@push('script')
    <script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>


    <script>
        $('#physical_progress_datatable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#physical_progress_datatable_wrapper .col-md-6:eq(0)');

        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

        /*
         *  Province Project List
         */
        var province_project_datatable = $('#province_project_list').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            // "info": true,
            "autoWidth": false,
            "responsive": true,
            // "buttons": ["excel", "pdf", "print", "colvis"],
            "scrollY": '56vh',
            dom: '<"top"i>rt<"bottom"flp><"clear">',
        });

        function provinceProjectSeachBox() {
            //remove default searchbox
            $("#province_project_list_filter").css("display", "none");
            $("#single_province_project_search_box").on("input", function() {
                console.log($('#single_province_project_search_box').val());
                province_project_datatable.search($('#single_province_project_search_box').val()).draw();
            });

            $("#single_province_project_search_box_button").on("click", function() {
                province_project_datatable.search($('#single_province_project_search_box').val()).draw();
            });
        }

        provinceProjectSeachBox();


        /*
         *  Search Everywhere Datatable
         */
        $('#search_everywhere_datatable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            // "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 20
            // "buttons": ["excel", "pdf", "print", "colvis"],
        });
    </script>
@endpush
