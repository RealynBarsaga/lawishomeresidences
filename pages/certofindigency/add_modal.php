<!-- ========================= MODAL ======================= -->
<div id="addModal" class="modal fade">
<form method="post">
  <div class="modal-dialog modal-sm" style="width:300px !important;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Manage Certificate Of Indigency</h4>
        </div>
        <div class="modal-body">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Resident Name:</label>
                        <input name="txt_name" class="form-control input-sm" type="text" placeholder="Name" required/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Gender:</label>
                        <select name="ddl_gender" class="form-control input-sm" required>
                            <option selected="" disabled="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <!-- Age -->
                    <div class="form-group">
                        <label>Age:</label>
                        <input name="txt_age" id="txt_age" class="form-control input-sm" type="text" placeholder="Age" readonly/>
                    </div>
                    <!-- Birthdate -->
                    <div class="form-group">
                        <label>Birthdate:</label>
                        <input name="txt_bdate" id="txt_bdate" class="form-control input-sm" type="date" placeholder="Birthdate" max="<?php echo date('Y-m-d'); ?>" required/>
                    </div>
                    <div class="form-group">
                        <label>Purpose:</label>
                        <input name="txt_prps" class="form-control input-sm" type="text" placeholder="Purpose" required/>
                    </div>
                    <div class="form-group">
                        <?php
                            $off_barangay = $_SESSION['barangay'];
                    
                            // Purok options for each barangay
                            $puroks = [
                                "Tabagak" => ["Lamon-Lamon", "Tangigue", "Lawihan", "Lower-Bangus", "Upper-Bangus"],
                                "Bunakan" => ["Bilabid", "Helinggero", "Kamaisan", "Kalubian", "Samonite"],
                                /* "Kodia" => ["Purok X", "Purok Y", "Purok Z"], */
                                /* "Talangnan" => ["",], */
                                /*  "Poblacion" => ["",], */
                                "Maalat" => ["Neem Tree", "Talisay", "Kabakhawan", "Mahogany", "Gmelina"],
                                "Pili" => ["Malinawon", "Mahigugmaon", "Matinabangun", "Maabtikon", "Malipayon", "Mauswagon"],
                                /* "Kaongkod" => ["Purok", "Puroks"], */
                                /* "Mancilang" => ["Purok", "Puroks"], */
                                /* "Kangwayan" => ["Purok", "Puroks"], */
                                /* "Kangwayan" => ["Purok", "Puroks"], */
                                /* "Tugas" => ["Purok", "Puroks"], */
                                /* "Malbago" => ["Purok", "Puroks"], */
                                "Tarong" => ["Orchids", "Gumamela", "Santan", "Rose", "Vietnam Rose", "Kumintang", "Sunflower", "Daisy"],
                                // Add purok options for other barangays
                            ];
                        ?>
                        <label>Purok:</label>
                        <select name="txt_purok" class="form-control input-sm" required>
                            <option value="">Select Purok</option>
                            <?php
                                if (array_key_exists($off_barangay, $puroks)) {
                                    foreach ($puroks[$off_barangay] as $purok) {
                                        echo "<option value=\"$purok\">$purok</option>";
                                    }
                                }
                            ?>
                        </select>
                        <div class="form-group">
                           <label class="control-label">Civil Status:</label>
                           <select name="txt_cstatus" class="form-control input-sm" required>
                                <option value="" disabled selected>Select Civil Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                           </select>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <div class="modal-footer">
            <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel"/>
            <input type="submit" class="btn btn-primary btn-sm" name="btn_add" value="Add"/>
        </div>
    </div>
  </div>
  </form>
</div>
<script>
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