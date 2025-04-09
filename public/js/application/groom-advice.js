$(document).on('click', '[name="btnAdvice"]', function() {
    var license_id = $("input[name='license_id']").val();

    $.ajaxSetup({async: false});
    $.get('../modules/marriage_license/save-groom-advice-auto.php', { license_id },  (response) => {
        console.log(response);
    });

    fetchAdvice();
    $('#view-advice-modal').modal('toggle');
});

function fetchAdvice() {
    var id = $("input[name='id']").val();
    var license_id = $("input[name='license_id']").val();
    const url = '../modules/marriage_license/get-groom-advice.php';

    var table = $('#view-advice-table').DataTable();
    table.clear().draw();

    $.get(url, { id, license_id },  (response) => {
        // console.log(response);
        const rows = JSON.parse(response);
        rows.forEach(row => {
            table.row.add($(`<tr id="${row.id}">
                                <td data-target="sex">${row.sex}</td>
                                <td data-target="place">${row.place}</td>
                                <td data-target="date">${row.date}</td>
                                <td data-target="advice_to">${row.advice_to}</td>
                                <td data-target="to_marry">${row.to_marry}</td>
                                <td>
                                    <a class='btn btn-primary btn-sm' data-role='editAdvice' data-id="${row.id}" style="color: white;"><i class="fa fa-pencil"> </i></a>
                                    <a class='btn btn-warning btn-sm' data-role='generate-advice' data-id="${row.id}" style="color: white;" title="Generate Form"><i class="fa fa-print"> </i></a>
                                </td>
                            </tr>`)).draw();
        });
    });
}

$(document).on('click', 'a[data-role=editAdvice]', function(){
    var id = $(this).data('id');
    var sex = $('#'+id).children('td[data-target=sex]').text();
    var place = $('#'+id).children('td[data-target=place]').text();
    var date = $('#'+id).children('td[data-target=date]').text();
    var advice_to = $('#'+id).children('td[data-target=advice_to]').text();
    var to_marry = $('#'+id).children('td[data-target=to_marry]').text();
    
    // Set the values in the form fields
    $('select[name="sex"]').val(sex); // Set the selected value in the dropdown
    $('input[name="place"]').val(place);
    $('input[name="date"]').val(date);
    $('input[name="advice_to"]').val(advice_to);
    $('input[name="to_marry"]').val(to_marry);
    $('input[name="advice_id"]').val(id);
    $('#advice-modal').modal('toggle');
});


$(document).on('click', '#add-advice', function(){
    $('#advice-form').trigger("reset");
    $('#advice-modal').modal('toggle');
});

$('#advice-form').submit(function(e) {
    e.preventDefault();
    var groom_id = $("input[name='id']").val();
    var license_id = $("input[name='license_id']").val();

    const formData = new FormData(this);
    formData.append('groom_id', groom_id);
    formData.append('license_id', license_id);

    $.ajax({
        url: '../modules/marriage_license/save-groom-advice.php',
        type: 'POST',
        data: formData,
        contentType: false,  // Let the browser set the correct content type
        processData: false,  // Prevent jQuery from processing the data
        success: function(response) {
            if ($.trim(response) == 'success') {
                toastrOptions();
                toastr.success("Data saved successfully!", "System Message");
                $('#advice-form').trigger("reset");
                $('#advice-modal').modal('toggle');
                fetchAdvice();
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
$(document).on('click', 'a[data-role=generate-advice]', function(){
    var advice_id = $(this).data('id');
    fetchAdviceData(advice_id);
    setTimeout(() => {
        var toPrint = document.getElementById('report-form');
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

function fetchAdviceData(id) {
    const url = '../modules/report/get-advice.php';

    var template = '';

    var table = $('#advice-table tbody');
    table.empty();

    $.ajaxSetup({async: false});
    $.get(url, { id }, (response) => {
        console.log(response);
        const rows = JSON.parse(response);
        const { sex, place, date, advice_to, to_marry, prepared_by } = rows[0];

        // 1st row
        template += `
            <tr>
                <td colspan=4 class="txt-center" style="border: none;">
                    <b>ADVICE UPON INTENDED MARRIAGE</b>
                    <br>
                    ${sex}
                </td>
            </tr>
        `;

        // 2nd row
        template += `
            <tr>
                <td colspan=3 style="border: none;"></td>
                <td class="txt-center" style="border: none;">
                    <span><u>${place}</u></span>
                    <br>
                    Place
                </td>
            </tr>
        `;
        
        // 3rd row
        template += `
            <tr>
                <td colspan=3 style="border: none;"></td>
                <td class="txt-center" style="border: none;">
                    <span><u>${moment(date).format('MMMM D, YYYY')}</u></span>
                    <br>
                    Date
                </td>
            </tr>
        `;

        // 4th row
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    TO: <span><u>${advice_to}</u></span>
                </td>
            </tr>
        `;

        // 5th row
        template += `
            <tr>
                <td colspan=4 style="border:none; text-indent: 40px;">
                    Our/My advice upon intended marriage with <u>${advice_to}</u> having been asked by you, and knowing no legal impediment to this marriage, 
                    we / I hereby advice you to marry with <u>${to_marry}</u>
                </td>
            </tr>
        `;
        
        // 6th row
        template += `
            <tr>
                <td colspan=2 class="txt-center" style="border: none;">
                    <br>
                    <br>
                    <br>
                    ___________________________________ <br>
                    (Signature of Father)
                </td>
                <td colspan=2 class="txt-center" style="border: none;">
                    <br>
                    <br>
                    <br>
                    ___________________________________ <br>
                    (Signature of Mother)
                </td>
            </tr>
        `;
        
        // 7th row
        template += `
            <tr>
                <td class="txt-center" style="border: none;">
                    <br><br>
                    Res. Cert./ I.D.#
                </td>
                <td style="border: none;">
                    <br><br>
                    _______________________
                </td>
                <td class="txt-center" style="border: none;">
                    <br><br>
                    Res. Cert./ I.D.#
                </td>
                <td style="border: none;">
                    <br><br>
                    _______________________
                </td>
            </tr>
        `;

        // 8th row
        template += `
            <tr>
                <td class="txt-center" style="border: none;">Issued at</td>
                <td style="border: none;">_______________________</td>
                <td class="txt-center" style="border: none;">Issued at</td>
                <td style="border: none;">_______________________</td>
            </tr>
        `;

        // 9th row
        template += `
            <tr>
                <td class="txt-center" style="border: none;">Dated:</td>
                <td style="border: none;">_______________________</td>
                <td class="txt-center" style="border: none;">Dated:</td>
                <td style="border: none;">_______________________</td>
            </tr>
        `;

        // 10th row
        template += `
            <tr>
                <td colspan=4 class="txt-center" style="border: none;">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <u>CLEO BELLE C. NAVARETTE</u>
                    <br>
                    Municipal Civil Registrar
                </td>
            </tr>
        `;


        table.append(template);
    });

}