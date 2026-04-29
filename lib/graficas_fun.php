<?php


function GraficaBar($Labels, $Datas, $Titulo){

    $len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
    
    echo '<div style="width:80%; text-align:right;"><a href="#'.$IdDiv.'_modal" rel=MyModal:open><img src="icon/max.png" style="" class="btnMaximizar"></a></div>
    <canvas id="'.$IdDiv.'" width="90%"  ></canvas>';
    echo '<canvas id="'.$IdDiv.'_modal" class="modal" style="display:none;" width="90%"  ></canvas>';

    echo "

    <script>
    var ctx = document.getElementById('".$IdDiv."');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });


    var ctx2 = document.getElementById('".$IdDiv."_modal');
    var myChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    
    </script>
    ";
    
}


function GraficaInserColores(){
    require("config.php");
    $sql = "select 
    CONCAT(rgb,',0.9') as BorderColor,
    CONCAT(rgb,',0.5') as BackgroundColor
    from colorines
    order by rgb DESC
    ";
    $BorderColor = "borderColor: [";
    $BackgroundColor = "backgroundColor: [";
        $r= $conexion -> query($sql);
        while($f = $r -> fetch_array()) {               
            $BorderColor.="'rgba(".$f['BorderColor'].")',";
            $BackgroundColor.="'rgba(".$f['BackgroundColor'].")',";
    
        }
        $BorderColor = substr($BorderColor, 0, -1); //quita la ultima coma.
        $BackgroundColor = substr($BackgroundColor, 0, -1); //quita la ultima coma.
        
    $BorderColor.= "],";
    $BackgroundColor.= "],";
    return $BorderColor.$BackgroundColor;
        // backgroundColor: [
        //     'rgba(255, 99, 132, 0.2)',
        //     'rgba(54, 162, 235, 0.2)',
        //     'rgba(255, 206, 86, 0.2)',
        //     'rgba(75, 192, 192, 0.2)',
        //     'rgba(153, 102, 255, 0.2)',
        //     'rgba(255, 159, 64, 0.2)'
        // ],
        // borderColor: [
        //     'rgba(255, 99, 132, 1)',
        //     'rgba(54, 162, 235, 1)',
        //     'rgba(255, 206, 86, 1)',
        //     'rgba(75, 192, 192, 1)',
        //     'rgba(153, 102, 255, 1)',
        //     'rgba(255, 159, 64, 1)'
        // ],
    
    
    
}



function GraficaDona($Labels, $Datas, $Titulo){

    $len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
    
    echo '<div style="width:80%; text-align:right;"><a href="#'.$IdDiv.'_modal" rel=MyModal:open><img src="icon/max.png" style="" class="btnMaximizar"></a></div>
    <canvas id="'.$IdDiv.'" width="90%"  ></canvas>';
    echo '<canvas id="'.$IdDiv.'_modal" class="modal" style="display:none;" width="90%"  ></canvas>';

    echo "

    <script>
    var ctx = document.getElementById('".$IdDiv."');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [".$Labels."],
            datasets: [{
               
                data: [".$Datas."],
                ".GraficaInserColores()."
                
            }]
        },
        options: {
            title: {
                display: true,
                text: '".$Titulo."'
            },
            legend: {
                display: false,
                labels: {
                    fontColor: 'rgb(255, 99, 132)'
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });



    var ctx = document.getElementById('".$IdDiv."_modal');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            title: {
                display: true,
                text: '".$Titulo."'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    
    </script>
    ";
    
}


function GraficaPie($Labels, $Datas, $Titulo){

    $len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
    
    echo '<div style="width:80%; text-align:right;"><a href="#'.$IdDiv.'_modal" rel=MyModal:open><img src="icon/max.png" style="" class="btnMaximizar"></a></div>
    <canvas id="'.$IdDiv.'" width="90%"  ></canvas>';
    echo '<canvas id="'.$IdDiv.'_modal" class="modal" style="display:none;" width="90%"  ></canvas>';

    echo "

    <script>
    var ctx = document.getElementById('".$IdDiv."');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [".$Labels."],
            datasets: [{
               
                data: [".$Datas."],
                ".GraficaInserColores()."
                
            }]
        },
        options: {
            title: {
                display: true,
                text: '".$Titulo."'
            },
            legend: {
                display: false,
                labels: {
                    fontColor: 'rgb(255, 99, 132)'
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });



    var ctx = document.getElementById('".$IdDiv."_modal');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            title: {
                display: true,
                text: '".$Titulo."'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    
    </script>
    ";
    
}






function GraficaBarHorizontal($Labels, $Datas, $Titulo){

    $len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
    
    echo '<div style="width:80%; text-align:right;"><a href="#'.$IdDiv.'_modal" rel=MyModal:open><img src="icon/max.png" style="" class="btnMaximizar"></a></div>
    <canvas id="'.$IdDiv.'" width="90%"  ></canvas>';
    echo '<canvas id="'.$IdDiv.'_modal" class="modal" style="display:none;" width="90%"  ></canvas>';

    echo "

    <script>
    var ctx = document.getElementById('".$IdDiv."');
    var myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });



    var ctx = document.getElementById('".$IdDiv."_modal');
    var myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    
    </script>
    ";
    
}




function GraficaBarLine($Labels, $Datas, $Titulo,$Fill){

    $len = 16;    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   $cadena_base .= '0123456789' ;  $limite = strlen($cadena_base) - 1;      
    $STR = '';  for ($i=0; $i < $len; $i++){ $STR .= $cadena_base[rand(0, $limite)]; }  $IdDiv = $STR;
    
    echo '<div style="width:80%; text-align:right;"><a href="#'.$IdDiv.'_modal" rel=MyModal:open><img src="icon/max.png" style="" class="btnMaximizar"></a></div>
    <canvas id="'.$IdDiv.'" width="90%"  ></canvas>';
    echo '<canvas id="'.$IdDiv.'_modal" class="modal" style="display:none;" width="90%"  ></canvas>';

    $FillString = "";
    if ($Fill == 1) {
        $FillString = "true";
    } else {
        $FillString = "false";
    }
    echo "

    <script>
    var ctx = document.getElementById('".$IdDiv."');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {

            labels: [".$Labels."],

            datasets: [
                {
                    label: '".$Titulo."',
                    data: [".$Datas."],
                    ".GraficaInserColores()."
                    borderWidth: 1,
                    fill: ".$FillString."                
                }
            ]
        },
        options: {
          
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });



    var ctx = document.getElementById('".$IdDiv."_modal');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [".$Labels."],
            datasets: [{
                label: '".$Titulo."',
                data: [".$Datas."],
                ".GraficaInserColores()."
                borderWidth: 1,
                fill: ".$FillString."   
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    
    </script>
    ";
    
}


?>