<div id="editModal<?= $row['id'] ?>" class="modal fade">
<form method="post" enctype="multipart/form-data">
  <div class="modal-dialog modal-sm" style="width:300px !important;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Edit Brgy Info</h4>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" value="<?= $row['id'] ?>" name="hidden_id" id="hidden_id"/>
                <div class="form-group">
                                    <label>Barangay Logo:</label>
                                    <input name="logo" class="form-control input-sm" type="file"/>
                                </div>
                <div class="form-group">
                    <label>Barangay Info: <span style="color:gray; font-size: 10px;"></span></label>
                    <input name="txt_edit_name" class="form-control input-sm" type="text" value="<?= $row['name'] ?>"/>
                </div>
                <div class="form-group">
                    <label>Username: </label>
                    <input name="txt_edit_uname" class="form-control input-sm" type="text" value="<?= $row['username'] ?>" />
                </div>
                <div class="form-group">
                    <label>Password: </label>
                    <input name="txt_edit_pass" class="form-control input-sm" type="password"  />
                </div>
                <div class="form-group">
                    <label>Comfirm Password: </label>
                    <input name="txt_edit_compass" class="form-control input-sm" type="password" />
                </div>
            </div>
        </div>
        </div>
        <div class="modal-footer">
            <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel"/>
            <input type="submit" class="btn btn-primary btn-sm" name="btn_save" value="Save"/>
        </div>
    </div>
  </div>
</form>
</div>