<!-- ========================= MODAL ======================= -->
            <div id="addModal" class="modal fade">
            <form method="post">
              <div class="modal-dialog modal-sm" style="width:300px !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Manage Certificate Of Residency</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Resident Name:</label>
                                    <input name="txt_name" class="form-control input-sm" type="text" placeholder="Name" required/>
                                </div>
                                <div class="form-group">
                                    <label>Purpose:</label>
                                    <input name="txt_prps" class="form-control input-sm" type="text" placeholder="Purpose" required/>
                                </div>
                                <div class="form-group">
                                    <label>Purok:</label>
                                    <input name="txt_purok" class="form-control input-sm" type="text" placeholder="Purok" required/>
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