$(document).on('click', '[name="btnWitness"]', function() {
    fetchWitness();
    $('#view-witness-modal').modal('toggle');
});

function fetchWitness() {
    var id = $("input[name='id']").val();
    var license_id = $("input[name='license_id']").val();
    const url = '../modules/marriage_license/get-bride-witness.php';

    var table = $('#view-witness-table').DataTable();
    table.clear().draw();

    $.get(url, { id, license_id }, (response) => {
        // console.log(response);
        const rows = JSON.parse(response);
        rows.forEach(row => {
            table.row.add($(`<tr id="${row.id}">
                                <td data-target="witness_names">${row.witness_names}</td>
                                <td data-target="residency">${row.residency}</td>
                                <td data-target="name">${row.name}</td>
                                <td data-target="civil_status">${row.civil_status}</td>
                                <td data-target="to_marry">${row.to_marry}</td>
                                <td data-target="id_no">${row.id_no}</td>
                                <td data-target="date_issued">${row.date_issued}</td>
                                <td data-target="issued_at">${row.issued_at}</td>
                                <td>
                                    <a class='btn btn-primary btn-sm' data-role='editWitness' data-id="${row.id}" style="color: white;"><i class="fa fa-pencil"> </i> </a>
                                    <a class='btn btn-warning btn-sm' data-role='generate-witness' data-id="${row.id}" style="color: white;" title="Generate Form"><i class="fa fa-print"> </i> </a>
                                </td>
                            </tr>`)).draw();
        });
    });
}

$(document).on('click', 'a[data-role=editWitness]', function(){
    var id = $(this).data('id');

    var witness_names = $('#'+id).children('td[data-target=witness_names]').text();
    var residency = $('#'+id).children('td[data-target=residency]').text();
    var name = $('#'+id).children('td[data-target=name]').text();
    var civil_status = $('#'+id).children('td[data-target=civil_status]').text();
    var to_marry = $('#'+id).children('td[data-target=to_marry]').text();
    var id_no = $('#'+id).children('td[data-target=id_no]').text();
    var date_issued = $('#'+id).children('td[data-target=date_issued]').text();
    var issued_at = $('#'+id).children('td[data-target=issued_at]').text();

    // Set the values in the form fields
    $('input[name="witness_names"]').val(witness_names);
    $('input[name="residency"]').val(residency);
    $('input[name="name"]').val(name);
    $('input[name="civil_status"]').val(civil_status);
    $('input[name="to_marry"]').val(to_marry);
    $('input[name="id_no"]').val(id_no);
    $('input[name="date_issued"]').val(date_issued);
    $('input[name="issued_at"]').val(issued_at);

    $('input[name="witness_id"]').val(id);
    $('#witness-modal').modal('toggle');
});


$(document).on('click', '#add-witness', function(){
    $('#witness-form').trigger("reset");
    $('#witness-modal').modal('toggle');
});

$('#witness-form').submit(function(e) {
    e.preventDefault();
    var bride_id = $("input[name='id']").val();
    var license_id = $("input[name='license_id']").val();

    const formData = new FormData(this);
    formData.append('bride_id', bride_id);
    formData.append('license_id', license_id);

    $.ajax({
        url: '../modules/marriage_license/save-bride-witness.php',
        type: 'POST',
        data: formData,
        contentType: false,  // Let the browser set the correct content type
        processData: false,  // Prevent jQuery from processing the data
        success: function(response) {
            if ($.trim(response) == 'success') {
                toastrOptions();
                toastr.success("Data saved successfully!", "System Message");
                $('#witness-form').trigger("reset");
                $('#witness-modal').modal('toggle');
                fetchWitness();
            }
        },
        error: function(xhr, status, error) {
            console.error("Form submission failed: " + error);
            toastrOptions();
            toastr.error("There was an error with the form submission", "System Message");
        }
    });
});


// Generate report
$(document).on('click', 'a[data-role=generate-witness]', function(){
    var witness_id = $(this).data('id');
    fetchWitnessData(witness_id);
    setTimeout(() => {
        var toPrint = document.getElementById('witness-report-form');
        var newTab = window.open('', '_blank');
        newTab.document.write('<html><head><title>' + document.title + '</title>');

        // Link to an external CSS file
        newTab.document.write('<link rel="stylesheet" type="text/css" href="../public/css/report.css?v=' + new Date().getTime() + '">');

        newTab.document.write('</head><body>');
        newTab.document.write(toPrint.innerHTML);
        newTab.document.write('</body></html>');

        newTab.document.close();
        // Wait for the CSS and other resources to fully load before printing
        newTab.onload = function() {
            newTab.print();
        };
    
        // Focus on the new tab
        newTab.focus();
    }, 500); // Delay of 500 milliseconds (0.5 seconds)

});

function fetchWitnessData(id) {
    const url = '../modules/report/get-witness.php';

    var template = '';

    var table = $('#report-table tbody');
    table.empty();

    $.ajaxSetup({async: false});
    $.get(url, { id }, (response) => {
        console.log(response);
        const rows = JSON.parse(response);
        const { witness_names, residency, name, civil_status, to_marry, id_no, date_issued, approved_by } = rows[0];

        // 1st row
        template += `
            <tr>
                <td colspan=4 class="txt-center" style="border: none; ">
                    <h4>OFFICE OF THE MUNICIPAL CIVIL REGISTRAR</h4>
                    <br>
                </td>
            </tr>
        `;

        // 2nd row
        template += `
            <tr>
                <td colspan=4 style="border: none; text-indent: 50px;">
                    I/We, <span class="shared-text" style="width: calc(35%);">${witness_names}</span>, resident of <span class="shared-text" style="width: calc(30%);">${residency}</span>
                </td>
            </tr>
        `;
        
        // 3rd row
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    certify that <span class="shared-text" style="width: calc(30%);">${name}</span> is a <span class="shared-text" style="width: calc(25%);">${civil_status}</span> and no legal impediment to 
                </td>
            </tr>
        `;

        // 4th row
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    his/her marriage with <span class="shared-text" style="width: calc(25%);">${to_marry}</span>
                    <br><br>
                </td>
            </tr>
        `;

        // 5th row
        template += `
            <tr>
                <td colspan=2 style="border:none;">
                    I.D. No.: _________________
                </td>
                <td colspan=2 style="border:none;">
                    <center>
                        ___________________________________ <br>
                        Signature of Witness
                    </center>
                </td>
            </tr>
        `;
        
        // 6th row
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    Date Issued: _________________
                </td>
            </tr>
        `;
        
        // 7th row
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    Issued at: _________________
                </td>
            </tr>
        `;

        // 8th row
        template += `
            <tr>
                <td colspan=4 style="border: none; text-indent: 50px;">
                    <small>SUBSCRIBE AND SWORN to before me ____ day of ______________, at Nasipit, Agusan del Norte, Philippines.</small>
                    <br><br><br>
                </td>
            </tr>
        `;
        
        // 8th row
        template += `
            <tr>
                <td colspan=3 style="border: none;"></td>
                <td colspan=1 style="border: none;">
                    <center>
                        <u>CLEO BELLE C. NAVARETTE</u> <br>
                        Municipal Civil Registrar
                    </center>
                </td>
            </tr>
        `;


        table.append(template);
    });

}
