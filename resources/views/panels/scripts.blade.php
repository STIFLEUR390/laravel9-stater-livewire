<!-- BEGIN: Vendor JS-->
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="{{asset(mix('vendors/js/ui/jquery.sticky.js'))}}"></script>
@yield('vendor-script')
<script src="{{ asset('extension/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('extension/toastr.min.js') }}"></script>

<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>

<!-- custome scripts file for user -->
<script src="{{ asset(mix('js/core/scripts.js')) }}"></script>

@if($configData['blankPage'] === false)
<script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
@endif
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
<script>
    (function(window, document, $) {
        'use strict';
        var select = $('.select2'),
            selectIcons = $('.select2-icons'),
            maxLength = $('.max-length'),
            hideSearch = $('.hide-search'),
            selectArray = $('.select2-data-array'),
            selectAjax = $('.select2-data-ajax'),
            selectLg = $('.select2-size-lg'),
            selectSm = $('.select2-size-sm'),
            selectInModal = $('.select2InModal');

        select.each(function() {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                // the following code is used to disable x-scrollbar when click in select input and
                // take 100% width in responsive also
                dropdownAutoWidth: true,
                width: '100%',
                dropdownParent: $this.parent()
            });
        });
    })(window, document, jQuery);
</script>

{{-- Toast notification --}}
<script>
    @if (Session::has('message') && Session::get('type') == 'toast')
        var type_message = "{{ Session::get('alert-type', 'info') }}";
        var o = "rtl" === $("html").attr("data-textdirection");
        $(function() {
            "use strict";

            switch (type_message) {
                case 'info':
                    toastr.info(
                        "{{ Session::get('message') }}",
                        "{{ config('dev-master.name') }}", {
                            closeButton: true,
                            tapToDismiss: false,
                            progressBar: true,
                            timeOut: 5000,
                        }
                    );
                    break;
                case 'success':
                    toastr.success(
                        "{{ Session::get('message') }}",
                        "{{ config('dev-master.name') }}", {
                            closeButton: true,
                            tapToDismiss: false,
                            progressBar: true,
                            timeOut: 5000,
                        }
                    );
                    break;
                case 'warning':
                    toastr.warning(
                        "{{ Session::get('message') }}",
                        "{{ config('dev-master.name') }}", {
                            closeButton: true,
                            tapToDismiss: false,
                            progressBar: true,
                            timeOut: 5000,
                        }
                    );
                    break;
                case 'error':
                    toastr.error(
                        "{{ Session::get('message') }}",
                        "{{ config('dev-master.name') }}", {
                            closeButton: true,
                            tapToDismiss: false,
                            progressBar: true,
                            timeOut: 5000,
                        }
                    );
                    break;
            }
        })
    @endif
</script>

{{-- sweet-alert confirm deletion --}}

<script>
    $(function() {
        var $confirmColor = $(".deleteElement");
        if ($confirmColor.length) {
            $confirmColor.on('click', function(e) {
                e.preventDefault();

                // console.log(e.currentTarget.attributes.id.nodeValue);

                Swal.fire({
                    title: '{{ __('Are you sure?') }}',
                    text: '{{ __("You won't be able to revert this!") }}',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ __('Yes, delete!') }}",
                    cancelButtonText: "{{ __('Cancel') }}",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        /* Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Your file has been deleted.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        }); */
                        $("#" + e.currentTarget.attributes.id.nodeValue).prev().closest('form')
                            .submit();
                    }
                    /* else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: "Cancelled",
                            text: "{{ __('Your data is safe :)') }}",
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    } */
                });
            })
        }
    })
</script>

{{-- sweet-alert notification --}}
<script>
    @if (Session::has('message') && Session::get('type') == 'sweet')
        var type_message = "{{ Session::get('alert-type', 'info') }}";
        var o = "rtl" === $("html").attr("data-textdirection");
        $(function() {
            "use strict";

            switch (type_message) {
                case 'info':
                    Swal.fire({
                        title: '{{ config('dev-master.name') }}',
                        text: '{{ Session::get('message') }}',
                        icon: "info",
                        // type: 'info',
                        showCancelButton: false,
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-danger",
                        },
                        timer: 5000
                    })
                    break;
                case 'success':
                    Swal.fire({
                        title: '{{ config('dev-master.name') }}',
                        text: '{{ Session::get('message') }}',
                        icon: "success",
                        // type: 'info',
                        showCancelButton: false,
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-danger",
                        },
                        timer: 5000
                    })
                    break;
                case 'warning':
                    Swal.fire({
                        title: '{{ config('dev-master.name') }}',
                        text: '{{ Session::get('message') }}',
                        icon: "warning",
                        // type: 'info',
                        showCancelButton: false,
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-danger",
                        },
                        timer: 5000
                    })
                    break;
                case 'error':
                    Swal.fire({
                        title: '{{ config('dev-master.name') }}',
                        text: '{{ Session::get('message') }}',
                        icon: "error",
                        // type: 'info',
                        showCancelButton: false,
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-danger",
                        },
                        timer: 5000
                    })
                    break;
            }
        })
    @endif
</script>

{{-- Datatable --}}
<script>
    @if (config('app.locale') == 'fr')
        $(function() {
            'use strict';
            var dt_basic_table = $('.datatables-basic'),
                dt_filter_table = $('.dt-column-search');

            if (dt_basic_table.length) {
                dt_basic_table.DataTable({
                    dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data();
                                    return 'Details of ' + data['full_name'];
                                }
                            }),
                            type: 'column',
                            renderer: function(api, rowIdx, columns) {
                                var data = $.map(columns, function(col, i) {
                                    return col.title !==
                                        '' // ? Do not show row in modal popup if title is blank (for check box)
                                        ?
                                        '<tr data-dt-row="' +
                                        col.rowIdx +
                                        '" data-dt-column="' +
                                        col.columnIndex +
                                        '">' +
                                        '<td>' +
                                        col.title +
                                        ':' +
                                        '</td> ' +
                                        '<td>' +
                                        col.data +
                                        '</td>' +
                                        '</tr>' :
                                        '';
                                }).join('');

                                return data ? $('<table class="table"/>').append('<tbody>' + data +
                                    '</tbody>') : false;
                            }
                        }
                    },
                    orderCellsTop: true,
                    language: {
                        url: "/datatable/fr-FR.json"
                    }
                })
            }

            if (dt_filter_table.length) {
                // Setup - add a text input to each footer cell
                $('.dt-column-search thead tr').clone(true).appendTo('.dt-column-search thead');
                $('.dt-column-search thead tr:eq(1) th').each(function(i) {
                    var title = $(this).text();
                    $(this).html(
                        '<input type="text" class="form-control form-control-sm" placeholder="Search ' +
                        title + '" />');

                    $('input', this).on('keyup change', function() {
                        if (dt_filter.column(i).search() !== this.value) {
                            dt_filter.column(i).search(this.value).draw();
                        }
                    });
                });

                var dt_filter = dt_filter_table.DataTable({
                    dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data();
                                    return 'Details of ' + data['full_name'];
                                }
                            }),
                            type: 'column',
                            renderer: function(api, rowIdx, columns) {
                                var data = $.map(columns, function(col, i) {
                                    return col.title !==
                                        '' // ? Do not show row in modal popup if title is blank (for check box)
                                        ?
                                        '<tr data-dt-row="' +
                                        col.rowIdx +
                                        '" data-dt-column="' +
                                        col.columnIndex +
                                        '">' +
                                        '<td>' +
                                        col.title +
                                        ':' +
                                        '</td> ' +
                                        '<td>' +
                                        col.data +
                                        '</td>' +
                                        '</tr>' :
                                        '';
                                }).join('');

                                return data ? $('<table class="table"/>').append('<tbody>' + data +
                                    '</tbody>') : false;
                            }
                        }
                    },
                    orderCellsTop: true,
                    language: {
                        url: "/datatable/fr-FR.json"
                    }
                });
            }
        })
    @else
        $(function() {
            'use strict';
            var dt_basic_table = $('.datatables-basic'),
                dt_filter_table = $('.dt-column-search');

            if (dt_basic_table.length) {
                dt_basic_table.DataTable({
                    dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data();
                                    return 'Details of ' + data['full_name'];
                                }
                            }),
                            type: 'column',
                            renderer: function(api, rowIdx, columns) {
                                var data = $.map(columns, function(col, i) {
                                    return col.title !==
                                        '' // ? Do not show row in modal popup if title is blank (for check box)
                                        ?
                                        '<tr data-dt-row="' +
                                        col.rowIdx +
                                        '" data-dt-column="' +
                                        col.columnIndex +
                                        '">' +
                                        '<td>' +
                                        col.title +
                                        ':' +
                                        '</td> ' +
                                        '<td>' +
                                        col.data +
                                        '</td>' +
                                        '</tr>' :
                                        '';
                                }).join('');

                                return data ? $('<table class="table"/>').append('<tbody>' + data +
                                    '</tbody>') : false;
                            }
                        }
                    },
                    orderCellsTop: true,
                    language: {
                        paginate: {
                            next: "&nbsp;",
                            previous: "&nbsp;"
                        },
                    }
                })
            }

            if (dt_filter_table.length) {
                // Setup - add a text input to each footer cell
                $('.dt-column-search thead tr').clone(true).appendTo('.dt-column-search thead');
                $('.dt-column-search thead tr:eq(1) th').each(function(i) {
                    var title = $(this).text();
                    $(this).html(
                        '<input type="text" class="form-control form-control-sm" placeholder="Search ' +
                        title + '" />');

                    $('input', this).on('keyup change', function() {
                        if (dt_filter.column(i).search() !== this.value) {
                            dt_filter.column(i).search(this.value).draw();
                        }
                    });
                });

                var dt_filter = dt_filter_table.DataTable({
                    dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data();
                                    return 'Details of ' + data['full_name'];
                                }
                            }),
                            type: 'column',
                            renderer: function(api, rowIdx, columns) {
                                var data = $.map(columns, function(col, i) {
                                    return col.title !==
                                        '' // ? Do not show row in modal popup if title is blank (for check box)
                                        ?
                                        '<tr data-dt-row="' +
                                        col.rowIdx +
                                        '" data-dt-column="' +
                                        col.columnIndex +
                                        '">' +
                                        '<td>' +
                                        col.title +
                                        ':' +
                                        '</td> ' +
                                        '<td>' +
                                        col.data +
                                        '</td>' +
                                        '</tr>' :
                                        '';
                                }).join('');

                                return data ? $('<table class="table"/>').append('<tbody>' + data +
                                    '</tbody>') : false;
                            }
                        }
                    },
                    orderCellsTop: true,
                    language: {
                        paginate: {
                            next: "&nbsp;",
                            previous: "&nbsp;"
                        },
                    }
                });
            }
        })
    @endif

    // Filter form control to default size for all tables
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm').removeClass('form-control-sm');
</script>

{{-- Livewire notification --}}
{{-- <script>
    Swal.fire({
        title: '{{ config('dev-master.name') }}',
        text: '👋 Jelly-o macaroon brownie tart ice cream croissant jelly-o apple pie.',
        icon: "success",
        showCancelButton: false,
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-danger",
        },
        timer: 5000
    })

    toastr.success('👋 Jelly-o macaroon brownie tart ice cream croissant jelly-o apple pie.',
        '{{ config('dev-master.name') }}', {
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
            timeOut: 5000,
        });
</script> --}}
<script>
    const SwalModal = (icon, title, html) => {
        Swal.fire({
            icon,
            title,
            html
        })
    }

    const SwalConfirm = (icon, title, html, confirmButtonText, method, params, callback) => {
        Swal.fire({
            icon,
            title,
            html,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText,
            cancelButtonText: '@lang("Cancel")',
            reverseButtons: true,
        }).then(result => {
            if (result.value) {
                return livewire.emit(method, params)
            }

            if (callback) {
                return livewire.emit(callback)
            }
        })
    }

    const ToastNotification = (icon, title, text, timeout = 7000) => {
        toastr[icon](text, title, {
            closeButton: true,
            tapToDismiss: false,
            progressBar: true,
            timeOut: timeout,
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        this.livewire.on('swal:modal', data => {
            SwalModal(data.icon, data.title, data.text)
        })

        this.livewire.on('swal:confirm', data => {
            SwalConfirm(data.icon, data.title, data.text, data.confirmText, data.method, data.params,
                data.callback)
        })

        this.livewire.on('swal:alert', data => {
            ToastNotification(data.icon, data.title, data.text, data.timeout)
        })
    })
</script>
<!-- END: Page JS-->

@stack('modals')
@livewireScripts
<script defer src="{{ asset(mix('vendors/js/alpinejs/alpine.js')) }}"></script>
