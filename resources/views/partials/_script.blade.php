<!-- JavaScript Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>




<!-- global app configuration object -->
<script>
    var config = {
        packages:[],
        routes: {
            index: "{{ route('index') }}",
            product_available_packages: "{{ route('product.available_pakcages', ['product_id' => ':ID']) }}",
            shop_details: "{{ route('shop.details', ['shop_id' => ':ID']) }}",
            package_store: "{{ route('shop.package.store') }}",
            exports: {
                product_sample: "{{ route('export.product_sample') }}",
                shop_details: "{{ route('export.shop_details', ['shop_id' => ':ID']) }}",
            },
            imports: {
            }
        },
        messages: {
            success: function(message = 'Package added successfully.') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: message,
                    showConfirmButton: false,
                    timer: 1500
                })
            },
            error: function(message = 'The transaction could not be completed.') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: message,
                    showConfirmButton: false,
                    timer: 1500
                })
            }

        },
        func: {
            packageBox: {
                show: function(message) {
                    let alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">\
                                <span id="package_alert_box_message">' + message + '</span>\
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                    <span aria-hidden="true">&times;</span>\
                                </button>\
                                </div>'
                    $('#package_alert_box').html(alert);
                    $("#package_selection").css("visibility", "hidden");
                },
                hide: function() {
                    $('#package_alert_box').html('');
                    $("#package_selection").css("visibility", "visible");
                }
            }
        },
    };
    $('[data-toggle="tooltip"]').tooltip()
</script>

<!-- Custom Scripts  -->
<script src="{{ asset('js/jquery.steps.min.js') }}"></script>
<script src="{{ asset('js/bd-wizard.js') }}"></script>
<script src="{{ asset('app.js') }}"></script>
