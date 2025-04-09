// Generate License report
$(document).on('click', 'a[data-role=generate-license]', function(){
    var witness_id = $(this).data('id');
    fetchLicenseData(witness_id);
    setTimeout(() => {
        var toPrint = document.getElementById('license-report-form');
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

function fetchLicenseData(license_id) {
    const url = '../modules/marriage_license/get-license.php';
    const groom_url = '../modules/marriage_license/get-groom.php';
    const bride_url = '../modules/marriage_license/get-bride.php';

    var template = '';
    var groom_details = [];
    var bride_details = [];
    
    $.ajaxSetup({async: false});
    $.get(groom_url, { license_id }, (response) => {
        groom_details = JSON.parse(response);
    });

    $.ajaxSetup({async: false});
    $.get(bride_url, { license_id }, (response) => {
        bride_details = JSON.parse(response);
    });

    var table = $('#report-license-table tbody');
    table.empty();

    $.ajaxSetup({async: false});
    $.get(url, { license_id }, (response) => {
        console.log(response);
        const rows = JSON.parse(response);
        const { province, city, registry_no, received_by, date_receipt, license_no, date_issuance } = rows[0];

        // 1st row
        template += `
            <tr>
                <td colspan=10 class="txt-center" style="font-size: 10px; border-bottom: none;">
                    Municipal Form 90 (Form No. 2)
                </td>
            </tr>
        `;

        // 2nd row
        template += `
            <tr>
                <td colspan=10 style="font-size: 10px; border-top: none; border-bottom: none;">
                    (To be accomplished in quadruplicate using black ink) <br>
                    (Revised January 2007)
                </td>
            </tr>
        `;
        
        // 3rd row
        template += `
            <tr>
                <td colspan=10 class="txt-center" style="border-top: none;">
                    <p style="font-size: 10px;">Republic of the Philippines</p>
                    <p>OFFICE OF THE CIVIL REGISTRAR GENERAL</p>
                    <p><b>APPLICATION FOR MARRIAGE LICENSE</b></p>
                </td>
            </tr>
        `;

        // 4th row
        template += `
            <tr>
                <td colspan=5 width="50%">
                    Province:
                    <span class="shared-text" style="display: inline-block; white-space: nowrap; width: auto;">
                        ${province || '&nbsp;'}
                    </span>
                </td>
                <td colspan=5 rowspan=2 width="50%">
                    Registry No.
                </td>
            </tr>
        `;

        // 5th row
        template += `
            <tr>
                <td colspan=5>
                    City/Municipality:
                    <span class="shared-text" style="display: inline-block; white-space: nowrap; width: auto;">
                        ${city || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;

        // 6th row
        template += `
            <tr>
                <td colspan=5>
                    Received by:
                    <span class="shared-text" style="display: inline-block; white-space: nowrap; width: auto;">
                        ${received_by || '&nbsp;'}
                    </span>
                </td>
                <td colspan=5>
                    Marriage License No.:
                    <span class="shared-text" style="display: inline-block; white-space: nowrap; width: auto;">
                        ${license_no || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;

        // 7th row
        template += `
            <tr>
                <td colspan=5>
                    Date of Receipt:
                    <span class="shared-text" style="display: inline-block; white-space: nowrap; width: auto;">
                        ${date_receipt ? moment(date_receipt).format('MMMM D, YYYY') : '&nbsp;'}
                    </span>
                </td>
                <td colspan=5>
                    Date of Issuance of Marriage License:
                    <span class="shared-text" style="display: inline-block; white-space: nowrap; width: auto;">
                        ${date_issuance ? moment(date_issuance).format('MMMM D, YYYY') : '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;

        // 8th row
        template += `
            <tr>
                <td colspan=5 class="txt-center txt-bold">
                    GROOM
                </td>
                <td colspan=5 class="txt-center txt-bold">
                    BRIDE
                </td>
            </tr>
        `;

        // 9th row
        template += `
            <tr>
                <td colspan=5>
                    <p style="font-size: 10px;">The Civil Registrar</p>
                    <p style="font-size: 10px;">Sir/Madam:</p>
                    <p style="font-size: 10px; text-align: justify; text-indent: 30px;">
                        May I apply for a license to contract marriage with <u>${bride_details[0].fname} ${bride_details[0].mname} ${bride_details[0].lname}</u>
                        and to this effect, being duly sworn, I hereby depose and say that I have all the necessary qualifications and none of the legal 
                        disqualifications to contract the said marriage, and the following data are true and correct to the best of my knowledge and information;
                    </p>
                </td>
                <td colspan=5>
                    <p style="font-size: 10px;">The Civil Registrar</p>
                    <p style="font-size: 10px;">Sir/Madam:</p>
                    <p style="font-size: 10px; text-align: justify; text-indent: 30px;">
                        May I apply for a license to contract marriage with <u>${groom_details[0].fname} ${groom_details[0].mname} ${groom_details[0].lname}</u>
                        and to this effect, being duly sworn, I hereby depose and say that I have all the necessary qualifications and none of the legal 
                        disqualifications to contract the said marriage, and the following data are true and correct to the best of my knowledge and information;
                    </p>
                </td>
            </tr>
        `;

        // 10th row
        template += `
            <tr>
                <td colspan=4>
                    (First Name)
                    <span class="shared-text" style="display: inline-block; white-space: nowrap; width: auto;">
                        ${groom_details[0].fname || '&nbsp;'}
                    </span>
                    <br>
                    (Middle Name)
                    <span class="shared-text" style="display: inline-block; white-space: nowrap; width: auto;">
                        ${groom_details[0].mname || '&nbsp;'}
                    </span>
                    <br>
                    (Last Name)
                    <span class="shared-text" style="display: inline-block; white-space: nowrap; width: auto;">
                        ${groom_details[0].lname || '&nbsp;'}
                    </span>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    1. Name of Applicant
                </td>
                <td colspan=4>
                    (First Name)
                    <span class="shared-text" style="display: inline-block; white-space: nowrap; width: auto;">
                        ${bride_details[0].fname || '&nbsp;'}
                    </span>
                    <br>
                    (Middle Name)
                    <span class="shared-text" style="display: inline-block; white-space: nowrap; width: auto;">
                        ${bride_details[0].mname || '&nbsp;'}
                    </span>
                    <br>
                    (Last Name)
                    <span class="shared-text" style="display: inline-block; white-space: nowrap; width: auto;">
                        ${bride_details[0].lname || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;

        // 11th row
        template += `
            <tr>
                <td class="txt-center" width="10%" style="border-right: none;">
                    <span style="font-size: 10px;">(Day)</span> 
                    <p>${groom_details[0].bday ? moment(groom_details[0].bday).format('D') : '&nbsp;'}</p>
                </td>
                <td class="txt-center" style="border-left: none; border-right: none;">
                    <span style="font-size: 10px;">(Month)</span> 
                    <p>${groom_details[0].bday ? moment(groom_details[0].bday).format('MMMM') : '&nbsp;'}</p>
                </td>
                <td class="txt-center" style="border-left: none;">
                    <span style="font-size: 10px;">(Year)</span> 
                    <p>${groom_details[0].bday ? moment(groom_details[0].bday).format('YYYY') : '&nbsp;'}</p>
                </td>
                <td class="txt-center" width="5%">
                    <span style="font-size: 10px;">(Age)</span> 
                    <p>${groom_details[0].age}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    2. Date of Birth/ Age
                </td>
                <td class="txt-center" width="10%" style="border-right: none;">
                    <span style="font-size: 10px;">(Day)</span> 
                    <p>${bride_details[0].bday ? moment(bride_details[0].bday).format('D') : '&nbsp;'}</p>
                </td>
                <td class="txt-center" style="border-left: none; border-right: none;">
                    <span style="font-size: 10px;">(Month)</span> 
                    <p>${bride_details[0].bday ? moment(bride_details[0].bday).format('MMMM') : '&nbsp;'}</p>
                </td>
                <td class="txt-center" style="border-left: none;">
                    <span style="font-size: 10px;">(Year)</span> 
                    <p>${bride_details[0].bday ? moment(bride_details[0].bday).format('YYYY') : '&nbsp;'}</p>
                </td>
                <td class="txt-center" width="5%">
                    <span style="font-size: 10px;">(Age)</span> 
                    <p>${bride_details[0].age}</p>
                </td>
            </tr>
        `;
        
        // 12th row
        template += `
            <tr>
                <td class="txt-center" style="border-right: none;">
                    <span style="font-size: 10px;">(City/Municipality)</span> 
                    <p>${groom_details[0].pob_city}</p>
                </td>
                <td colspan=2 class="txt-center" style="border-right: none; border-left: none;">
                    <span style="font-size: 10px;">(Province)</span> 
                    <p>${groom_details[0].pob_province}</p>
                </td>
                <td style="border-left: none;">
                    <span style="font-size: 10px;">(Country)</span> 
                    <p>${groom_details[0].pob_country}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    3. Place of Birth
                </td>
                <td class="txt-center" style="border-right: none;">
                    <span style="font-size: 10px;">(City/Municipality)</span> 
                    <p>${bride_details[0].pob_city}</p>
                </td>
                <td colspan=2 class="txt-center" style="border-right: none; border-left: none;">
                    <span style="font-size: 10px;">(Province)</span> 
                    <p>${bride_details[0].pob_province}</p>
                </td>
                <td style="border-left: none;">
                    <span style="font-size: 10px;">(Country)</span> 
                    <p>${bride_details[0].pob_country}</p>
                </td>
            </tr>
        `;

        // 13th row
        template += `
            <tr>
                <td class="txt-center">
                    <span style="font-size: 10px;">(Male/Female)</span> 
                    <p>${groom_details[0].sex}</p>
                </td>
                <td colspan=3 class="txt-center">
                    <span style="font-size: 10px;">(Citizenship)</span> 
                    <p>${groom_details[0].citizenship}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    4. Sex/ Citizenship
                </td>
                <td class="txt-center">
                    <span style="font-size: 10px;">(Male/Female)</span> 
                    <p>${bride_details[0].sex}</p>
                </td>
                <td colspan=3 class="txt-center">
                    <span style="font-size: 10px;">(Citizenship)</span> 
                    <p>${bride_details[0].citizenship}</p>
                </td>
            </tr>
        `;
        
        // 14th row
        template += `
            <tr>
                <td colspan=4 class="txt-center">
                    <span style="font-size: 10px;">(House No. St., Barangay, City/Municipality, Province, Country)</span> 
                    <p>${groom_details[0].residence}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    5. Residence
                </td>
                <td colspan=4 class="txt-center">
                    <span style="font-size: 10px;">(House No. St., Barangay, City/Municipality, Province, Country)</span> 
                    <p>${bride_details[0].residence}</p>
                </td>
            </tr>
        `;

        // 15th row
        template += `
            <tr>
                <td colspan=4>
                    <p>${groom_details[0].religion || ''}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    6. Religion/ Religious Sect
                </td>
                <td colspan=4>
                    <p>${bride_details[0].religion || ''}</p>
                </td>
            </tr>
        `;

        // 16th row
        template += `
            <tr>
                <td colspan=4>
                    <p>${groom_details[0].civil_status || ''}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    7. Civil Status
                </td>
                <td colspan=4>
                    <p>${bride_details[0].civil_status || ''}</p>
                </td>
            </tr>
        `;

        // 17th row
        template += `
            <tr>
                <td colspan=4>
                    <p>${groom_details[0].previously_married || ''}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 11px;">
                    8. IF PREVIOUSLY MARRIED: How was it dissolved
                </td>
                <td colspan=4>
                    <p>${bride_details[0].previously_married || ''}</p>
                </td>
            </tr>
        `;

        // 18th row
        template += `
            <tr>
                <td colspan=4>
                    <p>${groom_details[0].place_dissolved || ''}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    9. Place where dissolved
                </td>
                <td colspan=4>
                    <p>${bride_details[0].place_dissolved || ''}</p>
                </td>
            </tr>
        `;

        // 19th row
        template += `
            <tr>
                <td class="txt-center" style="border-right: none;">
                    <span style="font-size: 10px;">(Day)</span> 
                    <p>${groom_details[0].date_dissolved ? moment(groom_details[0].date_dissolved).format('D') : '&nbsp;'}</p>
                </td>
                <td colspan=2 class="txt-center" style="border-right: none; border-left: none;">
                    <span style="font-size: 10px;">(Month)</span> 
                    <p>${groom_details[0].date_dissolved ? moment(groom_details[0].date_dissolved).format('MMMM') : '&nbsp;'}</p>
                </td>
                <td class="txt-center" style="border-left: none;">
                    <span style="font-size: 10px;">(Year)</span> 
                    <p>${groom_details[0].date_dissolved ? moment(groom_details[0].date_dissolved).format('YYYY') : '&nbsp;'}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    10. Date when dissolved
                </td>
                <td class="txt-center" style="border-right: none;">
                    <span style="font-size: 10px;">(Day)</span> 
                    <p>${bride_details[0].date_dissolved ? moment(bride_details[0].date_dissolved).format('D') : '&nbsp;'}</p>
                </td>
                <td colspan=2 class="txt-center" style="border-right: none; border-left: none;">
                    <span style="font-size: 10px;">(Month)</span> 
                    <p>${bride_details[0].date_dissolved ? moment(bride_details[0].date_dissolved).format('MMMM') : '&nbsp;'}</p>
                </td>
                <td class="txt-center" style="border-left: none;">
                    <span style="font-size: 10px;">(Year)</span> 
                    <p>${bride_details[0].date_dissolved ? moment(bride_details[0].date_dissolved).format('YYYY') : '&nbsp;'}</p>
                </td>
            </tr>
        `;

        // 20th row
        template += `
            <tr>
                <td colspan=4>
                    <p>${groom_details[0].degree || ''}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 11px;">
                    11. Degree of relationship of contracting parties
                </td>
                <td colspan=4>
                    <p>${bride_details[0].degree || ''}</p>
                </td>
            </tr>
        `;

        // 21st row
        template += `
            <tr>
                <td colspan=4>
                    <p>${groom_details[0].father_name || ''}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    12. Name of Father
                </td>
                <td colspan=4>
                    <p>${bride_details[0].father_name || ''}</p>
                </td>
            </tr>
        `;

        // 22nd row
        template += `
            <tr>
                <td colspan=4>
                    <p>${groom_details[0].father_citizenship || ''}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    13. Citizenship
                </td>
                <td colspan=4>
                    <p>${bride_details[0].father_citizenship || ''}</p>
                </td>
            </tr>
        `;

        // 23rd row
        template += `
            <tr>
                <td colspan=4>
                    <p>${groom_details[0].father_residence || ''}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    14. Residence
                </td>
                <td colspan=4>
                    <p>${bride_details[0].father_residence || ''}</p>
                </td>
            </tr>
        `;

        // 24th row
        template += `
            <tr>
                <td colspan=4>
                    <p>${groom_details[0].mother_fname || ''}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    15. Name of Mother
                </td>
                <td colspan=4>
                    <p>${bride_details[0].mother_fname || ''}</p>
                </td>
            </tr>
        `;

        // 25th row
        template += `
            <tr>
                <td colspan=4>
                    <p>${groom_details[0].mother_citizenship || ''}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    16. Citizenship
                </td>
                <td colspan=4>
                    <p>${bride_details[0].mother_citizenship || ''}</p>
                </td>
            </tr>
        `;

        // 26th row
        template += `
            <tr>
                <td colspan=4 class="txt-center">
                    <span style="font-size: 10px;">(House No. St., Barangay, City/Municipality, Province, Country)</span> 
                    <p>${groom_details[0].mother_residence || '&nbsp;'}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    17. Residence
                </td>
                <td colspan=4 class="txt-center">
                    <span style="font-size: 10px;">(House No. St., Barangay, City/Municipality, Province, Country)</span> 
                    <p>${bride_details[0].mother_residence || '&nbsp;'}</p>
                </td>
            </tr>
        `;

        // 27th row
        template += `
            <tr>
                <td colspan=4>
                    <p>${groom_details[0].person_consent || ''}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    18. Person who gave consent or advice
                </td>
                <td colspan=4>
                    <p>${bride_details[0].person_consent || ''}</p>
                </td>
            </tr>
        `;

        // 28th row
        template += `
            <tr>
                <td colspan=4>
                    <p>${groom_details[0].person_relationship || ''}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    19. Relationship
                </td>
                <td colspan=4>
                    <p>${bride_details[0].person_relationship || ''}</p>
                </td>
            </tr>
        `;

        // 29th row
        template += `
            <tr>
                <td colspan=4>
                    <p>${groom_details[0].person_citizenship || ''}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    20. Citizenship
                </td>
                <td colspan=4>
                    <p>${bride_details[0].person_citizenship || ''}</p>
                </td>
            </tr>
        `;

        // 30th row
        template += `
            <tr>
                <td colspan=4 class="txt-center">
                    <span style="font-size: 10px;">(House No. St., Barangay, City/Municipality, Province, Country)</span> 
                    <p>${groom_details[0].person_residence || '&nbsp;'}</p>
                </td>
                <td colspan=2 width="15%" style="font-size: 12px;">
                    21. Residence
                </td>
                <td colspan=4 class="txt-center">
                    <span style="font-size: 10px;">(House No. St., Barangay, City/Municipality, Province, Country)</span> 
                    <p>${bride_details[0].person_residence || '&nbsp;'}</p>
                </td>
            </tr>
        `;

        // 31st row
        template += `
            <tr>
                <td colspan=5 class="txt-center">
                    <br>
                    __________________________ <br>
                    (Signature of Applicant)
                </td>
                <td colspan=5 class="txt-center">
                    <br>
                    __________________________ <br>
                    (Signature of Applicant)
                </td>
            </tr>
        `;

        // 32nd row
        template += `
            <tr>
                <td colspan=4>
                    <br>
                    <p style="font-size: 9px; text-indent: 10px;"> SUBSCRIBED AND SWORN to before me this ___________ day of</p>
                    <p style="font-size: 9px;"> ______________________, at ______________________________,</p>
                    <p style="font-size: 9px;"> Philippines, affiant who exhibited to me Community Tax Cert</p>
                    <p style="font-size: 9px;"> ___________________ issued on __________________________ at</p>
                    <p style="font-size: 9px;"> _______________________. </p>
                </td>
                <td colspan=2 width="15%" class="txt-center">
                    Exempt from documentary stamp tax
                </td>
                <td colspan=4>
                    <br>
                    <p style="font-size: 9px; text-indent: 10px;"> SUBSCRIBED AND SWORN to before me this ___________ day of</p>
                    <p style="font-size: 9px;"> ______________________, at ______________________________,</p>
                    <p style="font-size: 9px;"> Philippines, affiant who exhibited to me Community Tax Cert</p>
                    <p style="font-size: 9px;"> ___________________ issued on __________________________ at</p>
                    <p style="font-size: 9px;"> _______________________. </p>
                </td>
            </tr>
        `;


        // 32nd row
        template += `
            <tr>
                <td colspan=5 class="txt-center">
                    <br>
                    __________________________ <br>
                    MUNICIPAL CIVIL REGISTRAR
                </td>
                <td colspan=5 class="txt-center">
                    <br>
                    __________________________ <br>
                    MUNICIPAL CIVIL REGISTRAR
                </td>
            </tr>
        `;


        table.append(template);
    });

}
	

// Generate Notice report
$(document).on('click', 'a[data-role=generate-notice]', function(){
    var license_id = $(this).data('id');
    fetchNoticeData(license_id);
    setTimeout(() => {
        let css = `
            @media print {
                @page {
                    size: Legal landscape;  /* Ensure page size is A4 in landscape orientation */
                }
            }
        `;
        
        var toPrint = document.getElementById('notice-report-form');
        var newTab = window.open('', '_blank');
        newTab.document.write('<html><head><title>' + document.title + '</title>');
        newTab.document.write('<style>' + css + '</style>');
        
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

function fetchNoticeData(license_id) {
    const url = '../modules/marriage_license/get-license.php';
    const groom_url = '../modules/marriage_license/get-groom.php';
    const bride_url = '../modules/marriage_license/get-bride.php';

    var template = '';
    var groom_details = [];
    var bride_details = [];

    $.ajaxSetup({async: false});
    $.get(groom_url, { license_id }, (response) => {
        groom_details = JSON.parse(response);
    });

    $.ajaxSetup({async: false});
    $.get(bride_url, { license_id }, (response) => {
        bride_details = JSON.parse(response);
    });
    console.log(bride_details);
    var template = '';

    var table = $('#report-notice-table tbody');
    table.empty();

    $.ajaxSetup({async: false});
    $.get(url, { license_id }, (response) => {
        console.log(response);
        const rows = JSON.parse(response);
        const { province, city, registry_no, received_by, date_receipt, license_no, date_issuance } = rows[0];

        // 1st row
        template += `
            <tr>
                <td colspan=4 class="txt-center">
                    <br>
                    <h3>NOTICE</h3>
                </td>
            </tr>
        `;

        // 2nd row
        template += `
            <tr>
                <td colspan=4>
                    <u>${groom_details[0].fname} ${groom_details[0].mname} ${groom_details[0].lname}</u>
                </td>
            </tr>
        `;
        
        // 3rd row
        template += `
            <tr>
                <td colspan=2>
                    AND
                </td>
                <td colspan=2 class="txt-center">
                    APPLICANTS FOR MARRIAGE LICENSE
                </td>
            </tr>
        `;

        // 4th row
        template += `
            <tr>
                <td colspan=4>
                    <u>${bride_details[0].fname} ${bride_details[0].mname} ${bride_details[0].lname}</u>
                    <br>
                    <br>
                </td>
            </tr>
        `;

        // 5th row
        template += `
            <tr>
                <td>
                    Name
                </td>
                <td colspan=2>
                    <span class="shared-text" style="width: calc(80%);">
                        ${groom_details[0].fname} ${groom_details[0].mname} ${groom_details[0].lname}
                    </span>
                </td>
                <td>
                    Age: <u>${groom_details[0].age}</u>
                </td>
            </tr>
        `;
        
        // 6th row
        template += `
            <tr>
                <td>
                    Birthplace
                </td>
                <td colspan=3>
                    <span class="shared-text" style="width: calc(50%);">
                        ${groom_details[0].pob_city || '&nbsp;'},
                        ${groom_details[0].pob_province || '&nbsp;'},
                        ${groom_details[0].pob_country || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;
        
        // 7th row
        template += `
            <tr>
                <td>
                    Father
                </td>
                <td colspan=3>
                    <span class="shared-text" style="width: calc(50%);">
                        ${groom_details[0].father_name || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;

        // 8th row
        template += `
            <tr>
                <td>
                    Residence
                </td>
                <td colspan=3>
                    <span class="shared-text" style="width: calc(50%);">
                        ${groom_details[0].father_residence || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;
        
        // 8th row
        template += `
            <tr>
                <td>
                    Mother
                </td>
                <td colspan=3>
                    <span class="shared-text" style="width: calc(50%);">
                        ${groom_details[0].mother_name || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;

        // 9th row
        template += `
            <tr>
                <td>
                    Residence
                </td>
                <td colspan=3>
                    <span class="shared-text" style="width: calc(50%);">
                        ${groom_details[0].mother_residence || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;

        // 10th row
        template += `
            <tr>
                <td colspan=4 class="txt-center">
                    <br>
                    <h4>WISHES TO CONTRACT MARRIAGE WITH</h4>
                </td>
            </tr>
        `;

        // 11th row
        template += `
            <tr>
                <td>
                    Name
                </td>
                <td colspan=2>
                    <span class="shared-text" style="width: calc(80%);">
                        ${bride_details[0].fname} ${bride_details[0].mname} ${bride_details[0].lname}
                    </span>
                </td>
                <td>
                    Age: <u>${bride_details[0].age}</u>
                </td>
            </tr>
        `;
        
        // 12th row
        template += `
            <tr>
                <td>
                    Birthplace
                </td>
                <td colspan=3>
                    <span class="shared-text" style="width: calc(50%);">
                        ${groom_details[0].pob_city || '&nbsp;'},
                        ${groom_details[0].pob_province || '&nbsp;'},
                        ${groom_details[0].pob_country || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;
        
        // 13th row
        template += `
            <tr>
                <td>
                    Father
                </td>
                <td colspan=3>
                    <span class="shared-text" style="width: calc(50%);">
                        ${bride_details[0].father_name || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;

        // 14th row
        template += `
            <tr>
                <td>
                    Residence
                </td>
                <td colspan=3>
                    <span class="shared-text" style="width: calc(50%);">
                        ${bride_details[0].father_residence || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;
        
        // 15th row
        template += `
            <tr>
                <td>
                    Mother
                </td>
                <td colspan=3>
                    <span class="shared-text" style="width: calc(50%);">
                        ${bride_details[0].mother_name || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;

        // 16th row
        template += `
            <tr>
                <td>
                    Residence
                </td>
                <td colspan=3>
                    <span class="shared-text" style="width: calc(50%);">
                        ${bride_details[0].mother_residence || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;

        // 17th row
        template += `
            <tr>
                <td colspan=4>
                    <br>
                    <span style="padding-left: 50px; font-size: 13px;">
                        Any person having knowledge of any legal impediment to such marriage, please report it to the undersigned within ten days from this date.
                    </span>
                    <br>
                </td>
            </tr>
        `;

        // 18th row
        template += `
            <tr>
                <td colspan=4 style="text-indent: 20px;">
                    Marriage License maybe issued on <span class="shared-text" style="width: calc(30%);">
                        ${date_issuance || '&nbsp;'}
                    </span>
                    <br><br>
                </td>
            </tr>
        `;

        // 19th row
        template += `
            <tr>
                <td colspan=4>
                    Date Receipt: <span class="shared-text" style="width: calc(30%);">
                        ${date_receipt || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;
        
        // 20th row
        template += `
            <tr>
                <td colspan=4>
                    Application No.: <span class="shared-text" style="width: calc(30%);">
                        
                    </span>
                </td>
            </tr>
        `;

        // 21st row
        template += `
            <tr>
                <td colspan=4>
                    License Due Date: <span class="shared-text" style="width: calc(30%);">
                    </span>
                </td>
            </tr>
        `;
        
        // 22nd row
        template += `
            <tr>
                <td colspan=4>
                    Amount Paid: <span class="shared-text" style="width: calc(30%);">
                    </span>
                </td>
            </tr>
        `;
        
        // 23rd row
        template += `
            <tr>
                <td colspan=4>
                    License No.: <span class="shared-text" style="width: calc(30%);">
                        ${license_no || '&nbsp;'}
                    </span>
                </td>
            </tr>
        `;

        // 24th row
        template += `
            <tr>
                <td colspan=2></td>
                <td colspan=2 class="txt-center">
                    <br>
                    CLEO BELLE C. NAVARETTE <br>
                    Municipal Civil Registrar
                </td>
            </tr>
        `;
        
        // 25th row
        template += `
            <tr>
                <td colspan=4>
                    <br>
                    <span style="font-size: 13px;">
                        NOTE: This notice shall be posted during then (10) consecutive days at the main door of the <br>
                        building where the Local Civil Registrar has his Office and so posted, location shall not be <br>
                        changed. (Rep. Act No. 236 Art. 68)
                    </span>
                </td>
            </tr>
        `;

        table.append(template);
    });

}