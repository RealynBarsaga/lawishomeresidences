<?php echo '<div id="editModal'.$row['id'].'" class="modal fade">
<form method="post" enctype="multipart/form-data">
  <div class="modal-dialog modal-sm" style="width:300px !important;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Edit Officials Info</h4>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" value="'.$row['id'].'" name="hidden_id" id="hidden_id"/>
                <div class="form-group">
                    <label>Position: </label>
                    <input class="form-control input-sm" type="text" value="'.$row['sPosition'].'" readonly/>
                </div>
                <div class="form-group">
                    <label>Name: <span style="color:gray; font-size: 10px;">(Firstname Middlename, Lastname)</span></label>
                    <input name="txt_edit_cname" class="form-control input-sm" type="text" value="'.$row['completeName'].'" required/>
                </div>
                <div class="form-group">
                    <label>Image:</label>
                    <input name="txt_edit_image" class="form-control input-sm" type="file"/>
                </div>
                <div class="form-group">
                    <label>Contact #:</label>
                    <input name="txt_edit_contact" id="txt_contact" class="form-control input-sm" type="text" value="'.$row['pcontact'].'" maxlength="11" pattern="^\d{11}$" required />
                </div>

                <div class="form-group">
                    <label>Address: </label>
                    <input name="txt_edit_address" class="form-control input-sm" type="text" value="'.$row['paddress'].'" required/>
                </div>
                <div class="form-group">
                    <label>Start Term: </label>
                    <input name="txt_edit_sterm" class="form-control input-sm" type="date" value="'.$row['termStart'].'" required/>
                </div>
                <div class="form-group">
                    <label>End Term: </label>
                    <input name="txt_edit_eterm" class="form-control input-sm" type="date" value="'.$row['termEnd'].'" required/>
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
</div>';?>