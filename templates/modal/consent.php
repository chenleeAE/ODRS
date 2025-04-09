<div class="modal fade" id="consent-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add Consent</h4>
            </div>
            <form id="consent-form" class="form-horizontal" autocomplete="off">
                <div class="modal-body">
                    <div class="panel">
                        <div class="panel-body">
                            <input type="hidden" name="consent_id">
                                                                    
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Parent Name<span class="text-danger">*</span></label> 
                                        <input type="text" name="parent_name" class="form-control" required>    
                                    </div>
                                    <div class="col-md-4">
                                        <label>Parent Address<span class="text-danger">*</span></label> 
                                        <input type="text" name="parent_address" class="form-control" required>    
                                    </div>
                                    <div class="col-md-4">
                                        <label>Relationship<span class="text-danger">*</span></label> 
                                        <input type="text" name="relationship" class="form-control" required>    
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Child Name<span class="text-danger">*</span></label> 
                                        <input type="text" name="child_name" class="form-control" required>    
                                    </div>
                                    <div class="col-md-4">
                                        <label>Child Residence<span class="text-danger">*</span></label> 
                                        <input type="text" name="child_address" class="form-control" required>    
                                    </div>
                                    <div class="col-md-4">
                                        <label>Child Age<span class="text-danger">*</span></label> 
                                        <input type="text" name="child_age" class="form-control" required>    
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>To Marry<span class="text-danger">*</span></label> 
                                        <input type="text" name="to_marry" class="form-control" required>    
                                    </div>
                                    <div class="col-md-6">
                                        <label>To Marry Address<span class="text-danger">*</span></label> 
                                        <input type="text" name="to_marry_address" class="form-control" required>    
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