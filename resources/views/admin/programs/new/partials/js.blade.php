<script>

</script>

<script>
    const projects = <?php echo json_encode($projects); ?>;
</script>
<script type="text/javascript">
    $(document).ready(function() {

        //    const selectedProgram = "{{ $selectedProgram ?? '' }}";
        //    const selectedProject = "{{ $selectedProject ?? '' }}";

        //    if (selectedProgram) {
        //        getProject(selectedProgram, selectedProject);
        //    }

        /**
         * Function to load project_select select with options
         *
         */
        function getProject(program_id, project_id = '') {
            let project = [];
            let html = `<option value="" selected>--SELECT PROJECT--</option>`;

            projects.forEach(prog => {
                if (prog.programID == program_id) {
                    if (project_id == prog.projectID) {
                        html +=
                            `<option value="${prog.projectID}" selected>${prog.Name} [ ${prog.TownName} ]</option>`;
                    } else {
                        html +=
                            `<option value="${prog.projectID}">${prog.Name} [ ${prog.TownName} ]</option>`;
                    }
                }
            });

            //add new options to project select
            $("select#project_select").html(html);

        }


        /**************Year************/
        $('#year_select').select2({
            closeOnSelect: true,
        });
        /**************PROGRAM************/
        $('#program_select').select2({
            closeOnSelect: true,
            escapeMarkup: function(markup) {
                return markup;
            },
            language: {
                noResults: function() {
                    return '<button style="width: 100%" type="button" class="btn btn-primary" data-toggle="modal" data-target="#createNewProgramModal">+ Add New Program</button>';
                }
            },
        });

        //on new program selected / changed to another program
        $('#program_select').on('select2:select', function(e) {
            //show projects that belong to program
            getProject(e.params.data.id, null);
            //change modal program id
            $('#new_project_programid_modal-f').val(e.params.data.id);

        });

        /**************PROJECT**************/
        $('#project_select').select2({
            closeOnSelect: true,
            escapeMarkup: function(markup) {
                return markup;
            },
            language: {
                noResults: function() {
                    return '<button style="width: 100%" type="button" class="btn btn-primary"  data-toggle="modal" data-target="#createNewProjectModal">+ Add New Project</button>';
                }
            },
        });


        //if program is empty show all projects
        /**
         * Show all projects if program select is not selected ie empty
         */
        function showAllProjects() {
            // console.log("show");
            // console.log($("#program_select").val());
            if ($("#program_select").val() == null || $("#program_select").val() == "") {

                let html = `<option value="" selected>--SELECT PROJECT--</option>`;

                projects.forEach(prog => {
                    html += `<option value="${prog.projectID}">${prog.Name}</option>`;
                });

                ///remove old options
                // $('#project_select').find('option').remove().end();
                //remove old & add new options to project select
                $("select#project_select").html(html);


            } else {
                //show projects that belong to program
                getProject($("#program_select").val(), {{ request('projectID') }});
            }
        }
        showAllProjects();

        //check if



    });
</script>

<script>
    // function checkIf
</script>


<script type="text/javascript">
    $(document).ready(function() {

        function activateTabByRequest() {
            var tabID = "#activities_milestones"; //default tab
            @if (!empty(request('tab_selected')))
                tabID = "{{ request('tab_selected') }}"
            @endif
            $('a[href="' + tabID + '"]').tab('show');
        }

        activateTabByRequest();


        $(".tdf_tab").on("click", function() {
            var tabValue = $(this).attr("href");
            if (tabValue != null) {
                $("#tab_selected").val(tabValue);
                $(".quater_tab_selected").val(tabValue);
                //set url params for tab_selected
                setGetParam("tab_selected", tabValue)

            }
            // console.log($("#tab_selected").val());
        });


        // https://stackoverflow.com/a/50861534
        function setGetParam(key, value) {
            if (history.pushState) {
                var params = new URLSearchParams(window.location.search);
                params.set(key, value);
                var newUrl = window.location.origin +
                    window.location.pathname +
                    '?' + params.toString();
                window.history.pushState({
                    path: newUrl
                }, '', newUrl);
            }
        }

        /**
         * Button Click Triggers
         */
        $('#activity_milestone_btn').on("click", function() {
            console.log("Fetching milesone");

            var program_id = $('#program_select').val();
            var project_id = $('#project_select').val();

            console.log(program_id);
            console.log(project_id);

            // fetchActivityMilestonePage
            // Ajax Call
            // $.ajax({
            //     url: "{{ route('ajax.view.activity-milestone') }}",
            //     method: "POST",
            //     data: $('#form-select-data').serialize(),
            //     success: function (data) {
            //         $('#product-listing-row').html(data);
            //     }
            // });

            $.ajax({
                url: "{{ route('ajax.view.activity-milestone') }}",
                type: "POST",
                data: $('#form-select-data').serialize(),
                success: function(response) {

                    console.log(response);
                    if (response) {
                        if (response.success) {
                            $('#content_container').html(response.view);
                        } else {
                            showAlertV2("error", response.error);
                            // alert(response.message);
                            $('#content_container').html(response);
                        }
                    }

                },
                error: function(response) {
                    // showAlertV2("error", response.error);
                    alert('error');
                    console.log(response);
                }
            });

            // fetchActivityMilestonePage();
        });

        // function fetchActivityMilestonePage() {

        // }

    });
</script>
