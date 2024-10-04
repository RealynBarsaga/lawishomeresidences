<style>
    /* Container for the input group to ensure proper positioning */
.form-group {
    position: relative;
}

/* Style for the eye icon */
.input-group-text {
    position: absolute;
    top: 70%;
    right: 10px; /* Adjust as needed */
    transform: translateY(-50%);
    background: transparent;
    border: none;
    cursor: pointer;
    font-size: 16px; /* Adjust size as needed */
    color: #aaa; /* Light color for the icon */
}

/* Ensure input field has sufficient padding to avoid overlap with the eye icon */
.form-control {
    padding-right: 40px; /* Adjust based on icon size */
}

/* Optional: Add some styles for the form group to improve appearance */
.form-group {
    margin-bottom: 1rem; /* Space between form groups */
}
</style>
<!-- ========================= MODAL ======================= -->
            <div id="addModal" class="modal fade">
            <form method="post" enctype="multipart/form-data">
              <div class="modal-dialog modal-sm" style="width:300px !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Manage Brgy</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Barangay Logo:</label>
                                    <input name="logo" class="form-control input-sm" type="file" required/>
                                </div>
                                <div class="form-group">
                                    <label>Name:</label>
                                    <select name="txt_name" class="form-control input-sm">
                                        <option selected="" disabled="">Select Barangay</option>
                                        <option value="Tabagak">Brgy.Tabagak</option>
                                        <option value="Bunakan">Brgy.Bunakan</option>
                                        <option value="Kodia">Brgy.Kodia</option>
                                        <option value="Talangnan">Brgy.Talangnan</option>
                                        <option value="Poblacion">Brgy.Poblacion</option>
                                        <option value="Maalat">Brgy.Maalat</option>
                                        <option value="Pili">Brgy.Pili</option>
                                        <option value="Kaongkod">Brgy.Kaongkod</option>
                                        <option value="Mancilang">Brgy.Mancilang</option>
                                        <option value="Kangwayan">Brgy.Kangwayan</option>
                                        <option value="Tugas">Brgy.Tugas</option>
                                        <option value="Malbago">Brgy.Malbago</option>
                                        <option value="Tarong">Brgy.Tarong</option>
                                        <option value="San Agustin">Brgy.San Agustin</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Username:</label>
                                    <input name="txt_uname" class="form-control input-sm" id="username"  type="text" placeholder="Username" require/>
                                    <label id="user_msg" style="color:#CC0000;" ></label>
                                </div>
                                <div class="form-group">
                                    <label>Password:</label>
                                    <input name="txt_pass" class="form-control input-sm" type="password" placeholder="Password" required pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{10,}$"  title="Password must be at least 10 characters long, contain at least one uppercase letter, one number, and one special character."/>
                                    <span class="input-group-text">
                                        <i class="fa fa-eye" id="togglePassword1"></i>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password:</label>
                                    <input name="txt_compass" class="form-control input-sm" type="password" placeholder="Confirm Password" required/>
                                    <span class="input-group-text">
                                        <i class="fa fa-eye" id="togglePassword2"></i>
                                    </span>
                                </div>
                                <div id="password_error" class="text-danger" style="font-size:11px;"></div> <!-- Error message will be displayed here -->
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
    // Toggle password visibility
    $('#togglePassword1').click(function() {
        const passwordField = $('input[name="txt_pass"]');
        const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    $('#togglePassword2').click(function() {
        const confirmPasswordField = $('input[name="txt_compass"]');
        const type = confirmPasswordField.attr('type') === 'password' ? 'text' : 'password';
        confirmPasswordField.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    // Validate passwords on form submission
    $('#btn_add').click(function(e) {
        var password = $('input[name="txt_pass"]').val();
        var confirmPassword = $('input[name="txt_compass"]').val();

        if (password !== confirmPassword) {
            e.preventDefault(); // prevent form submission
            $('#password_error').text('Passwords do not match. Please try again.'); // Display error message
        } else {
            $('#password_error').text(''); // Clear any previous error message
        }
    });
});
</script>
