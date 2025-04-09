<div class="modal fade" id="witness-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add Witness</h4>
            </div>
            <form id="witness-form" class="form-horizontal" autocomplete="off">
                <div class="modal-body">
                    <div class="panel">
                        <div class="panel-body">
                            <input type="hidden" name="witness_id">
                                                                    
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Witness Name<span class="text-danger">*</span></label>
                                        <input type="text" name="witness_names" class="form-control" required>    
                                    </div>
                                    <div class="col-md-6">
                                        <label>Residency<span class="text-danger">*</span></label> 
                                        <input type="text" name="residency" class="form-control" required>    
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Name of soon to be married<span class="text-danger">*</span></label> 
                                        <input type="text" name="name" class="form-control" required>    
                                    </div>
                                    <div class="col-md-4">
                                        <label>Civil status of soon to be marriedy<span class="text-danger">*</span></label> 
                                        <input type="text" name="civil_status" class="form-control" required>    
                                    </div>
                                    <div class="col-md-4">
                                        <label>To marry<span class="text-danger">*</span></label> 
                                        <input type="text" name="to_marry" class="form-control" required>    
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>ID No.<span class="text-danger">*</span></label> 
                                        <input type="text" name="id_no" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Date Issued<span class="text-danger">*</span></label> 
                                        <input type="date" name="date_issued" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Issued at<span class="text-danger">*</span></label> 
                                        <input type="text" name="issued_at" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>