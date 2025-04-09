<div class="modal fade" id="view-advice-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">View Advice</h4>
            </div>
                <div class="modal-body">
                    <button class="btn btn-primary btn-rounded btn-sm" id="add-advice"><i class="fa fa-plus-circle"></i> Add</button>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table class="table table-bordered" id="view-advice-table">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Sex</th>
                                                <th>Place</th>
                                                <th>Date</th>
                                                <th>Advice to</th>
                                                <th>To Marry</th>
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

<!-- ADVICE MODAL -->
<?php include('modal/advice.php') ?>
<!-- END ADVICE MODAL -->

<!-- ADVICE REPORT MODAL -->
<?php include('modal/report_advice.php') ?>
<!-- END ADVICE REPORT MODAL -->