<div class="hdn-div" hidden>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <label class="card-title">Admin list</label>
                        <div class="card-tools">
                            <button type="button" class="btn btn-default" data-toggle="modal"
                                data-target="#modal-default">Add</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>First name</th>
                                    <th>Middle name</th>
                                    <th>Last name</th>
                                    <th>Username</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="admintable">
                            </tbody>
                        </table>
                        <div style="margin-top: 10px">
                            <ul id="paging" class="pagination pagination-sm m-0 float-right">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add admin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form novalidate id="forms" class="needs-validation">
                    <div class="form-group">
                        <label>First name</label>
                        <input type="text" name="insertadmin" required class="inp-ad form-control col-md-12">
                    </div>
                    <div class="form-group">
                        <label>Middle name</label>
                        <input type="text" name="mname" required class="inp-ad form-control col-md-12">
                    </div>
                    <div class="form-group">
                        <label>Last name</label>
                        <input type="text" name="lname" required class="inp-ad form-control col-md-12">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" required class="inp-ad form-control col-md-12">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="pass" required class="inp-ad form-control col-md-12">
                    </div>
                    <button type="submit" class="right btn btn-primary">Insert</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>