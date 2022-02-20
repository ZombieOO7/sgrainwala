<?php
    include_once ('../includes/custom-functions.php');
    include_once ('../includes/functions.php');
    $function = new custom_functions;
    ?>
<?php
    // start session
    session_start();
    ob_start();
    // set time for session timeout
    $currentTime = time() + 25200;
    $expired = 3600;
    // if session not set go to login page
    if(!isset($_SESSION['id']) && !isset($_SESSION['name'])){
        header("location:index.php");
    }else{
        $id = $_SESSION['id'];
    }
    // if current time is more than session timeout back to login page
    if ($currentTime > $_SESSION['timeout']) {
        session_destroy();
        header("location:index.php");
    }
    // destroy previous session timeout and create new one
    unset($_SESSION['timeout']);
    $_SESSION['timeout'] = $currentTime + $expired;
    
    include "header.php";?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	    <title>Delivery Boy Dashboard - <?=$settings['app_name']?></title>
	</head>
    <body>
       
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Home</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="home.php"> <i class="fa fa-home"></i> Home</a>
                    </li>
                </ol>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3><?=$function->rows_count('orders','id','delivery_boy_id='.$id);?></h3>
                                <p>Orders</p>
                            </div>
                            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                            <a href="orders.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3><?=$function->get_balance($id);?></h3>
                                <p>Wallet Balance</p></p>
                            </div>
                            <div class="icon"><i class="fa fa-cubes"></i></div>
                            <a href="fund-transfers.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3><?=$function->get_bonus($id);?></h3>
                                <p>Bonus%</p></p>
                            </div>
                            <div class="icon"><i class="fa fa-cubes"></i></div>
                            <a href="fund-transfers.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6" style="display: none;">
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3><?=$function->rows_count('users');?></h3>
                                <p>Registered Customers</p>
                            </div>
                            <div class="icon"><i class="fa fa-users"></i></div>
                            <a href="customers.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="box box-success" style="display: none;">
                             <?php $year = date("Y");
                                $curdate = date('Y-m-d');
                              $sql = "SELECT SUM(final_total) AS total_sale,DATE(date_added) AS order_date FROM orders WHERE YEAR(date_added) = '$year' AND DATE(date_added)<'$curdate' GROUP BY DATE(date_added) ORDER BY DATE(date_added) DESC  LIMIT 0,7";
                                $db->sql($sql);
                                $result_order = $db->getResult(); ?>
                                <div class="tile-stats" style="padding:10px;">
                                    <div id="columnchart_material" style="width:100%;height:350px;"></div>
                                </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="box box-danger" style="display: none;">
                            <?php
                             $sql="SELECT `name`,(SELECT count(id) from `products` p WHERE p.category_id = c.id ) as `product_count` FROM `category` c";
                                $db->sql($sql);
                                $result_products = $db->getResult(); ?>
                                <div class="tile-stats" style="padding:10px;">
                                    <div id="piechart" style="width:100%;height:350px;"></div>
                                </div>
                        </div>
                        
                    </div>
                    
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
    
                <div class="form-group pull-right">
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
                </form>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="table no-margin table-striped" id='orders_table' data-toggle="table" 
										data-url="get-bootstrap-table-data.php?table=orders"
										data-page-list="[5, 10, 20, 50, 100, 200]"
										data-show-refresh="true" data-show-columns="true"
										data-side-pagination="server" data-pagination="true"
										data-search="true" data-trim-on-search="false"
										data-sort-name="id" data-sort-order="desc"
										data-mobile-responsive="true"
										data-toolbar="#toolbar" data-query-params="queryParams"
										>
										<thead>
											<tr>
												<th data-field="id" data-sortable='true'>Order ID</th>
												<th data-field="user_id" data-sortable='true'>User ID</th>
                                                <th data-field="name" data-sortable='true'>User Name</th>
												<th data-field="mobile" data-sortable='true' data-visible="false">Mobile</th>
												<th data-field="items" data-sortable='false' data-visible="false">Items</th>
                                                <th data-field="qty" data-sortable='false' data-visible="false">Qty</th>
												<th data-field="total" data-sortable='false'>Total Price(<?=$settings['currency']?>)</th>
												<th data-field="delivery_charge" data-sortable='true'>Delivery Charge</th>
												<th data-field="discount" data-sortable='false' data-visible="true">Discount%</th>
												<th data-field="final_total" data-sortable='true'>Final Total(<?=$settings['currency']?>)</th>
												<th data-field="payment_method" data-sortable='true' data-visible="false">Payment Method</th>
												<th data-field="address" data-sortable='true'>Address</th>
												<th data-field="delivery_time" data-sortable='true' data-visible='false'>Delivery Time</th>
												<th data-field="status" data-sortable='true'>Status</th>
												<th data-field="active_status" data-visible="false" data-sortable='true'>Active Status</th>
												<th data-field="date_added" data-sortable='true'>Order Date</th>
												<th data-field="operate">Action</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
							<div class="box-footer clearfix">
								<a href="orders.php" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
							</div>
						</div>
					</div>
				</div>
			</section>
        </div>
<script>
	$('#filter_order').on('change',function(){
    $('#orders_table').bootstrapTable('refresh');
    });
</script>
<script>
function queryParams(p){
	return {
		"filter_order": $('#filter_order').val(),
		limit:p.limit,
		sort:p.sort,
		order:p.order,
		offset:p.offset,
		search:p.search
	};
}
</script>
<?php include "footer.php";?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
              google.charts.load('current', {'packages':['bar']});
              google.charts.setOnLoadCallback(drawChart);
              function drawChart() {
                var data = google.visualization.arrayToDataTable([
                  ['Date', 'Total Sale In <?=$settings['currency']?>'],
                  <?php foreach($result_order as $row){
                   $date = date('d-M', strtotime($row['order_date']));
                   echo "['".$date."',".$row['total_sale']."],"; 
                    } ?>
                ]);
                var options = {
                  chart: {
                    title: 'Weekly Sale',
                    subtitle: 'Total Sale In Last Week (Month: <?php echo date("M"); ?>)',
                  }
                };
                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
                chart.draw(data,google.charts.Bar.convertOptions(options));
              }

           
            </script>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawPieChart);

      function drawPieChart() {

        var data = google.visualization.arrayToDataTable([
            ['Product', 'Count'],
            <?php
                foreach($result_products as $row){ echo "['".$row['name']."',".$row['product_count']."],";}
            ?>
        ]);

        var options = {
          title: 'Category Wise Product\'s Count',
          is3D: true
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </body>
</html>