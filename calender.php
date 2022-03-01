<?php

include('header.php');
$usertype = "damad";
?>

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

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var calendarEl = document.getElementById('calendar');

                    var calendar = new FullCalendar.Calendar(calendarEl, {

                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,listYear'
                        },

                        displayEventTime: false, // don't show the time column in list view

                        // THIS KEY WON'T WORK IN PRODUCTION!!!
                        // To make your own Google API key, follow the directions here:
                        // http://fullcalendar.io/docs/google_calendar/
                        googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',

                        // US Holidays
                        events: 'en.usa#holiday@group.v.calendar.google.com',

                        eventClick: function(arg) {
                            // opens events in a popup window
                            window.open(arg.event.url, 'google-calendar-event', 'width=700,height=600');

                            arg.jsEvent.preventDefault() // don't navigate in main tab
                        },

                        loading: function(bool) {
                            document.getElementById('loading').style.display =
                                bool ? 'block' : 'none';
                        }

                    });

                    calendar.render();
                });
            </script>
            <style>
                
                #loading {
                    display: none;
                    position: absolute;
                    top: 10px;
                    right: 10px;
                }

                #calendar {
                    max-width: 1100px;
                    margin: 0 auto;
                }
            </style>
            <div id='loading'>loading...</div>

            <div id='calendar'></div>


        </div>
    </div>


</div>
<!-- /.container-fluid -->


<?php

include('footer.php');

?>