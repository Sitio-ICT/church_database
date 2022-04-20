<?php

include('header.php');
$usertype = "damad";
?>

<!-- fullcalender -->
<!-- <script src="fullcalender/main.js"></script>
    <link rel="stylesheet" href="fullcalender/main.css"> -->
<!-- My calender script and style -->
<!-- Bootstrap Core CSS -->
<link href="fullcalender/css/bootstrap.css" rel="stylesheet">

<!-- FullCalendar -->
<link href='fullcalender/css/fullcalendar.css' rel='stylesheet' />



<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Calendar</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>


    <!-- Content Row -->
    <div class="row">


        <div class="col-lg-12 mb-4">


            <style>
                /* #loading {
                    display: none;
                    position: absolute;
                    top: 10px;
                    right: 10px;
                } */

                #calendar {
                    max-width: 1100px;
                    margin: 0 auto;
                }

                .col-centered {
                    float: none;
                    margin: 0 auto;
                }

                .ac_results {
                    padding: 0px;
                    border: 1px solid #84a10b;
                    background-color: #84a10b;
                    overflow: hidden;
                }

                .ac_results ul {
                    width: 100%;
                    list-style-position: outside;
                    list-style: none;
                    padding: 0;
                    margin: 0;
                }

                .ac_results li {
                    margin: 0px;
                    padding: 2px 5px;
                    cursor: default;
                    display: block;
                    color: #fff;
                    font-family: verdana;
                    /* 
		if width will be 100% horizontal scrollbar will apear 
		when scroll mode will be used
		*/
                    /*width: 100%;*/
                    font-size: 12px;
                    /* 
		it is very important, if line-height not setted or setted 
		in relative units scroll will be broken in firefox
		*/
                    line-height: 16px;
                    overflow: hidden;

                }

                .ac_loading {
                    display: none;
                    position: absolute;
                    top: 10px;
                    right: 10px;
                }

                .ac_odd {
                    background-color: #84a10b;
                    color: #ffffff;
                }

                .ac_over {
                    background-color: #5a6b13;
                    color: #ffffff;
                }

                .input_text {}

                datalist {
                    display: block;
                }
            </style>
            <!-- <div id='loading'>loading...</div> -->

            <div id='calendar'></div>
            <!-- addEvent -->
            <!-- Modal -->
            <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="form-horizontal" autocomplete="off" method="POST" action="functions/system/addEvent.php" name="randform">

                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Add Event</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <div>
                                        <input type="text" name="activity_name" class="form-control" id="title" placeholder="Title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <div>
                                        <select name="color" class="form-control" id="color">
                                            <option value="">Choose</option>
                                            <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                            <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                            <option style="color:#008000;" value="#008000">&#9724; Green</option>
                                            <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                            <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                            <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                            <option style="color:#000;" value="#000">&#9724; Black</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!-- Change to be changeable -->
                                    <label for="start">Start date</label>
                                    <div>
                                        <input type="text" name="start" class="form-control" id="start" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="end">End date</label>
                                    <div>
                                        <input type="date" name="end" class="form-control" id="end">
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- updateEvent -->
            <!-- Modal -->
            <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="form-horizontal" method="POST" action="functions/system/editEventTitle.php">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Edit Event</h4>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="color" class="col-sm-2 control-label">Color</label>
                                    <div class="col-sm-10">
                                        <select name="color" class="form-control" id="color">
                                            <option value="">Choose</option>
                                            <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                            <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                            <option style="color:#008000;" value="#008000">&#9724; Green</option>
                                            <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                            <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                            <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                            <option style="color:#000;" value="#000">&#9724; Black</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label class="text-danger"><input type="checkbox" name="delete"> Delete event</label>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="id" class="form-control" id="id">


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>


</div>
<!-- /.container-fluid -->
<?php
if ($user_type == "admin") {
?>
    <script>
        $(document).ready(function() {

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                // defaultDate: '2019-07-07',

                editable: true,
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                selectHelper: true,
                select: function(start, end) {

                    $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD'));
                    $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD'));
                    $('#ModalAdd').modal('show');
                },
                eventRender: function(event, element) {
                    element.bind('dblclick', function() {
                        $('#ModalEdit #id').val(event.id);
                        $('#ModalEdit #title').val(event.title);
                        $('#ModalEdit #color').val(event.color);
                        $('#ModalEdit').modal('show');
                    });
                },
                eventDrop: function(event, delta, revertFunc) { // si changement de position

                    edit(event);

                },
                eventResize: function(event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

                    edit(event);

                },

                events: [
                    <?php
                    $events = findEvents();
                    foreach ($events as $event) :

                        $start = explode(" ", $event['start_date']);
                        $end = explode(" ", $event['end_date']);
                        if ($start[1] == '00:00:00') {
                            $start = $start[0];
                        } else {
                            $start = $event['start_date'];
                        }
                        if ($end[1] == '00:00:00') {
                            $end = $end[0];
                        } else {
                            $end = $event['end_date'];
                        }
                    ?> {
                            id: '<?php echo $event['id']; ?>',
                            title: '<?php echo $event['activity_name']; ?>',
                            start: '<?php echo $start; ?>',
                            end: '<?php echo $end; ?>',
                            color: '<?php echo $event['activity_color']; ?>',
                        },
                    <?php endforeach; ?>
                ]
            });

            function edit(event) {
                start = event.start.format('YYYY-MM-DD');
                if (event.end) {
                    end = event.end.format('YYYY-MM-DD');
                } else {
                    end = start;
                }

                id = event.id;

                Event = [];
                Event[0] = id;
                Event[1] = start;
                Event[2] = end;

                $.ajax({
                    url: 'functions/system/editEventDate.php',
                    type: "POST",
                    data: {
                        Event: Event
                    },
                    success: function(rep) {
                        if (rep == 'OK') {
                            alert('Saved');
                        } else {
                            alert('Could not be saved. try again.');
                        }
                    }
                });
            }

        });

        // $(function() {
        //     $("#input").autocomplete({
        //         source: "functions/system/search.php",
        //     });
        // });
    </script>
<?php } else { ?>
    <script>
        $(document).ready(function() {

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                // defaultDate: '2019-07-07',

                editable: false,
                eventLimit: true, // allow "more" link when too many events
                
                events: [
                    <?php
                    $events = findEvents();
                    foreach ($events as $event) :

                        $start = explode(" ", $event['start_date']);
                        $end = explode(" ", $event['end_date']);
                        if ($start[1] == '00:00:00') {
                            $start = $start[0];
                        } else {
                            $start = $event['start_date'];
                        }
                        if ($end[1] == '00:00:00') {
                            $end = $end[0];
                        } else {
                            $end = $event['end_date'];
                        }
                    ?> {
                            id: '<?php echo $event['id']; ?>',
                            title: '<?php echo $event['activity_name']; ?>',
                            start: '<?php echo $start; ?>',
                            end: '<?php echo $end; ?>',
                            color: '<?php echo $event['activity_color']; ?>',
                        },
                    <?php endforeach; ?>
                ]
            });

            

        });
    </script>
<?php } ?>

<?php

include('footer.php');

?>
<!-- jQuery Version 1.11.1 -->
<script src="fullcalender/js/jquery.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="fullcalender/js/bootstrap.min.js"></script>

<!-- FullCalendar -->
<script src='fullcalender/js/moment.min.js'></script>
<script src='fullcalender/js/fullcalendar.min.js'></script>