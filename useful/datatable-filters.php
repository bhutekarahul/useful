<div class="inner_header d-flex justify-content-between">
                                        <h4>Processed Applicants</h4>
                                        <div class="form-group">
                                            <div class="col-md-2" style="display: none">
                                                <select class="form-control">
                                                    <option selected="" disabled="">Show </option>
                                                    <option>10 </option>
                                                    <option>20</option>
                                                    <option>30</option>
                                                    <option>40</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <div class=" flatpickr" data-wrap="true" data-click-opens="true">
                                                    <div class="input-group icon icon-lg icon-color-primary" id="filter1_col6" data-column="5">
                                                        <input class="form-control column_filter1" placeholder="Applied date" id="col5_filter1">
                                                        <span class="input-group-append" data-toggle>
                                                            <span class="input-group-text"><span class="font-icon font-icon-calend"></span></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <!--<input class="flatpickr form-control flatpickr-input" id="flatpickr" type="text" placeholder="Applied Date.." readonly="readonly">-->
                                            </div>
                                            <div class="col-md-2" id="filter1_col8" data-column="7">
                                                <select class="form-control column_filter1" id="col7_filter1">
                                                    <option selected="" disabled="">Status</option>
                                                    <?php
                                                        foreach($status as $stat){
                                                    ?>
                                                            <option value="<?= $stat['status'] ?>"><?= $stat['status'] ?></option>                                                        <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-3" id="filter1_col5" data-column="4">
                                                <select class="form-control column_filter1" id="col4_filter1">                                                    
                                                    <option selected="" disabled="">Position</option>
                                                    <?php
                                                    for($i=0;$i<count($processed_positions);$i++){
                                                    ?>
                                                        <option value="<?=$processed_positions[$i]?>"><?=$processed_positions[$i]?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3" id="filter1_col7" data-column="6">
                                                <select class="form-control column_filter1" id="col6_filter1">
                                                    <option selected="" disabled="">Select Centre </option>
                                                    <?php
                                                    for($i=0;$i<count($processed_centers);$i++){
                                                    ?>
                                                        <option value="<?=$processed_centers[$i]?>"><?=$processed_centers[$i]?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
<table id="processed-app" class="display table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Contact</th>
                                                <th>Position Applied</th>
                                                <th>Date Applied</th>
                                                <th>Center</th>
                                                <th>Current Status</th>
                                                <th>Last Status</th>
                                                <th>Change Date</th>
                                                <th>Actions</th>
                                                <th>Change Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(!empty($processedApplicants)){
                                            foreach($processedApplicants as $processed){
                                        ?>
                                            <tr>
                                                <td></td>
                                                <td><?=$processed['first_name']." ".$processed['last_name']?></td>
                                                <td><?=$processed['email']?></td>
                                                <td><?=$processed['phone_no']?></td>
                                                <td><?=$processed['position_name']?></td>
                                                <td><?=date("d/m/Y",strtotime($processed['created_date']))?></td>
                                                <td><?=$processed['center_name']?></td>
                                                <td><?php
                                                    if(!empty($processed['processed_status'])){
                                                        foreach($status as $stat){
                                                            if($processed['processed_status'] == $stat['id']){
                                                                echo $stat['status'];
                                                            }
                                                        }
                                                    }else{
                                                        echo $processed['status'];
                                                    }
                                                ?></td>
                                                <td><?=$processed['status']?></td>                                                
                                                <td><?=date("d/m/Y",strtotime($processed['modified_date']))?></td>
                                                <td class="form-group">
                                                    <a href="view-applicants.php?id=<?=$processed['id']?>" title="" class="btn btn-inline btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <span data-toggle="modal" data-target="#delete_processed"><a data-toggle="tooltip" data-placement="top" title="" id="<?=$processed['id']?>" class="btn btn-inline btn-danger delete_processed" data-original-title="Delete"> <i class="fa fa-trash"></i></a></span>
                                                </td>
                                                <td><select class="form-control processed_status_change" data-last_status="<?=$processed['processed_status']?>" id="<?=$processed['id']?>">
                                                        <option disabled="" selected="" value="">-select-</option>
                                                        <?php
                                                            foreach($status as $stat){
                                                        ?>
                                                                <option value="<?= $stat['id'] ?>"><?= $stat['status'] ?></option>                                                        <?php
                                                            }
                                                        ?>
                                                    </select></td>
                                            </tr>  
                                        <?php
                                        }}
                                        ?>
                                        </tbody>
                                    </table>
<script>
    //datatable initilization
var processed = $('#processed-app').DataTable({
            "dom": '<"top">rlt<"bottom"i><"pill-right"p><"clear">',     // placing various tools
            "lengthMenu": [10, 20, 30, 40],                             // custom lengthmenus
            "pagingType": "full_numbers",                               // pagination
            "order": [[ 0, 'asc' ]],                                    // order
            "bLengthChange" : true,                                     
            language : {                                                //hide 'enteries' from Show entries
                sLengthMenu: "Show _MENU_"
            },
            "columnDefs": [
                { "width": "10px", "targets": 2 }
            ]
        });

        //index
        processed.on( 'order.dt search.dt', function () {
            processed.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        //input type filter
        $('input.column_filter1').on( 'keyup click change', function () {
            filterColumn1( $(this).parent('div').attr('data-column') );
        });

        //select option filter
        $('select.column_filter1').change(function () {
            filterColumn1($(this).parents('div').attr('data-column'));
        });