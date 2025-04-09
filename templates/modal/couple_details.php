<div class="modal fade" id="details-modal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" ><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus-square"></i> Add Couple Details</h4>
            </div>
            <form id="couple-form" class="form-horizontal" autocomplete="off">
                <div class="modal-body">
                    <div class="panel">
                        <div class="panel-body">
                            <input type="hidden" name="id">
                            <input type="hidden" name="type">
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label id="couple-label">Bride name<span class="text-danger">*</span></label> 
                                        <input type="text" name="to_marry" class="form-control" required>    
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>First name<span class="text-danger">*</span></label> 
                                        <input type="text" name="fname" class="form-control" required>    
                                    </div>
                                    <div class="col-md-4">
                                        <label>Middle name</label> 
                                        <input type="text" name="mname" class="form-control">    
                                    </div>
                                    <div class="col-md-4">
                                        <label>Last name<span class="text-danger">*</span></label> 
                                        <input type="text" name="lname" class="form-control" required>    
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Date of Birth<span class="text-danger">*</span></label> 
                                        <input type="date" name="bday" class="form-control" required>    
                                    </div>
                                    <div class="col-md-3">
                                        <label>Pleace of Birth<span class="text-danger">*</span></label> 
                                        <input type="text" name="pob" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Sex<span class="text-danger">*</span></label> 
                                        <select name="sex" class="form-control" required>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Citizenship<span class="text-danger">*</span></label> 
                                        <input type="text" name="citizenship" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Residence<span class="text-danger">*</span></label> 
                                        <input type="text" name="residence" class="form-control" required>    
                                    </div>
                                    <div class="col-md-3">
                                        <label>Religion<span class="text-danger">*</span></label> 
                                        <input type="text" name="religion" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Civil Status<span class="text-danger">*</span></label> 
                                        <input type="text" name="civil_status" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <p>If previously Married</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>How was it dissolved</label> 
                                        <input type="text" name="previously_married" class="form-control">    
                                    </div>
                                    <div class="col-md-3">
                                        <label>Place where dissolved</label> 
                                        <input type="text" name="place_dissolved" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Date when dissolved</label> 
                                        <input type="date" name="date_dissolved" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Degree of relationship w/ contracting parties</label> 
                                        <input type="text" name="degree" class="form-control">    
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Father Name</label> 
                                        <input type="text" name="father_name" class="form-control">    
                                    </div>
                                    <div class="col-md-4">
                                        <label>Father Citizenship</label> 
                                        <input type="text" name="father_citizenship" class="form-control">    
                                    </div>
                                    <div class="col-md-4">
                                        <label>Father Residence</label> 
                                        <input type="text" name="father_residence" class="form-control">    
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Mother Name</label> 
                                        <input type="text" name="mother_name" class="form-control">    
                                    </div>
                                    <div class="col-md-4">
                                        <label>Mother Citizenship</label> 
                                        <input type="text" name="mother_citizenship" class="form-control">    
                                    </div>
                                    <div class="col-md-4">
                                        <label>Mother Residence</label> 
                                        <input type="text" name="mother_residence" class="form-control">    
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <p>Person who gave consent or advice</p>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Name</label> 
                                        <input type="text" name="person_consent" class="form-control">    
                                    </div>
                                    <div class="col-md-4">
                                        <label>Relationship</label> 
                                        <input type="text" name="person_relationship" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Residence</label> 
                                        <input type="date" name="person_residence" class="form-control">
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