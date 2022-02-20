<?php
    include_once('includes/functions.php');
    ?>
<section class="content-header">
    <h1>Order List</h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr/>
</section>
<style>
.uppercase {
  text-transform: uppercase;
}
</style>
<style>
.btnx {
  background-color: DodgerBlue;
  border: none;
  color: white;
  padding: 4px 18px;
  cursor: pointer;margin-bottom:10px;
  font-size: 18px;float:right;
}
.btnx:hover{color: white;}

/* Darker background on mouse-over */
 
</style>

<!-- search form -->
<section class="content">
    <!-- Main row -->
   	<!--<a href="export_order.php" class="btnx"><i class="fa fa-download"></i> Export</a>-->
 <?php /*<a href="export_order.php" class="btn btn-info" style="float:right;" target="_blank"><i class="fa fa-download"></i> Export PDF</a>*/ ?>
 <!--<a href="javascript:void(0);" class="btn btn-info" style="float:right;"  onclick="export_pdf();"><i class="fa fa-download"></i> Export PDF</a>-->
  <button id="exportToPdf" class="btn btn-info" style="float:right;"><i class="fa fa-download"></i></i> Export PDF</a></button>
    <button id="pushToArray" class="btn btn-info" style="float:right;"><i class="fa fa-download"></i>Export CSV</button>
    
 <!--<a href="export_order_csv.php" class="btn btn-info" style="float:right;" target="_blank"><i class="fa fa-download"></i> Export CSV</a>-->
<!--    <form method="post" action="export_order.php" id="form1">-->
<!--                      <select id="filter_order" name="status" placeholder="Select Status" required="" class="form-control" style="width: 300px;">-->
<!--                            <option value="">All Orders</option>-->
<!--                            <option value="received">Received</option>-->
<!--                            <option value="processed">Processed</option>-->
<!--                            <option value="shipped">Shipped</option>-->
<!--                            <option value="delivered">Delivered</option>-->
<!--                            <option value="cancelled">Cancelled</option>-->
<!--                            <option value="returned">Returned</option>-->
<!--                        </select>-->
            <!--<a type="submit" class="btn btn-info" style="float:right;"><i class="fa fa-download"></i> Export</a>-->
                
<!--<button type="submit" class="btn btn-info" style="float:right;" form="form1" value="Submit">export</button>-->

<!--           </form>-->
 
 
    <div>
        <form method="POST" id="separate_filter_form" action="separate_order_filter.php" name="separate_filter_form">
             
            <table>
                <tr>
                    <th>Order ID</th>
                   <!-- <th>Active Status</th>-->
                    <th>Customer</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="order_id" value="">
                    </td>
                   <!-- <td>
                        <select id="active_status" name="active_status" placeholder="Active Status" required="" class="form-control" style="width: 300px;">
                            <option value="">All Orders</option>
                            <option value="received">Received</option>
                            <option value="processed">Processed</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="returned">Returned</option>
                        </select>
                    </td>-->
                    <td>
                        <input type="text" name="customer_name" value="">
                    </td>
                </tr>
                <!--<tr>
                    <input type="submit" name="separate_filter" value="Filter">
                </tr>-->
                
            </table>
        </form>
    </div>
   
    <div class="row">
        <div class="col-md-12">
        
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Latest Orders</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                <form method="POST" id="filter_form" name="filter_form">
                <div class="form-group">
                            <label for="from" class="control-label col-md-3 col-sm-3 col-xs-12">From & To Date</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="date" name="date" autocomplete="off" />
                            </div>
                            <input type="hidden" id="start_date" name="start_date">
                            <input type="hidden" id="end_date" name="end_date">
                </div>
                <div class="form-group">
                    <!--<h3 class="box-title">Filter by status</h4>-->
                      <select id="filter_order" name="filter_order" placeholder="Select Status" required class="form-control" style="width: 300px;">
                            <option value="">All Orders</option>
                            <option value='received'>Received</option>
                            <option value='processed'>Processed</option>
                            <option value='shipped'>Shipped</option>
                            <option value='delivered'>Delivered</option>
                            <option value='cancelled'>Cancelled</option>
                            <option value='returned'>Returned</option>
                        </select>
                        
                    <!-- <input type="submit" name="filter_btn" id="filter_btn" value="Filter" class="btn btn-primary btn-md"> -->
                </div>
                <input type="hidden" id="filter_order_status" name="filter_order_status">
                <div class="form-group">
                    <!-- <input type="submit" name="filter_btn" id="filter_btn" value="Filter" class="btn btn-primary btn-md"> -->
                </div>
                </form>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive">
                        <form id="generatePDFForm" action="select-order.php" target="_blank" method="post">
                        <table class="table no-margin" data-toggle="table"  id="order_list"
                            data-url="api/get-bootstrap-table-data.php?table=orders"
                            data-page-list="[10, 20, 50, 100, 200]"
                            data-show-refresh="true" data-show-columns="true"
                            data-side-pagination="server" data-pagination="true"
                            data-search="true" data-trim-on-search="false"
							data-sort-name="id" data-sort-order="desc"
                            data-query-params="queryParams_1"
                            data-show-footer="true"
                            data-footer-style="footerStyle"
                            data-show-export="true"
						data-export-types='["txt","excel"]'
						data-export-options='{
							"fileName": "order-list-<?=date('d-m-Y')?>",
							"ignoreColumn": ["operate","operate1","checkbox_check",active_status]
						}'
                            >
                            <thead>
                                <tr>
    								<th data-field="operate1" data-sortable='true'  data-footer-formatter="totalFormatter"> Select all</th>
    								<th data-field="checkbox_check" ><input type="checkbox" onclick="checkboxallorders(this)" name="check_all" id="checkAllfield"/>Check All</th>
    								<th data-field="id" data-sortable='true' data-footer-formatter="totalFormatter">Order ID</th>
    								<th data-field="user_id" data-sortable='true' data-visible="false">User ID</th>
    								 <th data-field="qty" data-sortable='true' data-visible="false">Qty</th>
                                    <th data-field="name" data-sortable='true'>User Name</th>
    								<th data-field="mobile" data-sortable='true'>Mobile</th>
    								<th data-field="items" data-sortable='true' data-visible="false">Items</th>
    							 	
    								<th data-field="total" data-sortable='true' data-visible="true">Total(<?=$settings['currency']?>)</th>
    								<th data-field="delivery_charge" data-sortable='true' data-footer-formatter="delivery_chargeFormatter">D.Charge</th>
    								<th data-field="discount" data-sortable='true' data-visible="false">Discount%</th>
    								<th data-field="final_total" data-sortable='true'>Final Total(<?=$settings['currency']?>)</th>
    								 <th data-field="deliver_by" data-sortable='true' data-visible='false'>Deliver By</th>
    								<th data-field="payment_method" data-sortable='true' data-visible="true">Payment Method</th>
    								<th data-field="address" data-sortable='true'>Address</th>
    								<th data-field="delivery_time" data-sortable='true' data-visible='true'>Delivery Time</th>
    								<th data-field="status" data-sortable='true' data-visible='false'>Status</th>
    								<th data-field="active_status" data-sortable='true' data-visible='true'>Active Status</th>
    								<th data-field="action_status" data-sortable='true' data-visible='false'>Status Action</th>
    								
    								<th data-field="date_added" data-sortable='true'>Order Date</th>
    								<th data-field="operate">Action</th>
                                               
												
								</tr>
                            </thead>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
<script>
    $('#filter_order').on('change', function() { 
        status = $('#filter_order').val();
        $('#filter_order_status').val(status);
        
	});
	


</script>








<script>
  $(document).ready(function(){
    	$('#date').daterangepicker({  
				"autoApply": true,
				"showDropdowns": true,
                "alwaysShowCalendars":true,
				"startDate":moment(),
				"endDate":moment(),
				"locale": {
					"format": "DD/MM/YYYY",
					"separator": " - "
				},
			});

            $('#date').on('apply.daterangepicker', function(ev, picker) {
				var drp = $('#date').data('daterangepicker');
				$('#start_date').val(drp.startDate.format('YYYY-MM-DD'));
				$('#end_date').val(drp.endDate.format('YYYY-MM-DD'));
			});
        	$('#date').on('apply.daterangepicker', function(ev, picker) {
				var drp = $('#date').data('daterangepicker');
				$('#start_date').val(drp.startDate.format('YYYY-MM-DD'));
				$('#end_date').val(drp.endDate.format('YYYY-MM-DD'));
                $('#order_list').bootstrapTable('refresh');
			});
			$('#filter_order').on('change',function(){
			 //   alert('change');
			    $('#order_list').bootstrapTable('refresh');
			});
		
		$(document).on('change', 'select.actions', function(){
		   var selectedAction = $(this). children("option:selected"). val(); 
		   var selectedId = $(this). children("option:selected"). attr('id'); 
		   //alert(selectedAction);
		   //alert(selectedId);
		   $.post("update_action.php",
               {
                action: selectedAction,
                id: selectedId
              },
               function(response){
                   //console.log(response);
                   if(response == '1'){
                       if(selectedAction == 'received'){
                           var classs = 'primary';
                       }
                       if(selectedAction == 'processed'){
                           var classs = 'info';
                       }
                       if(selectedAction == 'shipped'){
                           var classs = 'warning';
                       }
                       if(selectedAction == 'delivered'){
                           var classs = 'success';
                       }
                       if(selectedAction == 'returned' || selectedAction == 'cancelled'){
                           var classs = 'danger';
                       }
                       $('span#change_action_'+selectedId).html('<label class="label label-'+classs+'">'+selectedAction+'</label>');
                   }
               }
            );
		});
		
		
  });
  function queryParams_1(p){
			return {
				"start_date": $('#start_date').val(),
				"end_date": $('#end_date').val(),
				"filter_order": $('#filter_order_status').val(),
				limit:p.limit,
				sort:p.sort,
				order:p.order,
				offset:p.offset,
				search:p.search
			};
		}

        function totalFormatter() {
    return '<span style="color:green;font-weight:bold;font-size:large;">TOTAL</span>'
  }
  
  

  function orderFormatter(data) {
    return '<span style="color:green;font-weight:bold;font-size:large;">'+ data.length + ' Order'
  }
  var total =0;
  function priceFormatter(data) {
    // return JSON.stringify(data);
    var field = this.field
    return '<span style="color:green;font-weight:bold;font-size:large;">'+ data.map(function (row) {
     return +row[field]
    })
    .reduce(function (sum, i) {
      return sum + i
    }, 0)+ ' Rs.<span>'
  }
  function delivery_chargeFormatter(data) {
    // return JSON.stringify(data);
    var field = this.field
    return '<span style="color:green;font-weight:bold;font-size:large;">'+ data.map(function (row) {
     return +row[field]
    })
    .reduce(function (sum, i) {
      return sum + i
    }, 0)+' Rs.</span>'
  }
  
  function final_totalFormatter(data) {
    // return JSON.stringify(data);
    var field = this.field
    return '<span style="color:green;font-weight:bold;font-size:large;">'+ data.map(function (row) {
     return +row[field]
    })
    .reduce(function (sum, i) {
      return sum + i
    }, 0)+ ' Rs.<span>'
  }
  function checkboxallorders(cb){
    //   if(cb.checked == true){
    //       jQuery(".checkbox_order"). prop("checked", true);
    //   }else if(cb.checked == false){
    //       jQuery(".checkbox_order"). prop("checked", false);
    //   }
//     var lfckv = document.getElementById("checkAllfield").checked;
//   alert(lfckv);
        // if ($(this).prop('checked')==true){ 
            $('tbody tr td input[type="checkbox"]').each(function(){
                $(this).prop('checked', true);
            });         
        // }else { 
        //     $('tbody tr td input[type="checkbox"]').each(function(){
        //         $(this).prop('checked', false);
        //     });
    
        // }
  }
//   function export_pdf(){
//       //alert('here');
//       var values = $('input:checkbox:checked.checkbox_order').map(function () {
//           return jQuery(this).attr('data');
//         }).get();
//         console.log(values);
//         $.ajax({
//             type: 'post',
//             url: 'export_pdf.php',
//             data: ,
//             contentType: "application/json; charset=utf-8",
//             traditional: true,
//             success: function (data) {
//                 alert('here');
//             }
//         });
//         $.post("export_pdf.php",
//           {data: JSON.stringify(values)},
//           function(response){
//               console.log(response);
//           }
//         );
//   }


  $('#pushToArray').click(function() {
	
//Get all headers that dont contain checkAll checkbox
var headers = $("#order_list thead th").filter(function(){
    return !$(this).find('#checkAllfield').length;
}).map(function(){
    return $(this).text().trim();
}).get();


//Loop thru the checked checkboxes
var arr = $('#order_list .checkBoxClass:checked').map(function(){ 
    var obj = {};
			
    $(this).parent().siblings().each(function(i){
          obj[ headers[i] ] = $(this).text().trim();
    })
			 
    return obj;
}).get();

// console.log(arr);
   
    $.ajax({
		url : "export_order_csv.php",
		method : "POST",
		data : {data : arr},
		success: function (data){
			var downloadLink = document.createElement("a");
              var fileData = ['\ufeff'+data];

              var blobObject = new Blob(fileData,{
                 type: "text/csv;charset=utf-8;"
               });

              var url = URL.createObjectURL(blobObject);
              downloadLink.href = url;
              downloadLink.download = "order.csv";

              /*
               * Actually download CSV
               */
              document.body.appendChild(downloadLink);
              downloadLink.click();
              document.body.removeChild(downloadLink);
		}
	  });
});


  $('#exportToPdf').click(function() {
      $('#generatePDFForm').submit();
      //alert('test');
	
//Get all headers that dont contain checkAll checkbox
// var headers = $("#order_list thead th").filter(function(){
//     return !$(this).find('#checkAllfield').length;
// }).map(function(){
//     return $(this).text().trim();
// }).get();


//Loop thru the checked checkboxes
// var arr = $('#order_list .checkBoxClass:checked').map(function(){ 
//     var obj = {};
			
//     $(this).parent().siblings().each(function(i){
//           obj[ headers[i] ] = $(this).text().trim();
//     })
			 
//     return obj;
// }).get();

// console.log(arr);
   
//     $.ajax({
// 		url : "select-order.php",
// 		method : "POST",
// 		data : {data : arr},
// 		success: function (data){
// 		    //console.log(data);
// 		    //window.open('select-order.php', '_blank');
// 		}
// 	  });
        // $.ajax({
        // 	type: "POST",
        // 	url: "select-order.php",
        // // 	dataType: "json",
        // 	data:{ data: arr },
        // 	success: function(data)
        // 	{
        // 	    console.log(arr);
        // 		if(data != "")
        // 		{   
        			
        // 		}
        // 	}
        // });
});
</script>
<script src="table2csv/table2csv.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
 

<?php 
$db->disconnect();
?>