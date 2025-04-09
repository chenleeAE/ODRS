$(document).on('click', '[name="btnConsent"]', function() {
    var license_id = $("input[name='license_id']").val();
    $.ajaxSetup({async: false});
    $.get('../modules/marriage_license/save-groom-consent-auto.php', { license_id },  (response) => {
        console.log(response);
    });

    fetchConsents();
    $('#view-consent-modal').modal('toggle');
});

function fetchConsents() {
    var id = $("input[name='id']").val();
    var license_id = $("input[name='license_id']").val();
    const url = '../modules/marriage_license/get-groom-consent.php';

    var table = $('#view-consent-table').DataTable();
    table.clear().draw();

    $.get(url, { id, license_id },  (response) => {
        // console.log(response);
        const rows = JSON.parse(response);
        rows.forEach(row => {
            table.row.add($(`<tr id="${row.id}">
                                <td data-target="parent_name">${row.parent_name}</td>
                                <td data-target="parent_address">${row.parent_address}</td>
                                <td data-target="relationship">${row.relationship}</td>
                                <td data-target="child_name">${row.child_name}</td>
                                <td data-target="child_address">${row.child_address}</td>
                                <td data-target="child_age">${row.child_age}</td>
                                <td data-target="to_marry">${row.to_marry}</td>
                                <td data-target="to_marry_address">${row.to_marry_address}</td>
                                <td>
                                    <a class='btn btn-primary btn-sm' data-role='editConsent' data-id="${row.id}" style="color: white;"><i class="fa fa-pencil"> </i></a>
                                    <a class='btn btn-warning btn-sm' data-role='generate-consent' data-id="${row.id}" style="color: white;" title="Generate Form"><i class="fa fa-print"> </i></a>
                                </td>
                            </tr>`)).draw();
        });
    });
}

$(document).on('click', 'a[data-role=editConsent]', function(){
    var id = $(this).data('id');
    var parent_name = $('#'+id).children('td[data-target=parent_name]').text();
    var parent_address = $('#'+id).children('td[data-target=parent_address]').text();
    var relationship = $('#'+id).children('td[data-target=relationship]').text();
    var child_name = $('#'+id).children('td[data-target=child_name]').text();
    var child_address = $('#'+id).children('td[data-target=child_address]').text();
    var child_age = $('#'+id).children('td[data-target=child_age]').text();
    var to_marry = $('#'+id).children('td[data-target=to_marry]').text();
    var to_marry_address = $('#'+id).children('td[data-target=to_marry_address]').text();

    $('input[name="parent_name"]').val(parent_name);
    $('input[name="parent_address"]').val(parent_address);
    $('input[name="relationship"]').val(relationship);
    $('input[name="child_name"]').val(child_name);
    $('input[name="child_address"]').val(child_address);
    $('input[name="child_age"]').val(child_age);
    $('input[name="to_marry"]').val(to_marry);
    $('input[name="to_marry_address"]').val(to_marry_address);
    $('input[name="consent_id"]').val(id);
    $('#consent-modal').modal('toggle');
});


$(document).on('click', '#add-consent', function(){
    $('#consent-form').trigger("reset");
    $('#consent-modal').modal('toggle');
});

$('#consent-form').submit(function(e) {
    e.preventDefault();
    var groom_id = $("input[name='id']").val();
    var license_id = $("input[name='license_id']").val();

    const formData = new FormData(this);
    formData.append('groom_id', groom_id);
    formData.append('license_id', license_id);

    $.ajax({
        url: '../modules/marriage_license/save-groom-consent.php',
        type: 'POST',
        data: formData,
        contentType: false,  // Let the browser set the correct content type
        processData: false,  // Prevent jQuery from processing the data
        success: function(response) {
            if ($.trim(response) == 'success') {
                toastrOptions();
                toastr.success("Data saved successfully!", "System Message");
                $('#consent-form').trigger("reset");
                $('#consent-modal').modal('toggle');
                fetchConsents();
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
$(document).on('click', 'a[data-role=generate-consent]', function(){
    var consent_id = $(this).data('id');
    fetchConsentData(consent_id);
    setTimeout(() => {
        var toPrint = document.getElementById('report-consent-form');
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

function fetchConsentData(id) {
    const url = '../modules/report/get-consent.php';

    var template = '';

    var table = $('#report-consent-table tbody');
    table.empty();

    $.ajaxSetup({async: false});
    $.get(url, { id }, (response) => {
        const rows = JSON.parse(response);
        console.log(rows);
        const { parent_name, parent_address, relationship, child_name, child_address, child_age, to_marry, to_marry_address, prepared_by } = rows[0];

        // 1st row
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    <h6>MUNICIPAL FORM NO. 2</h6>
                </td>
            </tr>
        `;
        
        // 2nd row
        template += `
            <tr>
                <td colspan=4 class="txt-center" style="border: none;">
                    <h5>(Form No. 6)</h5>
                    <b>CONSENT TO MARRIAGE OF A PERSON UNDER AGE</b>
                    <br><br>
                </td>
            </tr>
        `;
        
        // 3rd row
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    I, <span class="shared-text" style="width: calc(35%);">${parent_name}</span> resident of <span class="shared-text" style="width: calc(35%);">${parent_address}</span>
                </td>
            </tr>
        `;
        
        // 4th row
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    and <span class="shared-text" style="width: calc(35%);">${relationship}</span> of <span class="shared-text" style="width: calc(35%);">${child_name}</span> 
                </td>
            </tr>
        `;

        // 4th row
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    Resident of <span class="shared-text" style="width: calc(35%);">${child_address}</span>, single and less than <span class="shared-text" style="width: calc(15%);">${child_age}</span>
                </td>
            </tr>
        `;

        // 5th row
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    years of age, being duly swore, do hereby depose and say that I freely consent to said
                </td>
            </tr>
        `;

        // 6th row
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    <span class="shared-text" style="width: calc(35%);">${child_name}</span>, marrying with <span class="shared-text" style="width: calc(25%);">${to_marry}</span> resident of 
                </td>
            </tr>
        `;

        // 7th row
        template += `
            <tr>
                <td colspan=4 style="border: none;">
                    <span class="shared-text" style="width: calc(45%);">${to_marry_address}</span> and that I know of legal impediment to such marriage.
                    <br><br>
                </td>
            </tr>
        `;
        
        // 8th row
        template += `
            <tr>
                <td colspan=2></td>
                <td colspan=2 style="border: none;" class="txt-center">
                    ____________________________ <br>
                    (Signature of father, mother, of guardian)
                </td>
            </tr>
        `;

        // 9th row
        template += `
            <tr>
                <td style="border: none;">
                    <br>
                    Valid I.D. &nbsp;&nbsp; __________ <br>
                    Date issued: __________ <br>
                    Place Issued: __________
                </td>
                <td colspan=3></td>
            </tr>
        `;

        // 10th row
        template += `
            <tr>
                <td colspan=4>
                    <br>
                    <small>WITNESSES - (Not necessary if this affidavit is subscribed before the Local Civil Registrar concern)</small>
                    <hr style="border: 0; height: 3px; background-color: black; width: 100%; display: inline-block;">
                </td>
            </tr>
        `;

        // 11th row
        template += `
            <tr>
                <td colspan=4>
                    <small>SUBSCRIBE AND SWORN to before me ____ day of ______________, at Nasipit, Agusan del Norte, Philippines.</small>
                    <br><br><br>
                </td>
            </tr>
        `;

        // 12th row
        template += `
            <tr>
                <td colspan=3></td>
                <td>
                    <center>
                        <b>CLEO BELLE C. NAVARETTE</b> <br>
                        Municipal Civil Registrar
                    </center>
                </td>
            </tr>
        `;

        // 13th row
        template += `
            <tr>
                <td style="border: none;">
                    <small>
                        Exempt from <br>
                        Documentary <br>
                        Stamp Tax
                    </small>
                </td>
                <td colspan=3></td>
            </tr>
        `;

        // 14th row
        template += `
            <tr>
                <td colspan=4>
                    <hr style="border: 0; height: 3px; background-color: black; width: 100%; display: inline-block;">
                </td>
            </tr>
        `;

        // 15th row
        template += `
            <tr>
                <td colspan=4 class="txt-center">
                    <b>INSTRUCTIONS</b>
                    <br><br>
                </td>
            </tr>
        `;

        // 16th row
        template += `
            <tr>
                <td colspan=4>
                    <span class="instruction" style="padding-left: 40px; ">
                        In case either or both the contracting parties, being single, or less than twenty years of age as regards he male and less
                        <br>
                        eighteen years as regards the female, they shall exhibit to the Local Civil Registrar concerned the consent to their marriage at their father,
                        <br>
                        mother, or guardian or person having legal charge of them, in the order mentioned. Such consent shall be in writing, under oath taking
                        <br>
                        with the apperance of the interested parties before the Local Civil Registrar concerned or in the form of an affidavit made in the presence
                        <br>
                        of two witnesses and attested before any official authorized by the law to administer oaths. (Rep. ACt. 886. Art. CL)
                    </span>
                </td>
            </tr>
        `;

        // 17th row
        template += `
            <tr>
                <td colspan=4>
                    <br>
                    <span class="instruction" style="padding-left: 40px; ">
                        For the purposes of the Marriage Law, by "guardian" is meanth a guardian legally appointed by will of by a competent court for
                        <br>
                        the person, or both the person and estate of a minor. By "person having legal charge" is meant a person actually in lawful charge of
                        <br>
                        a minor who has no father nor mother, no legal guardian.
                    </span>
                </td>
            </tr>
        `;
        
        // 18th row
        template += `
            <tr>
                <td colspan=4>
                    <span class="instruction" style="padding-left: 40px; ">
                        Cross out unnecessary words.
                    </span>
                </td>
            </tr>
        `;

        table.append(template);
    });

}