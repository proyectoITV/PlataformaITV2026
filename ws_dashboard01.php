<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<style type="text/css">
  .tg  {border-collapse:collapse;border-spacing:0;}
  .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;
    overflow:hidden;padding:7px 5px;word-break:normal;}
  .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;
    font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
  .tg .tg-0lax{text-align:left;vertical-align:top}
</style>

<body>
  <div class="container">
    <div class="row row-cols-3">
      <div class="col">
        <?php
            require("lib/cano_funciones.php");

            $webservice_ip = "192.168.159.7";
            $webservice_nombre = "ws_dashboard_rsm.asp";
            $webservice_token = LibretaDeTokensParaWebServices(2);
            $webservice_sql  = "select%20*%20from%20Vivienda_WS_Dashboard01_ContratosPorAño%20oRDER%20By%20Total%20Desc";

            $ch = curl_init();
            $peticion = "http://".$webservice_ip."/".$webservice_nombre."?method=GET&token=".$webservice_token."&sql=".$webservice_sql;
            $array_options = array(CURLOPT_URL=>$peticion, CURLOPT_RETURNTRANSFER=>true,   );
            curl_setopt_array($ch,$array_options);
            $resp = curl_exec($ch);
            $final_decoded_data = json_decode($resp,true);
            if(is_array($final_decoded_data)){
              echo "<table class='tg'>
              <caption>Contratos realizados al ".date('l jS \of F Y h:i:s A')."</caption>
              <tr>
                <th style='background: #ab0033; color: white'>CLAVE</th>
                <th style='background: #ab0033; color: white'>DELEGACION</th>
                <th style='background: #ab0033; color: white'>2022</th>
                <th style='background: #ab0033; color: white'>2023</th>
                <th style='background: #ab0033; color: white'>2024</th>
                <th style='background: #ab0033; color: white'>2025</th>
                <th style='background: #ab0033; color: white'>2026</th>
                <th style='background: #ab0033; color: white'>2027</th>
                <th style='background: #ab0033; color: white'>2028</th>
                <th style='background: #ab0033; color: white'>TOTAL</th>
              </tr>";

              $TotalColumna1 = 0;
              $TotalColumna2 = 0;
              $TotalColumna3 = 0;
              $TotalColumna4 = 0;
              $TotalColumna5 = 0;
              $TotalColumna6 = 0;
              $TotalColumna7 = 0;
              $TotalColumna8 = 0;

              foreach ($final_decoded_data as $value) {
                $TotalColumna1 = $TotalColumna1 + $value['AÑO2022'];
                $TotalColumna2 = $TotalColumna2 + $value['AÑO2023'];
                $TotalColumna3 = $TotalColumna3 + $value['AÑO2024'];
                $TotalColumna4 = $TotalColumna4 + $value['AÑO2025'];
                $TotalColumna5 = $TotalColumna5 + $value['AÑO2026'];
                $TotalColumna6 = $TotalColumna6 + $value['AÑO2027'];
                $TotalColumna7 = $TotalColumna7 + $value['AÑO2028'];
                $TotalColumna8 = $TotalColumna8 + $value['TOTAL'];

                echo "<tr>";
                  echo "<td style='text-align:center'>".str_pad($value['IdDelegacion'], 2, "0", STR_PAD_LEFT)."</td>";
                  echo "<td>".$value['Delegacion']."</td>";
                  echo "<td style='text-align:right; width: 50px;'>".(date("Y")>=2022 ? number_format($value['AÑO2022']): '---')."</td>";
                  echo "<td style='text-align:right; width: 50px;'>".(date("Y")>=2023 ? number_format($value['AÑO2023']): '---')."</td>";
                  echo "<td style='text-align:right; width: 50px;'>".(date("Y")>=2024 ? number_format($value['AÑO2024']): '---')."</td>";
                  echo "<td style='text-align:right; width: 50px;'>".(date("Y")>=2025 ? number_format($value['AÑO2025']): '---')."</td>";
                  echo "<td style='text-align:right; width: 50px;'>".(date("Y")>=2026 ? number_format($value['AÑO2026']): '---')."</td>";
                  echo "<td style='text-align:right; width: 50px;'>".(date("Y")>=2027 ? number_format($value['AÑO2027']): '---')."</td>";
                  echo "<td style='text-align:right; width: 50px;'>".(date("Y")>=2028 ? number_format($value['AÑO2028']): '---')."</td>";
                  echo "<td style='text-align:right; width: 50px; background-color: #bc955c; color:black;'><b>".number_format($value['TOTAL'])."</b></td>";
                echo "</tr>";
              }

              echo "<tr>";
                echo "<td style='text-align:right; background-color: #bc955c; color:black;'><b</td>";
                echo "<td style='text-align:right; background-color: #bc955c; color:black;'><b>TOTAL</b></td>";
                echo "<td style='text-align:right; background-color: #bc955c; color:black;'><b>".(date("Y")>=2022 ? number_format($TotalColumna1): '---')."</b></td>";
                echo "<td style='text-align:right; background-color: #bc955c; color:black;'><b>".(date("Y")>=2023 ? number_format($TotalColumna2): '---')."</b></td>";
                echo "<td style='text-align:right; background-color: #bc955c; color:black;'><b>".(date("Y")>=2024 ? number_format($TotalColumna3): '---')."</b></td>";
                echo "<td style='text-align:right; background-color: #bc955c; color:black;'><b>".(date("Y")>=2025 ? number_format($TotalColumna4): '---')."</b></td>";
                echo "<td style='text-align:right; background-color: #bc955c; color:black;'><b>".(date("Y")>=2026 ? number_format($TotalColumna5): '---')."</b></td>";
                echo "<td style='text-align:right; background-color: #bc955c; color:black;'><b>".(date("Y")>=2027 ? number_format($TotalColumna6): '---')."</b></td>";
                echo "<td style='text-align:right; background-color: #bc955c; color:black;'><b>".(date("Y")>=2028 ? number_format($TotalColumna7): '---')."</b></td>";
                echo "<td style='text-align:right; background-color: #bc955c; color:black;'><b>".number_format($TotalColumna8)."</b></td>";
              echo "</tr>";

              echo "</table>";
            }
          else {
              echo "No existen registros a mostrar";
          }
          curl_close($ch);
        ?>
      </div>

      <div class="col">
        <?php

        echo "<table class='tg'>
        <caption>Contratos realizados al ".date('l jS \of F Y h:i:s A')."</caption>

        <tr>
          <td COLSPAN=3>Trimestre 1</td>
          <td COLSPAN=3>Trimestre 2</td>
          <td COLSPAN=3>Trimestre 3</td>
          <td COLSPAN=3>Trimestre 4</td>
        </tr>
        <tr>
          <td>Ene</td>
          <td>Feb</td>
          <td>Mar</td>
          <td>Abr</td>
          <td>May</td> 
          <td>Jun</td>
          <td>Jul</td>
          <td>Ago</td>
          <td>Sep</td>
          <td>Oct</td>
          <td>Nov</td>
          <td>Dic</td>
        </tr>

        ";

        ?>
      </div>

      <div class="col">
      </div>

    </div>
  </div>
</body>
</html>