<div class="modal fade" id="view-consent-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">View Consent</h4>
            </div>
                <div class="modal-body">
                    <button class="btn btn-primary btn-rounded btn-sm" id="add-consent"><i class="fa fa-plus-circle"></i> Add</button>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table class="table table-bordered" id="view-consent-table">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Parent Name</th>
                                                <th>Parent Address</th>
                                                <th>Relationship</th>
                                                <th>Child Name</th>
                                                <th>Child Address</th>
                                                <th>Age</th>
                                                <th>To Marry</th>
                                                <th>To Marry Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
        </div>
    </div>
</div>

<!-- CONSENT MODAL -->
<?php include('modal/consent.php') ?>
<!-- END CONSENT MODAL -->

<!-- CONSENT REPORT MODAL -->
<?php include('modal/report_consent.php') ?>
<!-- END CONSENT REPORT MODAL -->