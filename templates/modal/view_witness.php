<div class="modal fade" id="view-witness-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">View Witness</h4>
            </div>
                <div class="modal-body">
                    <button class="btn btn-primary btn-rounded btn-sm" id="add-witness"><i class="fa fa-plus-circle"></i> Add</button>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table class="table table-bordered" id="view-witness-table">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Witness Names</th>
                                                <th>Residency</th>
                                                <th>Name</th>
                                                <th>Civil Status</th>
                                                <th>To Marry</th>
                                                <th>ID No</th>
                                                <th>Date Issued</th>
                                                <th>Issued at</th>
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

<!-- WITNESS MODAL -->
<?php include('modal/witness.php') ?>
<!-- END WITNESS MODAL -->

<!-- WITNESS REPORT MODAL -->
<?php include('modal/report_witness.php') ?>
<!-- END WITNESS REPORT MODAL -->