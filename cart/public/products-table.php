<section class="content-header">
    <h1>
        Products /
        <small><a href="home.php"><i class="fa fa-home"></i> Home</a></small>
    </h1>
    <ol class="breadcrumb">
        <a class="btn btn-block btn-default" href="add-product.php"><i class="fa fa-plus-square"></i> Add New Product</a>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Filter by Products Category</h4>
                    <form method="post">
                        <select id="category_id" name="category_id" placeholder="Select Category" required class="form-control" style="width: 300px;">
                            <?php
                                $Query="select name, id from category";
                                $db->sql($Query);
                                $result=$db->getResult();
                                if($result)
                                {
                                ?>
                            <option value="">All Products</option>
                            <?php foreach($result as $row){?>
                            <option value='<?=$row['id']?>'><?=$row['name']?></option>
                            <?php }} 
                            ?>
                        </select>
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id='products_table' class="table table-hover" data-toggle="table" 
						data-url="api/get-bootstrap-table-data.php?table=products123"
						data-page-list="[5, 10, 20, 50, 100, 200]"
						data-show-refresh="true" data-show-columns="true"
						data-side-pagination="server" data-pagination="true"
						data-search="true" data-trim-on-search="false"
						data-filter-control="true" data-query-params="queryParams"
						data-sort-name="id" data-sort-order="desc"
						data-show-export="true"
						data-export-types='["txt","excel"]'
						data-export-options='{
							"fileName": "products-list-<?=date('d-m-Y')?>",
							"ignoreColumn": ["operate"]	
						}'>
                        <thead>
                        <tr>
                            <th data-field="id" data-sortable="true">ID</th>
                            <th data-field="name" data-sortable="true">Name</th>
                            <th data-field="image">Image</th>
                            <th data-field="price" data-sortable="true">MRP</th> 
                            <th data-field="measurement" data-sortable="true">Measurement (Kg, gm, Ltr)</th> 
                            <th data-field="stock" data-sortable="true" >Stock</th>
                            <th data-field="serve_for" data-sortable="true">Availability</th>
                            <!-- <th data-field="discounted_price" data-sortable="true" >Discounted Price</th> -->
                            <!--<th data-field="category_id" data-sortable="true">Category ID</th>-->
                            <th data-field="operate">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="separator"> </div>
    </div>
    <!-- /.row (main row) -->
</section>

<script>
function queryParams(p){
	return {
		"category_id": $('#category_id').val(),
		limit:p.limit,
		sort:p.sort,
		order:p.order,
		offset:p.offset,
		search:p.search
	};
}
</script>
<script>
$('#category_id').on('change',function(){
	id = $('#category_id').val();
	$('#products_table').bootstrapTable('refresh');
});


 
</script>