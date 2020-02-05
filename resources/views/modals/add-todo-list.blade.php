<div id="wb-modal-createtask" class="modal wb-modal-createtask" style="display: none;">
    <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Create Task</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="name">Task Name</label>
                <input type="text" name="task_name" class="form-control"></div>
                <div class="form-group">
                    <label for="owner_name">Task Owner</label>
                    <input type="text" name="owner_name" class="form-control">
                </div>
                <div data-provide="datepicker" class="form-group input-group date" style="width: 100%;">
                    <label for="date">Date</label>
                    <input id="date" type="text" name="date" class="form-control">
                    <div class="input-group-addon" style="display: none;">
                        <span class="fa fa-calendar"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" rows="2" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default pull-left">Close</button>
                <button type="button" class="btn btn-primary">Add Task</button>
            </div>
        </div>
    </div>
</div>