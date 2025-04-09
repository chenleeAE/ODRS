<div class="modal fade" id="advice-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add Advice</h4>
            </div>
            <form id="advice-form" class="form-horizontal" autocomplete="off">
                <div class="modal-body">
                    <div class="panel">
                        <div class="panel-body">
                            <input type="hidden" name="advice_id">
                                                                    
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Sex<span class="text-danger">*</span></label> 
                                        <select name="sex" class="form-control" required>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Place<span class="text-danger">*</span></label> 
                                        <input type="text" name="place" class="form-control" required>    
                                    </div>
                                    <div class="col-md-4">
                                        <label>Date<span class="text-danger">*</span></label> 
                                        <input type="date" name="date" class="form-control" required>    
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>To<span class="text-danger">*</span></label> 
                                        <input type="text" name="advice_to" class="form-control" required>    
                                    </div>
                                    <div class="col-md-6">
                                        <label>Intended marriage with<span class="text-danger">*</span></label> 
                                        <input type="text" name="to_marry" class="form-control" required>    
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