<div id="notice-report-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="notice-report-form">
                <button class="btnPrint" style="background-color: #007BFF; color: white; padding: 15px 25px; border: none; border-radius: 5px; cursor: pointer;"
                    onmouseover="this.style.backgroundColor='#0056b3'" 
                    onmouseout="this.style.backgroundColor='#007BFF'" onclick="window.print()">PRINT
                </button>

                <table width="100%">
                    <tbody>
                        <tr>
                            <td colspan=3>Municipal Form No. 94</td>
                        </tr>
                        <tr>
                            <td colspan=3>(Form 9)</td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">
                                <img src="../public/img/logo.png" alt="College Logo" width="50px" height="50px">
                            </td>
                            <td class="txt-center">
                                <p>Republic of the Philippines</p>
                                <p>Province of Agusan del Norte</p>
                                <p>Municipality of Nasipit</p>
                            </td>
                            <td>
                                <img src="../public/img/psa-logo.png" alt="College Logo" width="50px" height="50px">
                            </td>
                        </tr>
                        <tr class="txt-center txt-bold">
                            <td colspan=3>OFFICE OF THE MUNICIPAL CIVIL REGISTRAR</td>
                        </tr>
                    </tbody>
                </table>

                <table id="report-notice-table" width="100%">
                    <thead></thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div>
</div> 