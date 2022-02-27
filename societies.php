<?php

include('header.php');

$randms = generateRandomString(5);

if ($findPermissions['configurations'] != 1) {
    $_SESSION["feedback"] = "You do not have permission to manage Societies!";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    // using js so as to aviod header error
?>
    <script>
        location.replace("index.php?message1=<?php echo $randms ?>");
    </script>
<?php
    exit();
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">PRODUCT MANAGEMENT</h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left;">
                        <h6 class="m-0 font-weight-bold text-primary">Create New Product</h6>
                    </div>
                    <div style="float:right">
                        <a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#bookLoan">
                            <span class="icon text-white-50">
                                <i class="fas fa-info-circle"></i>
                            </span>
                            <span class="text">New Tool</span>
                        </a>
                        <!-- Modal -->
                        <form action="functions/business/create_product.php" method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="modal fade" id="bookLoan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Create New Tool</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Product Type</label>
                                                <select name="type" id="type" class="form-control">
                                                    <option value="rdp">RDP</option>
                                                    <option value="account">Account</option>
                                                    <option value="card">Card</option>
                                                </select>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#type').on('click', function() {
                                                        var type = $(this).val();
                                                        $.ajax({
                                                            url: "functions/system/ajax_functions/product_type.php",
                                                            method: "POST",
                                                            data: {
                                                                type: type
                                                            },
                                                            success: function(data) {
                                                                $('#display').html(data);
                                                            }
                                                        })
                                                    });
                                                });
                                            </script>
                                            <div id="display"></div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Create</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /modal ends here -->
                    </div>
                </div>
                <style>
                    .scrolling {
                        max-height: 340px;
                        overflow-y: scroll;
                    }
                </style>
                <div class="card-body scrolling">
                    <?php
                    $findActivity = selectAllWithOrder('product_activity', [''], 'id', 'DESC');
                    // $x = 0;
                    foreach ($findActivity as $activity) {
                        if ($activity['type'] == 1) {
                            $color = "green";
                        } else {
                            $color = "red";
                        }
                    ?>
                        <p style="color:<?php echo $color ?>">
                            <?php echo $activity['description'] ?>
                        </p>
                    <?php
                        // if (++$x == 10) {
                        //     break;
                        // }
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- lists of users -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Products</h6>
                </div>
                <div class="card-body">
                    <form action="functions/business/delete_product_multiple.php" method="post">
                        <div class="form-group">
                            <label for="">Account</label>
                            <select name="account" class="form-control">
                                <?php
                                $findAccounts = selectAllDistinct('product_name', 'products', ['product_type' => 'account', 'status' => 0]);
                                foreach ($findAccounts as $accounts) {
                                ?>
                                    <option value="<?php echo $accounts['product_name'] ?>"><?php echo $accounts['product_name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Product Type</th>
                                    <th>Country</th>
                                    <th>Price</th>
                                    <th>Value</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Product Type</th>
                                    <th>Country</th>
                                    <th>Price</th>
                                    <th>Value</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>

                            </tfoot>
                            <!-- <tbody>
                                <?php
                                // $findProduct = selectAllWithOrder('products', ['status' => 0], 'id', 'DESC');
                                // foreach ($findProduct as $product) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php
                                            // if ($product['product_type'] == "account") {
                                            //     echo $product['product_name'];
                                            // } else {
                                            //     echo $product['product_type'];
                                            // }
                                            ?>
                                        </td>
                                        <td><?php //echo $product['country'] ?></td>
                                        <td><?php //echo $product['price']; ?></td>
                                        <td>
                                            <?php 
                                            // $values = json_decode($product['meta']);
                                            // foreach($values as $key => $value){
                                            //     echo "$key = <b>$value</b> <br>";
                                            // }
                                            ?>
                                        </td>
                                        <td><?php //echo $product['description'] ?></td>
                                        <td>
                                            <a href="functions/business/delete_product.php?delete=<?php //echo $product['id'] ?>" class="btn btn-danger">Delete</a>
                                        </td>

                                    </tr>
                                <?php
                                // }
                                ?>
                            </tbody> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->
<script>
    //
    // Pipelining function for DataTables. To be used to the `ajax` option of DataTables
    //
    $(document).ready(function() {
        $.fn.dataTable.pipeline = function(opts) {
            // Configuration options
            var conf = $.extend({
                pages: 5, // number of pages to cache
                url: 'fetch_data.php', // script url
                data: null, // function or object with parameters to send to the server
                // matching how `ajax.data` works in DataTables
                method: 'GET' // Ajax HTTP method
            }, opts);

            // Private variables for storing the cache
            var cacheLower = -1;
            var cacheUpper = null;
            var cacheLastRequest = null;
            var cacheLastJson = null;

            return function(request, drawCallback, settings) {
                var ajax = false;
                var requestStart = request.start;
                var drawStart = request.start;
                var requestLength = request.length;
                var requestEnd = requestStart + requestLength;

                if (settings.clearCache) {
                    // API requested that the cache be cleared
                    ajax = true;
                    settings.clearCache = false;
                } else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
                    // outside cached data - need to make a request
                    ajax = true;
                } else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
                    JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
                    JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
                ) {
                    // properties changed (ordering, columns, searching)
                    ajax = true;
                }

                // Store the request for checking next time around
                cacheLastRequest = $.extend(true, {}, request);

                if (ajax) {
                    // Need data from the server
                    if (requestStart < cacheLower) {
                        requestStart = requestStart - (requestLength * (conf.pages - 1));

                        if (requestStart < 0) {
                            requestStart = 0;
                        }
                    }

                    cacheLower = requestStart;
                    cacheUpper = requestStart + (requestLength * conf.pages);

                    request.start = requestStart;
                    request.length = requestLength * conf.pages;

                    // Provide the same `data` options as DataTables.
                    if (typeof conf.data === 'function') {
                        // As a function it is executed with the data object as an arg
                        // for manipulation. If an object is returned, it is used as the
                        // data object to submit
                        var d = conf.data(request);
                        if (d) {
                            $.extend(request, d);
                        }
                    } else if ($.isPlainObject(conf.data)) {
                        // As an object, the data given extends the default
                        $.extend(request, conf.data);
                    }

                    return $.ajax({
                        "type": conf.method,
                        "url": conf.url,
                        "data": request,
                        "dataType": "json",
                        "cache": false,
                        "success": function(json) {
                            cacheLastJson = $.extend(true, {}, json);

                            if (cacheLower != drawStart) {
                                json.data.splice(0, drawStart - cacheLower);
                            }
                            if (requestLength >= -1) {
                                json.data.splice(requestLength, json.data.length);
                            }

                            drawCallback(json);
                        }
                    });
                } else {
                    json = $.extend(true, {}, cacheLastJson);
                    json.draw = request.draw; // Update the echo for each response
                    json.data.splice(0, requestStart - cacheLower);
                    json.data.splice(requestLength, json.data.length);

                    drawCallback(json);
                }
            }
        };

        // Register an API method that will empty the pipelined data, forcing an Ajax
        // fetch on the next draw (i.e. `table.clearPipeline().draw()`)
        $.fn.dataTable.Api.register('clearPipeline()', function() {
            return this.iterator('table', function(settings) {
                settings.clearCache = true;
            });
        });
    });

    //
    // DataTables initialisation
    //
    // $(document).ready(function() {
    //     $('#example').DataTable( {
    //         "processing": true,
    //         "serverSide": true,
    //         "ajax": $.fn.dataTable.pipeline( {
    //             url: 'scripts/server_processing.php',
    //             pages: 5 // number of pages to cache
    //         } )
    //     } );
    // } );
    $(document).ready(function() {

        // DataTable
        var table = $('#dataTables').DataTable({
            // "scrollX": true,
            // "pagingType": "numbers",
            "processing": true,
            "serverSide": true,
            "ajax": $.fn.dataTable.pipeline({
                url: "fetch_data.php",
                pages: 5 // number of pages to cache
            }),
            // "ajax": "fetch_data.php?view=<?php //echo $view ?>",
            'columns': [{
                    data: 'Product'
                },
                {
                    data: 'Country'
                },
                {
                    data: 'Price'
                },
                {
                    data: 'Description'
                },
                {
                    data: 'Value'
                },
                {
                    data: 'action'
                }
            ],
            orderCellsTop: true,
            "order": [],
            "lengthMenu": [
                [50, 100, 250, 500, -1],
                [50, 100, 250, 500, "All"]
            ],
            "iDisplayLength": 100,
            // initComplete: function() {
            //     // $('#dataTables thead tr:eq(1) th.text-search').each(function() {
            //     //     var title = $(this).text();
            //     //     $(this).html('<input type="text" placeholder="Search ' + title + '" class="column_search" />');
            //     // });



            //     // Setup - add a text input to each header cell
            //     $('#dataTables thead tr:eq(1) th.text-search').each(function() {
            //         var title = $(this).text();
            //         $(this).html('<input type="text" placeholder="Search ' + title + '" class="column_search" />');
            //     });



            //     this.api().columns().every(function() {
            //         var column = this;
            //         if ($('#dataTables thead tr:eq(1) th:eq(' + column.index() + ')').hasClass('select-search')) {
            //             var select = $('<select><option value=""></option></select>')
            //                 .appendTo($('#dataTables thead tr:eq(1) th:eq(' + column.index() + ')').empty())
            //                 .on('change', function() {
            //                     var val = $.fn.dataTable.util.escapeRegex(
            //                         $(this).val()
            //                     );

            //                     column.search(val ? '' + val + '' : '', true, false).draw();
            //                 });

            //             column.data().unique().sort().each(function(d, j) {
            //                 select.append('<option value="' + d + '">' + d + '</option>');
            //             });
            //         }
            //     });
            // }
        });

        // Apply the search
        // $('#dataTables thead').on('keyup', ".column_search", function() {

        //     table.column($(this).parent().index()).search(this.value).draw();
        //     // table.search(this.value).draw();
        // });
        // table.columns().every(function() {
        //             var table = this;
        //             $('input', this.header()).on('keyup change', function() {
        //                 if (table.search() !== this.value) {
        //                     table.search(this.value).draw();
        //                 }
        //             });
        //         });


    });
</script>

<?php

include('footer.php');

?>