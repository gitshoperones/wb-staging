<button type="button" data-toggle="modal" data-target="#wb-modal-createtask" class="btn wb-btn-sm bg-orange add-ons">
<span style="margin-right: 4px;"><i class="fa fa-plus"></i></span>
    ADD NEW TASK
</button>
@include('modals.add-todo-list')
<div class="wb-todo-box">
    <div class="box-body no-padding">
        <div class="table-responsive">
            <table class="table no-margin">
                <thead class="todo-head">
                    <tr>
                        <th colspan="2"><span class="icon">
                            <img src="/assets/images/icons/dashboard/todo.png" height="25px"></span>
                            <span>TO DO LIST</span>
                        </th>
                        <th style="width: 16.4%;">
                            Task Owner
                        </th>
                        <th style="width: 16.4%;">
                            Due Date
                        </th>
                        <th style="width: 45px;">
                            <div class="dropdown action-button">
                                <button type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-default dropdown-toggle btn-box-tool btn-dropmenu">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <ul aria-labelledby="dropdownMenu1" class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#"><span class="icon"><i class="fa fa-calendar-plus-o"></i></span>Today</a></li>
                                    <li><a href="#"><span class="icon"><i class="fa fa-calendar-plus-o"></i></span>Week</a></li>
                                    <li><a href="#"><span class="icon"><i class="fa fa-calendar-plus-o"></i></span>Month</a></li>
                                </ul>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="5" class="text-center">No active task</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<button type="button" name="button" class="btn wb-btn-sm bg-default">COMPLETED TASKS</button>
<div class="wb-todo-box">
    <div class="box-body no-padding">
        <div class="table-responsive">
            <table class="table no-margin table-todo">
                <tbody>
                    <tr><td colspan="5" class="text-center light-text">No Tasks Completed Yet</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>