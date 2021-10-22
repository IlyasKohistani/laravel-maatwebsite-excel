$('#shops_selection').change(shopChangeListener);
$('#product_selection').change(updateProductPackages);
$('#package_selection').change((e) => { updatePackageSizesTable(e, packages) });
$('a[href="#finish"]').click(submitForm);


function updateProductPackages(e) {
    let product_id = e.target.value;
    $.ajax({
        url: 'http://127.0.0.1:8000/product/' + product_id + '/available-packages',
        type: 'GET',
        data: {
            'product_id': product_id
        },
        dataType: 'json',
        success: function (data) {
            window.packages = data;
            setPackagesItems(data)
        },
        error: function (request, error) {
            errorMessage(request.responseJSON.message ? request.responseJSON.message : null);
        }
    });
}

function shopChangeListener(e) {
    let shop_id = e.target.value;
    let shop_name = e.target.options[e.target.selectedIndex].text
    getShopDetails(shop_id, shop_name);
}

function getShopDetails(shop_id, shop_name = false) {
    $.ajax({
        url: 'http://127.0.0.1:8000/shop-details/' + shop_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (shop_name != false)
                updateShopDetailsTable(data, shop_name);
            return data;
        },
        error: function (request, error) {
            errorMessage(request.responseJSON.message ? request.responseJSON.message : null);
            return null;
        }
    });
}

function updateShopDetailsTable(data, shop_name) {
    let body = '';
    data.forEach(element => {
        body += '<tr>\
             <td>'+ element['product_name'] + '</td>\
            <td>'+ element['package_name'] + '</td>\
            <td>'+ element['total_packages'] + '</td>\
        </tr>';
    });
    $('#table_shop_details_body').html(body)
    $('#table_shop_details_name').html(shop_name)
    if (data.length == 0)
        $('#table_shop_details').css('visibility', 'hidden')
    else
        $('#table_shop_details').css('visibility', 'visible')

}

function updatePackageSizesTable(e, packages) {
    let package_id = e.target.value
    packages.forEach(package => {
        if (package['id'] == package_id) setPackageSizes(package['sizes'])
    });
}

function setPackagesItems(packages) {
    if (packages.length == 0)
        showPackageAlert('No package is available for the selected product.');
    else removePackageAlert();
    $('#package_selection').html('');
    $('#table_sizes').html('');
    let packages_options = '';
    packages.forEach((package, index) => {
        if (index == 0) setPackageSizes(package['sizes'])
        packages_options += '<option value="' + package["id"] + '">' + package["name"] + '</option>';
    });

    $('#package_selection').html(packages_options);

}

function setPackageSizes(sizes) {
    $('#table_sizes').html('');
    head = '<head><tr>';
    body = '<tbody><tr>';
    sizes.forEach(size => {
        head += '<th>' + size["name"] + '</th>';
        body += '<td>' + size["pivot"]['quantity'] + '</td>';
    });
    head += '</head></tr>';
    body += '</tbody></tr>';

    $('#table_sizes').html(head + body);
}


function submitForm() {
    let shop = $('#shops_selection');
    let product = $('#product_selection');
    let package = $('#package_selection');


    let data = {
        shop_id: shop.val(),
        product_id: product.val(),
        package_id: package.val(),
    }

    if (!shop.val()) {
        errorMessage('You must select a shop.')
        return false;
    };
    if (!product.val()) {
        errorMessage('You must select a product.')
        return false;
    };
    if (!package.val()) {
        errorMessage('You must select a package.')
        return false;
    };

    data["_token"] = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        url: 'http://127.0.0.1:8000/shop/package',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function (data) {
            window.packages = data;
            setPackagesItems(data)
            getShopDetails(shop.val(), shop.children(":selected").text())
            successMessage();
        },
        error: function (request, error) {
            errorMessage(request.responseJSON.message ? request.responseJSON.message : null);
        }
    });
}


function successMessage(message = 'Package added successfully.') {
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        text: message,
        showConfirmButton: false,
        timer: 1500
    })
}

function errorMessage(message = 'The transaction could not be completed.') {
    Swal.fire({
        position: 'top-end',
        icon: 'error',
        text: message,
        showConfirmButton: false,
        timer: 1500
    })
}

