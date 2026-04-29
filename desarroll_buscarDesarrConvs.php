<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/laura_funciones.php");
/*
$sql="
Select Folio as NumConvenio,
catdesarrolladores.Nombre, FechaConvenio,TotalLotes, MontoConvenio, PlazoConvenio, Municipio,
@num := 1 + LENGTH(convdesarrollador.IdColonia) - LENGTH(REPLACE(convdesarrollador.IdColonia, ',', ''))              AS num,
CONCAT(
IFNULL(( 
   SELECT Colonia from catcolonia 
   where IdMunicipio=convdesarrollador.IdMunicipio and 
   Idcolonia=IF(@num >= 1,SUBSTRING_INDEX(convdesarrollador.IdColonia, ',', 1)
, NULL)          ),'')                ,',',
IFNULL((
   SELECT Colonia from catcolonia 
   where IdMunicipio=convdesarrollador.IdMunicipio and 
   Idcolonia=IF(@num > 1,SUBSTRING_INDEX(SUBSTRING_INDEX(convdesarrollador.IdColonia, ',', 2), ',', -1),NULL)
),'')
					   ,',',
IFNULL((
   SELECT Colonia from catcolonia 
   where IdMunicipio=convdesarrollador.IdMunicipio and 
   Idcolonia=IF(@num > 2,SUBSTRING_INDEX(SUBSTRING_INDEX(convdesarrollador.IdColonia, ',', 3), ',', -1),NULL)
),'')	  					,',',
IFNULL(
   (SELECT Colonia from catcolonia 
   where IdMunicipio=convdesarrollador.IdMunicipio and 
   Idcolonia=IF(@num > 3,SUBSTRING_INDEX(SUBSTRING_INDEX(convdesarrollador.IdColonia, ',', 4), ',', -1),NULL))
,'')
)	   AS Colonias, 
CASE WHEN completo=1 THEN
CONCAT(' <a  href=desarroll_cob_1.php?convenio=',Folio,'><center><img src=\"./icon/flechades.png\" height=\"12\" width=\"20\" title=\"Ir a cobranza\"><center></a>')  ELSE
CONCAT(' <a  href=desarrolladores_menu.php?convenio=',Folio,'><center><img src=\"./icon/prohibido.png\" height=\"12\" width=\"20\" title=\"Imposible cobrar\"><center></a>')  END as Completo
from convdesarrollador LEFT JOIN catdesarrolladores ON convdesarrollador.IdDesarrollador=catdesarrolladores.IdDesarrollador
LEFT JOIN municipios on municipios.IdMunicipio=convdesarrollador.IdMunicipio
";  
*/

  $sql="
 Select 
 CASE WHEN completo=1 THEN
CONCAT(' <a  href=desarroll_cob_1.php?convenio=',Folio,'><center><img src=\"./icon/flechades.png\" height=\"12\" width=\"20\" title=\"Ir a cobranza\"><center></a>')  ELSE
CONCAT(' <a  href=desarrolladores_menu.php?convenio=',Folio,'><center><img src=\"./icon/prohibido.png\" height=\"12\" width=\"20\" title=\"Imposible cobrar\"><center></a>')  END as Completo,
 Folio as NumConvenio,
 catdesarrolladores.Nombre, FechaConvenio,TotalLotes, MontoConvenio, PlazoConvenio, Municipio,
@num := 1 + LENGTH(convdesarrollador.IdColonia) - LENGTH(REPLACE(convdesarrollador.IdColonia, ',', ''))              AS num,
CONCAT(
IFNULL(( 
	SELECT Colonia from catcolonia 
	where IdMunicipio=convdesarrollador.IdMunicipio and 
	Idcolonia=IF(@num >= 1,SUBSTRING_INDEX(convdesarrollador.IdColonia, ',', 1)
, NULL)          ),'')                ,',',
IFNULL((
	SELECT Colonia from catcolonia 
	where IdMunicipio=convdesarrollador.IdMunicipio and 
	Idcolonia=IF(@num > 1,SUBSTRING_INDEX(SUBSTRING_INDEX(convdesarrollador.IdColonia, ',', 2), ',', -1),NULL)
),'')
						,',',
 IFNULL((
	SELECT Colonia from catcolonia 
	where IdMunicipio=convdesarrollador.IdMunicipio and 
	Idcolonia=IF(@num > 2,SUBSTRING_INDEX(SUBSTRING_INDEX(convdesarrollador.IdColonia, ',', 3), ',', -1),NULL)
),'')	  					,',',
IFNULL(
	(SELECT Colonia from catcolonia 
	where IdMunicipio=convdesarrollador.IdMunicipio and 
	Idcolonia=IF(@num > 3,SUBSTRING_INDEX(SUBSTRING_INDEX(convdesarrollador.IdColonia, ',', 4), ',', -1),NULL))
,'')
)	   AS Colonias

from convdesarrollador LEFT JOIN catdesarrolladores ON convdesarrollador.IdDesarrollador=catdesarrolladores.IdDesarrollador
LEFT JOIN municipios on municipios.IdMunicipio=convdesarrollador.IdMunicipio
 ";  
TablaDinamica_MySQL2("",$sql, "MiIdDivTabla2", "IdTabla2", "", 2,"",'CONVENIOS DE DESARROLLADORES','Portrait','Desarrolladores'); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal


//CONCAT(' <a  href=e003.php?contrato=',NumContrato,'><center><img src=\"./icon/ojo2.png\" height=\"12\" width=\"20\" title=\"Consultar trámiete\"><center></a>')     as ''


/* $sql="Select Folio as NumConvenio,
 catdesarrolladores.Nombre, FechaConvenio,TotalLotes, MontoConvenio, PlazoConvenio, Completo, Municipio,
@num := 1 + LENGTH(convdesarrollador.IdColonia) - LENGTH(REPLACE(convdesarrollador.IdColonia, ',', ''))  AS num,
( 
	SELECT Colonia from catcolonia 
	where IdMunicipio=convdesarrollador.IdMunicipio and 
	Idcolonia=IF(@num >= 1,SUBSTRING_INDEX(convdesarrollador.IdColonia, ',', 1)
, NULL)          )                 AS Colonia1,
(
	SELECT Colonia from catcolonia 
	where IdMunicipio=convdesarrollador.IdMunicipio and 
	Idcolonia=IF(@num > 1,SUBSTRING_INDEX(SUBSTRING_INDEX(convdesarrollador.IdColonia, ',', 2), ',', -1),NULL)
)
 as colonia2, 
 (
	SELECT Colonia from catcolonia 
	where IdMunicipio=convdesarrollador.IdMunicipio and 
	Idcolonia=IF(@num > 1,SUBSTRING_INDEX(SUBSTRING_INDEX(convdesarrollador.IdColonia, ',', 3), ',', -1),NULL)
)	  AS colonia3
from convdesarrollador LEFT JOIN catdesarrolladores ON convdesarrollador.IdDesarrollador=catdesarrolladores.IdDesarrollador
LEFT JOIN MUNICIPIOS on MUNICIPIOS.IdMunicipio=convdesarrollador.IdMunicipio";
 */
//WHERE convdesarrollador.Folio=17 OR convdesarrollador.Folio=98

?>