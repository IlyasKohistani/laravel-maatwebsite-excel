

$('.drop-zone__input').change((e) => {
    let file = e.target.files[0];

    if (e.target.files.length > 0 && (!file.name.includes('xlsx') || !file.name.includes('xls'))) {
        resetImportInput();
        config.messages.error('Only .xlsx and .xls files are allowed.')
        return false;
    }
    if (file == undefined) return false;
    config.loader.toggle();
    readJSON(file, renderDataTable)
});

function resetImportInput(){
    $('.drop-zone__input').val(null);
    $('.drop-zone__input').prop('files',null);
    $('.drop-zone .drop-zone__thumb').remove();
    $('.drop-zone').append('<span class="drop-zone__prompt">Drop file here or click to upload</span>');
    document.getElementById('excel_data').innerHTML = "";
}


function renderDataTable(data) {
    let table_output = generateDataTable(data)
    let button_layout = '<div class="d-flex justify-content-between align-items-center mb-2" style="max-width:100vw;"><span class="font-weight-bold">Records Count (' + (data.length - 1) + ')</span>\
    <span class="d-flex"><select id="import_type" class="form-control w-auto mr-2 d-inline-block"><option value="">Select Type</option><option value="1">Shops</option><option value="2">Products</option><option value="3">Packages</option></select>\
    <button type="button" id="importButton" class="btn btn-outline-success"><i class="bi bi-upload"></i>Upload</button></span></div>';
    document.getElementById('excel_data').innerHTML = button_layout + table_output;
    $('#importButton').click(importFile);
    config.loader.hide();
}

function generateDataTable(data) {
    var table_output = '<table class="table table-striped table-bordered">';

    for (var row = 0; row < data.length; row++) {

        table_output += '<tr>';

        for (var cell = 0; cell < data[row].length; cell++) {

            if (row == 0) {

                table_output += '<th>' + data[row][cell] + '</th>';

            }
            else {

                table_output += '<td>' + (data[row][cell]??'') + '</td>';

            }

        }

        table_output += '</tr>';

    }

    table_output += '</table>';
    return table_output;
}

function readJSON(file, callback) {
    var reader = new FileReader();
    reader.readAsArrayBuffer(file);
    reader.onload = function (event) {
        var data = new Uint8Array(reader.result);
        var work_book = XLSX.read(data, { type: 'array' });

        var sheet_name = work_book.SheetNames;

        var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], { header: 1 });

        if (sheet_data.length > 0) {
            callback(sheet_data);
        }
    }
}

function importFile(e) {
    let files = $('.drop-zone__input').prop('files');
    let import_type = $('#import_type').val();

    if(!files.length){
    config.messages.error('You must select an Excel file for import.')
    return false;
    }

    if(!import_type){
    config.messages.error('You must select import type.')
    return false;
    }

    var formData = new FormData();
    formData.append("file", files[0]);
    formData.append("type", import_type);
    formData.append("_token", $('meta[name="csrf-token"]').attr('content'));

    $.ajax({
        url: config.routes.imports.upload,
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            resetImportInput();
            config.messages.success('Records imported successfully!');
        },
        error: function (response, error) {
            config.messages.error(config.func.customError(response));
        }
    });
}