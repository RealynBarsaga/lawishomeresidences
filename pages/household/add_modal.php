<!-- ========================= MODAL ======================= -->
<div id="addModal" class="modal fade">
    <form method="post">
        <div class="modal-dialog modal-sm" style="width:300px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Manage Household</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Household #:</label>
                                <input onkeyup="show_head()" id="txt_householdno" name="txt_householdno" class="form-control input-sm" type="number" placeholder="Household #" required/>
                            </div>
                            <div class="form-group">
                                <label>Head Of Family:</label>
                                <select id="txt_hof" name="txt_hof" class="form-control input-sm select2" style="width:100%" onchange="show_total()" required>
                                    <option disabled selected>-- Input Household # First --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Total Number of Members:</label>
                                <input id="txt_totalmembers" disabled name="txt_totalmembers" class="form-control input-sm" type="text" placeholder="Total Number of Members" required/>
                            </div>
                            <div class="form-group">
                                <label>Barangay:</label>
                                <input id="txt_brgy" disabled name="txt_brgy" class="form-control input-sm" type="text" placeholder="Barangay" required/>
                            </div>
                            <div class="form-group">
                                <label>Purok:</label>
                                <input id="txt_purok" disabled name="txt_purok" class="form-control input-sm" type="text" placeholder="Purok" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel" />
                    <input type="submit" class="btn btn-primary btn-sm" name="btn_add" value="Add" />
                </div>
            </div>
        </div>
    </form>
</div>


<script>
    // Assuming barangay information is passed in a hidden field or directly in JavaScript
    var loggedInBarangay = '<?= $_SESSION["barangay"] ?? ""; ?>'; // Pass PHP session variable to JS

    function show_head() {
        var householdID = $('#txt_householdno').val();
        console.log(householdID);
        if (householdID) {
            $.ajax({
                type: 'POST',
                url: 'household_dropdown.php',
                data: { 
                    hhold_id: householdID,
                    barangay: loggedInBarangay // Pass barangay as part of the POST data
                },
                success: function (html) {
                    $('#txt_hof').html(html);
                }
            });
        }
    }

    function show_total() {
        var totalID = $('#txt_hof').val();
        console.log(totalID);
        if (totalID) {
            // Fetch total number of members
            $.ajax({
                type: 'POST',
                url: 'household_dropdown.php',
                data: { 
                    total_id: totalID,
                    barangay: loggedInBarangay // Pass barangay as part of the POST data
                },
                success: function (html) {
                    $('#txt_totalmembers').val(html); // Assuming html contains the total number
                }
            });

            // Fetch Barangay value
            $.ajax({
                type: 'POST',
                url: 'household_dropdown.php',
                data: { 
                    brgy_id: totalID,
                    barangay: loggedInBarangay // Pass barangay as part of the POST data
                },
                success: function (html) {
                    $('#txt_brgy').val(html); // Assuming html contains the Barangay value
                }
            });

            // Fetch Purok value
            $.ajax({
                type: 'POST',
                url: 'household_dropdown.php',
                data: { 
                    purok_id: totalID,
                    barangay: loggedInBarangay // Pass barangay as part of the POST data
                },
                success: function (html) {
                    $('#txt_purok').val(html); // Assuming html contains the Purok value
                }
            });
        }
    }
</script>