<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add Marriage License</h4>
            </div>
            <form id="license-form" class="form-horizontal" autocomplete="off">
                <div class="modal-body">
                    <div class="panel">
                        <div class="panel-body">
                            <input type="hidden" name="id">
                                                                    
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Client Name<span class="text-danger">*</span></label>
                                        <input type="text" name="client_name" class="form-control" required>    
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Received By<span class="text-danger">*</span></label> 
                                        <input type="text" name="received_by" class="form-control" required>    
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