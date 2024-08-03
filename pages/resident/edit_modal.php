<?php echo '
<div id="editModal'.$row['id'].'" class="modal fade" role="dialog">
<form class="form-horizontal" method="post" enctype="multipart/form-data">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Edit Resident Information</h4>
        </div>
        <div class="modal-body">';

        $edit_query = mysqli_query($con,"SELECT * from tblresident where id = '".$row['id']."' ");
        $erow = mysqli_fetch_array($edit_query);

        // Calculate age based on birthdate
        $birthdate = new DateTime($erow['bdate']);
        $today = new DateTime();
        $age = $today->diff($birthdate)->y;

        echo '
            <div class="row">
                <div class="container-fluid">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <input type="hidden" value="'.$erow['id'].'" name="hidden_id" id="hidden_id"/>
                            <label class="control-label">Name:</label><br>
                            <div class="col-sm-4">
                                Lastname:
                                <input name="txt_edit_lname" class="form-control input-sm" type="text" value="'.$erow['lname'].'"/>
                            </div> 
                            <div class="col-sm-4">
                                Firstname:
                                <input name="txt_edit_fname" class="form-control input-sm" type="text" value="'.$erow['fname'].'"/>
                            </div> 
                            <div class="col-sm-4">
                                Middlename:
                                <input name="txt_edit_mname" class="form-control input-sm" type="text" value="'.$erow['mname'].'"/>
                            </div> <br>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Age:</label>
                            <input name="txt_edit_age" id="txt_edit_age" class="form-control input-sm" type="text" value="'.$age.'" readonly/>
                            <label class="control-label" style="margin-top:10px;">Birthdate:</label>
                            <input name="txt_edit_bdate" id="txt_edit_bdate" class="form-control input-sm" type="date" value="'.$erow['bdate'].'" onchange="calculateAge()" min="1924-01-01" max="'.date('Y-m-d').'"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Barangay:</label>
                            <input name="txt_edit_brgy" class="form-control input-sm input-size" type="text" value="'.$erow['barangay'].'" style="width: 405px;" disable/>
                        </div>

                         <div class="form-group">
                            <label class="control-label">Purok:</label>
                            <input name="txt_edit_purok" class="form-control input-sm input-size" type="text" value="'.$erow['purok'].'" style="width: 405px;"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Household #:</label>
                            <input name="txt_edit_householdnum" class="form-control input-sm" type="number" min="1" value="'.$erow['householdnum'].'"/>
                        </div>

                        <!-- Civil Status -->
                        <div class="form-group">
                            <label class="control-label">Civil Status:</label>
                            <select name="txt_edit_cstatus" class="form-control input-sm" style="width: 405px;">
                                <option value="" disabled selected>Select Civil Status</option>
                                <option value="Single" '.($erow['civilstatus'] == 'Single' ? 'selected' : '').'>Single</option>
                                <option value="Married" '.($erow['civilstatus'] == 'Married' ? 'selected' : '').'>Married</option>
                                <option value="Widowed" '.($erow['civilstatus'] == 'Widowed' ? 'selected' : '').'>Widowed</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Nationality:</label>
                            <input name="txt_edit_national" class="form-control input-sm" type="text" value="'.$erow['nationality'].'"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Land Ownership Status:</label>
                            <select name="ddl_edit_los" class="form-control input-sm">
                                <option value="'.$erow['landOwnershipStatus'].'">'.$erow['landOwnershipStatus'].'</option>
                                <option>Owned</option>
                                <option>Landless</option>
                                <option>Tenant</option>
                                <option>Care Taker</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Gender:</label>
                            <select name="ddl_edit_gender" class="form-control input-sm">
                                <option value="'.$erow['gender'].'" selected="">'.$erow['gender'].'</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Birthplace:</label>
                            <input name="txt_edit_bplace" class="form-control input-sm" type="text" value="'.$erow['bplace'].'"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Total Household Member:</label>
                            <input name="txt_edit_householdmem" class="form-control input-sm" type="number" min="1" value="'.$erow['totalhousehold'].'"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Religion:</label>
                            <input name="txt_edit_religion" class="form-control input-sm" type="text" value="'.$erow['religion'].'"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label">House Ownership Status:</label>
                            <select name="ddl_edit_hos" class="form-control input-sm">
                                <option value="'.$erow['houseOwnershipStatus'].'" selected>'.$erow['houseOwnershipStatus'].'</option>
                                <option value="Own Home">Own Home</option>
                                <option value="Rent">Rent</option>
                                <option value="Live with Parents/Relatives">Live with Parents/Relatives</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Lightning Facilities:</label>
                            <select name="txt_edit_lightning" class="form-control input-sm input-size" style="width: 405px;">
                                <option>Electric</option>
                                <option>Lamp</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Former Address:</label>
                            <input name="txt_edit_faddress" class="form-control input-sm" type="text" value="'.$erow['formerAddress'].'"/>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">Image:</label>
                            <input name="txt_edit_image" class="form-control input-sm" type="file" />
                        </div>
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
</div>'; ?>

<script>
function calculateAge() {
    var dob = new Date(document.getElementById('txt_edit_bdate').value);
    var today = new Date();
    var age = today.getFullYear() - dob.getFullYear();
    var m = today.getMonth() - dob.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
        age--;
    }
    document.getElementById('txt_edit_age').value = age;
}

// Set minimum date to January 1, 2024 and disable future years
document.getElementById('txt_edit_bdate').setAttribute('min', '1924-01-01');
document.getElementById('txt_edit_bdate').setAttribute('max', new Date().toISOString().split('T')[0]);
</script>
