<!-- Edit Birth Certificate Modal -->
<div class="modal fade" id="editBirthModal<?php echo $rs['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editBirthLabel<?php echo $rs['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="backend/editbirth.php" method="POST" class="form-horizontal" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Birth Certificate Request</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="request_id" value="<?php echo $rs['id']; ?>">

                    <div class="form-group">
                        <label>Request For<span class="text-danger">*</span></label>
                        <div class="i-checks checkbox-inline">
                            <label><input type="radio" name="request_for" value="BIRTH CERTIFICATE" <?php if ($rs['request_for'] == 'BIRTH CERTIFICATE') echo 'checked'; ?>> BIRTH CERTIFICATE</label>
                        </div>
                        <div class="i-checks checkbox-inline">
                            <label><input type="radio" name="request_for" value="AUTHENTICATION" <?php if ($rs['request_for'] == 'AUTHENTICATION') echo 'checked'; ?>> AUTHENTICATION</label>
                        </div>
                        <div class="i-checks checkbox-inline">
                            <label><input type="radio" name="request_for" value="CD/LI" <?php if ($rs['request_for'] == 'CD/LI') echo 'checked'; ?>> CD/LI</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">
                            <label>Number of Copies<span class="text-danger">*</span></label>
                            <input type="number" name="number_of_copies" class="form-control" min="1" required value="<?php echo $rs['number_of_copies']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Birth Reference No. BReN</label>
                            <input type="text" name="brn" class="form-control" value="<?php echo $rs['brn']; ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Sex<span class="text-danger">*</span></label>
                            <select name="sex" class="form-control" required>
                                <option value="Male" <?php if ($rs['sex'] == 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($rs['sex'] == 'Female') echo 'selected'; ?>>Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- You can add more fields here as needed based on original birth modal -->

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>