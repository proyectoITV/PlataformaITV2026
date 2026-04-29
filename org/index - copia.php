<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Page Title</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <script src="main.js"></script>
  <link rel="stylesheet" href="org/css/font-awesome.min.css">
  <link rel="stylesheet" href="org/css/jquery.orgchart.css">
  <link rel="stylesheet" href="org/css/style.css">
  <style type="text/css">
    #chart-container { background-color: #eee; }
    .orgchart { background: #fff; }
  </style>

</head>
<body>
  
 <div id="chart-container"></div>

  <script src="org/js/jquery.min.js"></script>
  <!-- the following reference is specific for IE -->
  <script type="text/javascript" src="https://cdn.rawgit.com/stefanpenner/es6-promise/master/dist/es6-promise.auto.min.js"></script>
  <script type="text/javascript" src="org/js/html2canvas.min.js"></script>
  <script type="text/javascript" src="org/js/jspdf.min.js"></script>
  <script type="text/javascript" src="org/js/jquery.orgchart.js"></script>





  <script type="text/javascript">
    $(function() {

    var datascource = {
      'name': 'Lao Lao',
      'title': 'general manager',
      'children': [
        { 'name': 'Bo Miao', 'title': 'department manager' },
        { 'name': 'Su Miao', 'title': 'department manager',
          'children': [
            { 'name': 'Tie Hua', 'title': 'senior engineer' },
            { 'name': 'Hei Hei', 'title': 'senior engineer',
              'children': [
                { 'name': 'Pang Pang', 'title': 'engineer' },
                { 'name': 'Xiang Xiang', 'title': 'UE engineer' }
              ]
            }
          ]
        },
        { 'name': 'Yu Jie', 'title': 'department manager' },
        { 'name': 'Yu Li', 'title': 'department manager' },
        { 'name': 'Hong Miao', 'title': 'department manager' },
        { 'name': 'Yu Wei', 'title': 'department manager' },
        { 'name': 'Chun Miao', 'title': 'department manager' },
        { 'name': 'Yu Tie', 'title': 'department manager' }
      ]
    };

    $('#chart-container').orgchart({
      'data' : datascource,
      'visibleLevel': 2,
      'nodeContent': 'Export',
      'exportButton': true,
      'exportFilename': 'Organigrama-ITAVU',
      'pan': true,
      'zoom': true
    });

  });
  </script>


</body>
</html>
