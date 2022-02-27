<?php

include('header.php');

$randms = generateRandomString();

if ($findPermissions['user_management'] != 1) {
    $_SESSION["feedback"] = "You do not have Support permission!";
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
    <h1 class="h3 mb-4 text-gray-800">MEMBERS</h1>

    <div class="row">


        <!-- lists of users -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Active Members</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Fullname</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Fullname</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>

                            </tfoot>

                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Blocked Members</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">

                                <thead>
                                    <tr>
                                        <th>Fullname</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>

                                    <tr>
                                        <th>Fullname</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>

                                </tfoot>
                                <tbody>
                                    <?php
                                    $finduser = findBannedUsers();
                                    foreach ($finduser as $user) {
                                        $profile = findProfile($user['profile_id']);
                                    ?>
                                        <tr>
                                            <td><?php echo $profile['first_name'] . " " . $profile['middle_name'] . " " . $profile['last_name'] ?></td>
                                            <td><?php echo $user['username']; ?></td>
                                            <td><?php echo $profile['email']; ?></td>
                                            <td>
                                                <a href="client_view.php?view=<?php echo $user['id'] ?>" class="btn btn-info btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-info-circle"></i>
                                                    </span>
                                                    <span class="text">View</span>
                                                </a>
                                            </td>

                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
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
            // "ajax": "fetch_data.php?view=<?php //echo $view 
                                            ?>",
            'columns': [{
                    data: 'fullname'
                },
                {
                    data: 'username'
                },
                {
                    data: 'email'
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
            "iDisplayLength": 50,
        });


    });
</script>
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable2').DataTable({
            "order": [],
            "lengthMenu": [
                [50, 100, 250, 500, -1],
                [50, 100, 250, 500, "All"]
            ],
            "iDisplayLength": 50,
        });
    });
</script>
<?php

include('footer.php');

?>