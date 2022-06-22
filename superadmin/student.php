<div class="hdn-div">
<div class="row justify-content-between pr-3 pl-3">
    <select name="" class="form-control col-3" id="institute">
        <?php 
            $getIns = $conn->query("SELECT * FROM institute");
            while($row = $getIns->fetch_assoc()){
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
        ?>
    </select>
    <input type="text" name="" placeholder="Search" id="search" class="float-right col-4 form-control">
</div>
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <label class="card-title">Comelec Chairman</label>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="comtable"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <label class="card-title">Student list</label>
                </div>
                <div class="card-body" style="overflow-x: auto">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="studtable"></tbody>
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