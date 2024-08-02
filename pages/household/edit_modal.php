<?php 
echo '<div id="editModal' . $row['id'] . '" class="modal fade">
    <form method="post">
        <div class="modal-dialog modal-sm" style="width:300px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Household Info</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" value="' . $row['id'] . '" name="hidden_id" id="hidden_id"/>
                            <input type="hidden" value="' . $row['householdno'] . '" name="hiddennum" id="hiddennum"/>
                            <div class="form-group">
                                <label>Household #: </label>
                                <input name="txt_edit_householdno" class="form-control input-sm" type="text" value="' . $row['householdno'] . '" readonly/>
                            </div>
                            <div class="form-group">
                                <label>Head of Family: <span style="color:gray; font-size: 10px;"></label>';
                                    $q = mysqli_query($con, "SELECT *, CONCAT(lname, ', ', fname, ' ', mname) as name FROM tblresident WHERE id = '" . $row['headoffamily'] . "' ");
                                    while ($row1 = mysqli_fetch_array($q)) {
                                        echo '<input name="txt_edit_name" class="form-control input-sm" type="text" value="' . $row1['name'] . '" readonly/>';
                                    }
                                echo '
                            </div>
                            <div class="form-group">
                                <label>Total Household Members : </label>
                                <input id="txt_edit_totalmembers" name="txt_edit_totalmembers" class="form-control input-sm" type="number" value="' . $row['totalhousehold'] . '" readonly/>
                            </div>
                            <div class="form-group">
                                <label>Purok : </label>
                                <input id="txt_edit_purok" name="txt_edit_purok" class="form-control input-sm" type="number" value="' . $row['purok'] . '" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                   
                </div>
            </div>
        </div>
    </form>
</div>';
?>

<!-- <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel"/>
<input type="submit" class="btn btn-primary btn-sm" name="btn_save" value="Save"/> -->