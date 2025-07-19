<div class="modal fade" id="modal-editdepartment">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Department</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="EditManuscripttypeForm" >
            <div id="mgs" class="mx-3"></div>
         @csrf
        <div class="modal-body">

           <div class="form-group">
             <label for="status" class="control-label text-navy"><b> Name:</b></label>
                <input type="text" class="form-control" id="edit_name">
            </div>

            <div class="form-group">
                <label for="status" class="control-label text-navy"><b>Description:</b></label>
                  <textarea type="text" rows="5" class="form-control" id="edit_description" ></textarea>
               </div>



          </div>
        <div class="modal-footer justify-content-between">
            <input type="hidden" id="edit_id">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-updatedepartment">Update</button>
        </div>
       </form>
      </div>
    </div>
  </div>