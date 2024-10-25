<!-- ========================= MODAL ======================= -->
            <div id="addOfficialModal" class="modal fade">
            <form method="post" enctype="multipart/form-data">
              <div class="modal-dialog modal-sm" style="width:300px !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Manage Officials</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Positions:</label>
                                    <select name="ddl_pos" class="form-control input-sm">
                                        <option selected="" disabled="">-- Select Positions -- </option>
                                        <option value="Captain">Barangay Captain</option>
                                        <option value="Kagawad">Barangay Kagawad</option>
                                        <option value="SK Chairman/Chairperson">SK Chairman/Chairperson</option>
                                        <option value="Secretary">Barangay Secretary</option>
                                        <option value="Treasurer">Barangay Treasurer</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Name: <span style="color:gray; font-size: 10px;">(Firstname Middlename, Lastname)</span></label>
                                    <input name="txt_cname" class="form-control input-sm" type="text" placeholder="Firstname Middlename, Lastname" required/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Image:</label>
                                    <input type="file" name="image" class="form-control input-sm" required>
                                </div>
                                <div class="form-group">
                                    <label>Contact #:</label>
                                    <input name="txt_contact" id="txt_contact" class="form-control input-sm" type="text" placeholder="Contact #" maxlength="11" pattern="^\d{11}$" required />
                                </div>
                                <!-- Barangay -->
                                <?php
                                // Assuming the barangay of the logged-in user is stored in the session
                                $off_barangay = $_SESSION['barangay']; // Change 'barangay' to whatever key you use
                                
                                // Available barangay options
                                $barangays = [
                                    "Tabagak", "Bunakan", "Kodia", "Talangnan", "Poblacion", "Maalat", 
                                    "Pili", "Kaongkod", "Mancilang", "Kangwayan", "Tugas", "Malbago", 
                                    "Tarong", "San Agustin"
                                ];
                                ?>
                                <div class="form-group">
                                    <label>Address:</label>
                                    <select name="txt_address" class="form-control input-sm" required>
                                        <option value="" disabled selected>Select Address</option>
                                        <?php foreach($barangays as $barangay): ?>
                                            <option value="<?= $barangay ?>"  
                                                style="<?= ($barangay == $off_barangay) ? 'color: #000000;' : 'color: gray;' ?>" 
                                                <?= ($barangay == $off_barangay) ? '' : 'disabled' ?>
                                                >
                                                <?= $barangay ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Start Term:</label>
                                    <input id="txt_sterm" name="txt_sterm" class="form-control input-sm" type="date" placeholder="Start Term" required/>
                                </div>
                                <div class="form-group">
                                    <label>End Term:</label>
                                    <input name="txt_eterm" class="form-control input-sm" type="date" placeholder="End Term" required/>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel"/>
                        <input type="submit" class="btn btn-primary btn-sm" name="btn_add" value="Add Officials"/>
                    </div>
                </div>
              </div>
              </form>
            </div>


<script type="text/javascript">
    $(document).ready(function(){
        $('input[name="txt_sterm"]').change(function(){
            var startterm = document.getElementById("txt_sterm").value;
            console.log(startterm);
             document.getElementsByName("txt_eterm")[0].setAttribute('min', startterm);
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const contactInput = document.getElementById('txt_contact');

        contactInput.addEventListener('input', function () {
            // Allow only numbers
            this.value = this.value.replace(/[^0-9]/g, '');

            // Check for exactly 11 digits
            if (this.value.length !== 11) {
                this.setCustomValidity('Please enter exactly 11 digits.');
            } else {
                this.setCustomValidity('');
            }
        });
    });
</script>