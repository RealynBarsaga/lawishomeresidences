<style>
    .form-group {
        position: relative;
    }

    /* Style for the eye icon */
    .input-group-text {
        position: absolute;
        top: 50%;
        right: 10px; /* Adjust as needed */
        transform: translateY(-50%);
        background: transparent;
        border: none;
        cursor: pointer;
        font-size: 16px; /* Adjust size as needed */
        color: #aaa; /* Light color for the icon */
    }

    .input-group-text:hover {
        color: #333; /* Darken on hover */
    }

    .text-danger {
        font-size: 11px;
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
                                <select name="txt_name" class="form-control input-sm" required>
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
                                <input name="txt_uname" class="form-control input-sm" id="username" type="text" placeholder="Username" required/>
                                <label id="user_msg" class="text-danger"></label>
                            </div>

                            <div class="form-group">
                                <label>Email:</label>
                                <input name="txt_email" class="form-control input-sm" type="email" placeholder="Ex: juan@sample.com" required/>
                            </div>

                            <div class="form-group" style="position: relative;">
                                <label>Password:</label>
                                <input name="txt_pass" class="form-control input-sm" type="password" id="txt_pass" placeholder="************" required 
                                    pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{10,}$"
                                    title="Password must be at least 10 characters long, contain at least one uppercase letter, one number, and one special character." />
                                
                                <!-- Positioning the eye icon absolutely within the form group -->
                                <span class="input-group-text" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                    <i class="fa fa-eye" id="togglePassword"></i>
                                </span>
                            </div>

                            <div class="form-group">
                                <label>Confirm Password:</label>
                                <input name="txt_compass" class="form-control input-sm" type="password" id="txt_compass" placeholder="************" required 
                                    pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{10,}$" 
                                    title="Password must be at least 10 characters long, contain at least one uppercase letter, one number, and one special character." />
                                <span class="input-group-text">
                                    <i class="fa fa-eye" id="togglePassword1" style="margin-top: 148%;"></i>
                                </span>
                            </div>

                            <div id="password_error" class="text-danger"></div> <!-- Error message -->
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
        var timeOut = null; // this is used for holding a few seconds to make an ajax request
        var loading_html = '<img src="../../img/ajax-loader.gif" style="height: 20px; width: 20px;"/>';

        // Check username availability
        $('#username').keyup(function(e) {
            switch (e.keyCode) {
                case 9: case 13: case 16: case 17: case 18: case 19: case 20: case 27: case 33: case 34: case 35: case 36: case 37: case 38: case 39: case 40: case 45:
                    return;
            }

            if (timeOut != null) clearTimeout(timeOut);
            timeOut = setTimeout(is_available, 500);
            $('#user_msg').html(loading_html);
        });

        function is_available() {
            var username = $('#username').val();

            $.post("check_username.php", { username: username }, function(result) {
                if (result != 0) {
                    $('#user_msg').html('Not Available');
                    document.getElementById("btn_add").disabled = true;
                } else {
                    $('#user_msg').html('<span style="color:#006600;">Available</span>');
                    document.getElementById("btn_add").disabled = false;
                }
            });
        }

        // Validate passwords on form submission
        $('#btn_add').click(function(e) {
            var password = $('input[name="txt_pass"]').val();
            var confirmPassword = $('input[name="txt_compass"]').val();

            if (password !== confirmPassword) {
                e.preventDefault();
                $('#password_error').text('Passwords do not match. Please try again.');
            } else {
                $('#password_error').text('');
            }
        });

        // Toggle password visibility
        function togglePasswordVisibility(toggleElement, passwordElement) {
            toggleElement.addEventListener('click', function() {
                const isPassword = passwordElement.getAttribute('type') === 'password';
                passwordElement.setAttribute('type', isPassword ? 'text' : 'password');
                
                // Toggle the eye icon classes based on password visibility
                if (isPassword) {
                    this.classList.remove('fa-eye');   // Remove the eye icon class
                    this.classList.add('fa-eye-slash'); // Add the eye-slash icon class
                } else {
                    this.classList.remove('fa-eye-slash'); // Remove the eye-slash icon class
                    this.classList.add('fa-eye');          // Add the eye icon class
                }
            });
        }
        
        // Apply the function to both password fields
        togglePasswordVisibility(document.getElementById('togglePassword'), document.getElementById('txt_pass'));
        togglePasswordVisibility(document.getElementById('togglePassword1'), document.getElementById('txt_compass'));
    });


    // Toggle password visibility function
document.getElementById('togglePassword').addEventListener('click', function() {
    var passwordInput = document.getElementById('txt_pass');
    
    // Check if the password input is of type 'password', then toggle it to 'text'
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        this.classList.remove('fa-eye');
        this.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        this.classList.remove('fa-eye-slash');
        this.classList.add('fa-eye');
    }
});
</script>