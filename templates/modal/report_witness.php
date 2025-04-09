<div id="witness-report-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="witness-report-form">
                <button class="btnPrint" style="background-color: #007BFF; color: white; padding: 15px 25px; border: none; border-radius: 5px; cursor: pointer;"
                    onmouseover="this.style.backgroundColor='#0056b3'" 
                    onmouseout="this.style.backgroundColor='#007BFF'" onclick="window.print()">PRINT
                </button>
                <br>
                <div class="header">
                    <img src="../public/img/logo.png" alt="College Logo" class="logo">
                    <div class="header-content">
                        <h2>Republic of the Philippines</h2>
                        <p>Province of Agusan del Norte</p>
                        <p>Municipality of Nasipit</p>
                        <br>
                    </div>
                </div>
                
                <table id="report-table" width="100%">
                    <thead></thead>
                    <tbody></tbody>
                </table>

                <!-- Footer with image -->
                <!-- <footer>
                    <img src="assets/img/footer.png" alt="Footer Image">
                </footer> -->

            </div>
        </div>
    </div>
</div> 