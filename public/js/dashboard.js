
//Wizard Init
$("#wizard").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "",
    stepsOrientation: "vertical",
    titleTemplate: '<span class="number">#index#</span>'
});

//Select2 Init
$(".select2").select2({
    theme: "bootstrap",
    allowClear: false,
    width: '100%',
    containerCssClass: ':all:'
});

//make wizard steps visible
$("#wizard").removeClass('invisible');

//Events
$('#shops_selection').change(shopChangeListener);
$('#product_selection').change(updateProductPackages);
$('#package_selection').change((e) => { updatePackageSizesTable(e, config.packages) });
$('a[href="#finish"]').click(submitForm);


//Functions
function updateProductPackages(e) {
    let product_id = e.target.value;
    $.ajax({
        url: config.routes.product_available_packages.replace(':ID', product_id),
        type: 'GET',
        data: {
            'product_id': product_id
        },
        dataType: 'json',
        success: function (data) {
            config.packages = data;
            setPackagesItems(data)
        },
        error: function (request, error) {
            config.messages.error(request.responseJSON.message ? request.responseJSON.message : null);
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
        url: config.routes.shop_details.replace(':ID', shop_id),
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (shop_name != false)
                updateShopDetailsTable(data, shop_name, shop_id);
            return data;
        },
        error: function (request, error) {
            config.messages.error(request.responseJSON.message ? request.responseJSON.message : null);
            return null;
        }
    });
}

function updateShopDetailsTable(data, shop_name, shop_id) {
    let body = '';
    data.forEach(element => {
        body += '<tr>\
             <td>'+ element['product_name'] + '</td>\
            <td>'+ element['package_name'] + '</td>\
            <td>'+ element['total_packages'] + '</td>\
        </tr>';
    });
    $('#table_shop_details_body').html(body)
    $('#table_shop_details_name').html(shop_name + ' <a  data-toggle="tooltip"  data-placement="top" title="Download Detailed Excel File" href="' + config.routes.exports.shop_details.replace(':ID', shop_id) + '" class="float-right text-success"><i class="bi bi-file-earmark-excel-fill"></i></a>')
    if (data.length == 0)
        $('#table_shop_details').css('visibility', 'hidden')
    else
        $('#table_shop_details').css('visibility', 'visible')

    $('[data-toggle="tooltip"]').tooltip()

}

function updatePackageSizesTable(e, packages) {
    let package_id = e.target.value
    packages.forEach(package => {
        if (package['id'] == package_id) setPackageSizes(package['sizes'])
    });
}

function setPackagesItems(packages) {
    if (packages.length == 0)
        config.func.packageBox.show('No package is available for the selected product.');
    else config.func.packageBox.hide();
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
    head = '<thead><tr>';
    body = '<tbody><tr>';
    sizes.forEach(size => {
        head += '<th>' + size["name"] + '</th>';
        body += '<td>' + size["pivot"]['quantity'] + '</td>';
    });
    head += '</thead></tr>';
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

        config.messages.error('You must select a shop.')
        return false;
    };
    if (!product.val()) {
        config.messages.error('You must select a product.')
        return false;
    };
    if (!package.val()) {
        config.messages.error('You must select a package.')
        return false;
    };

    data["_token"] = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        url: config.routes.package_store,
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function (data) {
            config.packages = data;
            setPackagesItems(data)
            getShopDetails(shop.val(), shop.children(":selected").text())
            config.messages.success();
        },
        error: function (request, error) {
            config.messages.error(request.responseJSON.message ? request.responseJSON.message : null);
        }
    });
}

