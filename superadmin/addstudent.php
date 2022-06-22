<div class="hdn-div" hidden>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <label class="card-title">Insert student</label>
                    </div>
                    <div class="card-body">
                        <form action="../db/import.php" method="post" enctype="multipart/form-data">
                            <div class="col-sm-12" style="border-bottom: 1px solid rgb(177,177,177)">
                                <div style="width: 400px; margin:auto">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-sm-label">Select File</label>
                                        <div class="col-md-9">
                                            <input type="file" name="file" accept=".csv" id="chfile" class="input-large">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 control-label">Import data</label>
                                        <div class="col-md-9">
                                            <button type="submit" name="Import"
                                                class="btn btn-primary button-loading"
                                                data-loading-text="Loading...">Import</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12" style="text-align: center">
                                    <h2>File format for the column header</h2>
                                    <h3>ID, First name, Middle name, Last name, Birth, Email, Contact, Course, Year, GPA</h3>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>