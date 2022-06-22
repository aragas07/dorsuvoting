<div class="hdn-div" hidden>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <label class="card-title">Open Election</label>
                    </div>
                    <div class="card-body">
                        <form id="open_elect">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Open registration to election</label>
                                        <input type="date" name="application_open" class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Close registration to election</label>
                                        <input type="date" name="application_close" class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Beginning of the election</label>
                                        <input type="date" name="start_vote" class="form-control">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>End of the election</label>
                                        <input type="date" name="end_vote" class="form-control">
                                    </div>
                                    <input type="text" name="sy" value="2022-2023" hidden>
                                </div>
                                <input type="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Open registration</th>
                            <th>Close registration</th>
                            <th>Beginning of vote</th>
                            <th>End of vote</th>
                            <th>SY</th>
                        </tr>
                    </thead>
                    <tbody id="election-table-body">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>