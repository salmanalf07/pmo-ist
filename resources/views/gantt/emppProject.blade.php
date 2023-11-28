<!DOCTYPE html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>Gantt Cart By Name</title>
    <script src="{{asset('/assets/libs/gantt/dhtmlxgantt.js?v=8.0.6')}}"></script>

    <link rel="stylesheet" href="{{asset('/assets/libs/gantt/dhtmlxgantt.css?v=8.0.6')}}">
    <link rel="stylesheet" href="{{asset('/assets/libs/gantt/common/controls_styles.css?v=8.0.6')}}">
    <style>
        html,
        body {
            height: 100%;
            padding: 0px;
            margin: 0px;
            overflow: hidden;
        }

        /* .gantt_task_content {
            display: none !important;
        } */
    </style>
</head>

<body>
    <div class="gantt_control">
        <input value="Export to PDF" type="button" onclick='gantt.exportToPDF()'>
        <input value="Export to PNG" type="button" onclick='gantt.exportToPNG()'>
        <input value="Export to EXCEL" type="button" id="exportExcel">

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
                    height: 100,
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
                name: "nama",
                label: "Nama",
                tree: true,
                min_width: 200,
                resize: true
            },
            {
                name: "role",
                label: "Role",
                align: "center",
                min_width: 150,
                resize: true
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
                min_width: 100,
                resize: true
            },
            {
                name: "projectName",
                label: "Project Name",
                min_width: 200,
                resize: true
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
        gantt.ext.zoom.setLevel("quarter");
        gantt.ext.zoom.attachEvent("onAfterZoom", function(level, config) {
            document.querySelector(".gantt_radio[value='" + config.name + "']").checked = true;
        })
        gantt.config.scale_height = 50;


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
        // Tambahkan tombol export
        var button = document.getElementById("exportExcel");
        button.addEventListener("click", function() {
            gantt.exportToExcel({
                name: "Gantt Cart By Name.xlsx",
                columns: [{
                        id: "nama",
                        header: "Nama",
                        tree: true,
                        min_width: 200,
                        resize: true
                    },
                    {
                        id: "role",
                        header: "Role",
                        align: "center",
                        min_width: 150
                    },
                    {
                        id: "level",
                        header: "Skill Level",
                        align: "center",
                        min_width: 150
                    },
                    {
                        id: "customer",
                        header: "Customer",
                        min_width: 100
                    },
                    {
                        id: "projectName",
                        header: "Project Name",
                        min_width: 200
                    },
                    {
                        id: "start_date",
                        header: "Start time",
                        align: "center",
                        min_width: 100,
                        type: "date",
                        template: function(task) {
                            var customFormat = gantt.date.date_to_str("%d-%m-%Y"); // Define your custom date format
                            var formattedCustomDate = customFormat(task.start_date);
                            return formattedCustomDate;
                        }
                    },
                    {
                        id: "end_date",
                        header: "End time",
                        align: "center",
                        min_width: 100,
                        type: "date",
                        template: function(task) {
                            var customFormat = gantt.date.date_to_str("%d-%m-%Y"); // Define your custom date format
                            var formattedCustomDate = customFormat(task.end_date);
                            return formattedCustomDate;
                        }
                    },
                ],
                visual: true,
                cellColors: true,
                date_format: "dddd d, mmmm yyyy"
            });
        });
    </script>
</body>