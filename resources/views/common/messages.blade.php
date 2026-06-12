<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<!-- Sweet Alert Laravel COnfirmation Try -->
<script>
    var deleter = {
        linkSelector: "a#delete-btn",
        init: function() {
            $(this.linkSelector).on('click', {
                self: this
            }, this.handleClick);
        },
        handleClick: function(event) {
            event.preventDefault();
            var self = event.data.self;
            var link = $(this);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3d4144',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    window.location = link.attr('href');
                } else {
                    Swal.fire("Cancelled", "Deletion Cancelled", "error");
                }
            })
        },
    };
    deleter.init();

    var deleter1 = {
        linkSelector: "a#cancel-order-btn",
        init: function() {
            $(this.linkSelector).on('click', {
                self: this
            }, this.handleClick);
        },
        handleClick: function(event) {
            event.preventDefault();
            var self = event.data.self;
            var link = $(this);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3d4144',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.value) {
                    window.location = link.attr('href');
                } else {
                    Swal.fire("Cancelled", "Order Cancellation Cancelled", "error");
                }
            })
        },
    };
    deleter1.init();
</script>

@if (session('success-v2'))
    <script>
        toastr.options.closeButton = true;
        toastr.options.positionClass = 'toast-bottom-right';
        toastr.options.progressBar = true;
        toastr.options.showDuration = 1000;
        toastr['success']("{{ session('success-v2') }}");
    </script>
@endif

@if (session('error-v2'))
    <script>
        toastr["error"]("{{ session('error-v2') }}", "error")
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>
@endif

<script>
    function displayMessage(type, message) {
        if (type == "success") {
            toastr.options.closeButton = true;
            toastr.options.positionClass = 'toast-top-right';
            toastr.options.showDuration = 1000;
            toastr['success'](message);
        }
        if (type == "error") {
            toastr["error"](message, "Error")
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        }

    }
</script>

<script type="text/javascript">
    function setLoading(status) {
        let loading = $('#loading-wrapper');
        status
            ?
            loading.removeClass('d-none') :
            loading.addClass('d-none');
    }
    setLoading(false);
</script>


<!-- Sweet Alert Laravel COnfirmation Try -->
<script>
    var deleter2 = {
        linkSelector: "a#featured_btn",
        init: function() {
            $(this.linkSelector).on('click', {
                self: this
            }, this.handleClick);
        },
        handleClick: function(event) {
            event.preventDefault();
            var self = event.data.self;
            var link = $(this);
            Swal.fire({
                title: 'Do you want to update the category featured status?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3d4144',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Update!'
            }).then((result) => {
                if (result.value) {
                    window.location = link.attr('href');
                } else {
                    Swal.fire("Cancelled", "Update Featured Cancelled", "error");
                }
            })
        },
    };
    deleter2.init();
</script>


<!-- Sweet Alert Laravel functions -->
<script>
    function showAlertV2(type, message) {
        switch (type) {
            case "error":
                toastr["error"](message, "error")
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                break;
            case "success":
                toastr.options.closeButton = true;
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.options.progressBar = true;
                toastr.options.showDuration = 1000;
                toastr['success'](message);
                break;

            default:
                break;
        }

    }
</script>
