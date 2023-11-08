@extends('/project/navbarInput')

@section('inputan')
<!-- row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-md-flex border-bottom-0">
            </div>
            <div class="card-body">
                <div class="gantt_control">
                    <input value="Export to PDF" type="button" onclick='gantt.exportToPDF()'>
                    <input value="Export to PNG" type="button" onclick='gantt.exportToPNG()'>
                    <!-- <input value="Export to MS Project" type="button" onclick='gantt.exportToMSProject({skip_circular_links: false})' style='margin:0 15px;'> -->
                </div>
                <form class="gantt_control">
                    <input type="button" value="Zoom In" onclick="zoomIn()">
                    <input type="button" value="Zoom Out" onclick="zoomOut()">

                    <input type="radio" id="scale1" class="gantt_radio" name="scale" value="day">
                    <label for="scale1">Day scale</label>

                    <input type="radio" id="scale2" class="gantt_radio" name="scale" value="week">
                    <label for="scale2">Week scale</label>

                    <input type="radio" id="scale3" class="gantt_radio" name="scale" value="month">
                    <label for="scale3">Month scale</label>

                    <input type="radio" id="scale4" class="gantt_radio" name="scale" value="quarter">
                    <label for="scale4">Quarter scale</label>

                    <input type="radio" id="scale5" class="gantt_radio" name="scale" value="year" checked>
                    <label for="scale5">Year scale</label>

                </form>
                <div id="gantt_here" style='width:100%; height:calc(100vh - 52px);'></div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    var ganttData = <?php echo json_encode($gantt); ?>;
    var zoomConfig = {
        levels: [{
                name: "day",
                scale_height: 27,
                min_column_width: 80,
                scales: [{
                    unit: "day",
                    step: 1,
                    format: "%d %M"
                }]
            },
            {
                name: "week",
                scale_height: 50,
                min_column_width: 50,
                scales: [{
                        unit: "week",
                        step: 1,
                        format: function(date) {
                            var dateToStr = gantt.date.date_to_str("%d %M");
                            var endDate = gantt.date.add(date, -6, "day");
                            var weekNum = gantt.date.date_to_str("%W")(date);
                            return "#" + weekNum + ", " + dateToStr(date) + " - " + dateToStr(endDate);
                        }
                    },
                    {
                        unit: "day",
                        step: 1,
                        format: "%j %D"
                    }
                ]
            },
            {
                name: "month",
                scale_height: 50,
                min_column_width: 120,
                scales: [{
                        unit: "month",
                        format: "%F, %Y"
                    },
                    {
                        unit: "week",
                        format: "Week #%W"
                    }
                ]
            },
            {
                name: "quarter",
                height: 50,
                min_column_width: 90,
                scales: [{
                        unit: "month",
                        step: 1,
                        format: "%M"
                    },
                    {
                        unit: "quarter",
                        step: 1,
                        format: function(date) {
                            var dateToStr = gantt.date.date_to_str("%M");
                            var endDate = gantt.date.add(gantt.date.add(date, 3, "month"), -1, "day");
                            return dateToStr(date) + " - " + dateToStr(endDate);
                        }
                    },
                    {
                        unit: "year",
                        step: 1,
                        format: "%Y"
                    }
                ]
            },
            {
                name: "year",
                scale_height: 50,
                min_column_width: 30,
                scales: [{
                    unit: "year",
                    step: 1,
                    format: "%Y"
                }]
            }
        ]
    };
    gantt.config.columns = [{
            name: "name",
            label: "Nama",
            tree: true,
            resize: true,
            min_width: 200
        },
        {
            name: "role",
            label: "Role",
            align: "center",
            resize: true,
            min_width: 150
        },
        {
            name: "level",
            label: "Skill Level",
            align: "center",
            resize: true,
            min_width: 150
        },
        {
            name: "customer",
            label: "Customer",
            align: "center",
            resize: true,
            min_width: 150
        },
        {
            name: "direct_manager",
            label: "Manager",
            resize: true,
            min_width: 200
        },
        {
            name: "start_date",
            label: "Start time",
            align: "center",
            min_width: 100,
            resize: true,
            template: function(task) {
                var customFormat = gantt.date.date_to_str("%d-%m-%Y"); // Define your custom date format
                var formattedCustomDate = customFormat(task.start_date);
                return formattedCustomDate;
            }
        },
        {
            name: "end_date",
            label: "End time",
            align: "center",
            min_width: 100,
            resize: true,
            template: function(task) {
                var customFormat = gantt.date.date_to_str("%d-%m-%Y"); // Define your custom date format
                var formattedCustomDate = customFormat(task.end_date);
                return formattedCustomDate;
            }
        },
    ];
    gantt.ext.zoom.init(zoomConfig);
    gantt.ext.zoom.setLevel("year");
    gantt.ext.zoom.attachEvent("onAfterZoom", function(level, config) {
        document.querySelector(".gantt_radio[value='" + config.name + "']").checked = true;
    })


    function zoomIn() {
        gantt.ext.zoom.zoomIn();
    }

    function zoomOut() {
        gantt.ext.zoom.zoomOut()
    }

    var radios = document.getElementsByName("scale");
    for (var i = 0; i < radios.length; i++) {
        radios[i].onclick = function(event) {
            gantt.ext.zoom.setLevel(event.target.value);
        };
    }
    //export
    gantt.plugins({
        export_api: true,
    });
    gantt.config.grid_width = 400;
    //end export

    gantt.config.readonly = true;
    gantt.init("gantt_here");
    gantt.parse({
        data: ganttData,
        links: []
    });
</script>



@endsection