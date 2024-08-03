<!-- ========================= MODAL ======================= -->
<div id="addCourseModal" class="modal fade">
    <form class="form-horizontal" method="post" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Manage Residents</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">

                                <!-- Name -->
                                <div class="form-group">
                                    <label class="control-label">Name:</label><br>
                                    <div class="col-sm-4">
                                        <input name="txt_lname" class="form-control input-sm" type="text" placeholder="Lastname"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <input name="txt_fname" class="form-control input-sm" type="text" placeholder="Firstname"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <input name="txt_mname" class="form-control input-sm" type="text" placeholder="Middlename"/>
                                    </div>
                                </div>

                                <!-- Age -->
                                <div class="form-group">
                                    <label class="control-label">Age:</label>
                                    <input name="txt_age" id="txt_age" class="form-control input-sm" type="text" placeholder="Age" readonly style="width: 419px;"/>
                                </div>

                                <!-- Birthdate -->
                                <div class="form-group">
                                    <label class="control-label">Birthdate:</label>
                                    <input name="txt_bdate" id="txt_bdate" class="form-control input-sm" type="date" placeholder="Birthdate" max="<?php echo date('Y-m-d'); ?>" style="width: 419px;"/>
                                </div>

                                <!-- Barangay -->
                                <div class="form-group">
                                     <label class="control-label">Barangay:</label>
                                     <input name="txt_brgy" class="form-control input-sm" type="text" placeholder="Barangay" style="width: 419px;" 
                                     value="<?php echo htmlspecialchars($erow['barangay']); ?>" disabled />
                                </div>


                                <!-- Purok -->
                                <div class="form-group">
                                    <label class="control-label">Purok:</label>
                                    <input name="txt_purok" class="form-control input-sm" type="text" placeholder="Purok" style="width: 419px;"/>
                                </div>

                                <!-- Household # -->
                                <div class="form-group">
                                    <label class="control-label">Household #:</label>
                                    <input name="txt_householdnum" class="form-control input-sm" type="number" min="1" placeholder="Household #" style="width: 419px;"/>
                                </div>
                               <!-- Civil Status -->
                               <div class="form-group">
                                   <label class="control-label">Civil Status:</label>
                                   <select name="txt_cstatus" class="form-control input-sm" style="width: 419px;">
                                        <option value="" disabled selected>Select Civil Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                   </select>
                                </div>

                                <!-- Religion -->
                                <div class="form-group">
                                    <label class="control-label">Religion:</label>
                                    <input name="txt_religion" class="form-control input-sm" type="text" placeholder="Religion" style="width: 419px;"/>
                                </div>

                                <!-- Land Ownership Status -->
                                <div class="form-group">
                                    <label class="control-label">Land Ownership Status:</label>
                                    <select name="ddl_los" class="form-control input-sm" style="width: 419px;">
                                        <option>Owned</option>
                                        <option>Landless</option>
                                        <option>Tenant</option>
                                        <option>Care Taker</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-6 col-sm-12">

                                <!-- Gender -->
                                <div class="form-group">
                                    <label class="control-label">Gender:</label>
                                    <select name="ddl_gender" class="form-control input-sm">
                                        <option selected="" disabled="">-Select Gender-</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <!-- Birthplace -->
                                <div class="form-group">
                                    <label class="control-label">Birthplace:</label>
                                    <input name="txt_bplace" class="form-control input-sm" type="text" placeholder="Birthplace"/>
                                </div>

                                <!-- Total Household Member -->
                                <div class="form-group">
                                    <label class="control-label">Total Household Members:</label>
                                    <input name="txt_householdmem" class="form-control input-sm" type="number" min="1" placeholder="Total Household Members"/>
                                </div>

                                <!-- Nationality -->
                                <div class="form-group">
                                    <label class="control-label">Nationality:</label>
                                    <input name="txt_national" class="form-control input-sm" type="text" placeholder="Nationality"/>
                                </div>

                                <!-- House Ownership Status -->
                                <div class="form-group">
                                    <label class="control-label">House Ownership Status:</label>
                                    <select name="ddl_hos" class="form-control input-sm">
                                        <option value="Own Home">Own Home</option>
                                        <option value="Rent">Rent</option>
                                        <option value="Live with Parents/Relatives">Live with Parents/Relatives</option>
                                    </select>
                                </div>

                                <!-- Lightning Facilities -->
                                <div class="form-group">
                                    <label class="control-label">Lightning Facilities:</label>
                                    <select name="txt_lightning" class="form-control input-sm">
                                        <option>Electric</option>
                                        <option>Lamp</option>
                                    </select>
                                </div>

                                <!-- Former Address -->
                                <div class="form-group">
                                    <label class="control-label">Former Address:</label>
                                    <input name="txt_faddress" class="form-control input-sm" type="text" placeholder="Former Address"/>
                                </div>

                                <!-- Image -->
                                <div class="form-group">
                                    <label class="control-label">Image:</label>
                                    <input name="txt_image" class="form-control input-sm" type="file"/>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel"/>
                    <input type="submit" class="btn btn-primary btn-sm" name="btn_add" id="btn_add" value="Add"/>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
 
        var timeOut = null; // this used for hold few seconds to made ajax request
 
        var loading_html = '<img src="../../img/ajax-loader.gif" style="height: 20px; width: 20px;"/>'; // just an loading image or we can put any texts here
 
        //when button is clicked
        $('#username').keyup(function(e){
 
            // when press the following key we need not to make any ajax request, you can customize it with your own way
            switch(e.keyCode)
            {
                //case 8:   //backspace
                case 9:     //tab
                case 13:    //enter
                case 16:    //shift
                case 17:    //ctrl
                case 18:    //alt
                case 19:    //pause/break
                case 20:    //caps lock
                case 27:    //escape
                case 33:    //page up
                case 34:    //page down
                case 35:    //end
                case 36:    //home
                case 37:    //left arrow
                case 38:    //up arrow
                case 39:    //right arrow
                case 40:    //down arrow
                case 45:    //insert
                //case 46:  //delete
                    return;
            }
            if (timeOut != null)
                clearTimeout(timeOut);
            timeOut = setTimeout(is_available, 500);  // delay delay ajax request for 1000 milliseconds
            $('#user_msg').html(loading_html); // adding the loading text or image
        });
  });
function is_available(){
    //get the username
    var username = $('#username').val();
 
    //make the ajax request to check is username available or not
    $.post("check_username.php", { username: username },
    function(result)
    {
        console.log(result);
        if(result != 0)
        {
            $('#user_msg').html('Not Available');
            document.getElementById("btn_add").disabled = true;
        }
        else
        {
            $('#user_msg').html('<span style="color:#006600;">Available</span>');
            document.getElementById("btn_add").disabled = false;
        }
    });
}
$(document).ready(function() {
        // Calculate age function
        $('#txt_bdate').change(function(){
            var dob = new Date($(this).val());
            var today = new Date();
            var age = today.getFullYear() - dob.getFullYear();
            var m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            $('#txt_age').val(age);
        });
    });
</script>
