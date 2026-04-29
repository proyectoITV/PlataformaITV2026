<?php
class Plantilla {
    const PLANTILLA_URLWEBSERVICE = "https://plataformaitavu.tamaulipas.gob.mx/gepladoc/ws/get.php";
    const PLANTILLA_TOKEN = "pI4NtYII4V1v1";

    public $IdPlantilla = 0;
    public $NEmpleado= "";

    public $VC001 = "";
    public $VC002 = "";
    public $VC003 = "";
    public $VC004 = "";
    public $VC005 = "";
    public $VC006 = "";
    public $VC007 = "";
    public $VC008 = "";
    public $VC009 = "";
    public $VC010 = "";
    public $VC011 = "";
    public $VC012 = "";
    public $VC013 = "";
    public $VC014 = "";
    public $VC015 = "";
    public $VC016 = "";
    public $VC017 = "";
    public $VC018 = "";
    public $VC019 = "";
    public $VC020 = "";
    public $VC021 = "";
    public $VC022 = "";
    public $VC023 = "";
    public $VC024 = "";
    public $VC025 = "";
    public $VC026 = "";
    public $VC027 = "";
    public $VC028 = "";
    public $VC029 = "";
    public $VC030 = "";
    public $VC031 = "";
    public $VC032 = "";
    public $VC033 = "";
    public $VC034 = "";
    public $VC035 = "";
    public $VC036 = "";
    public $VC037 = "";
    public $VC038 = "";
    public $VC039 = "";
    public $VC040 = "";
    public $VC041 = "";
    public $VC042 = "";
    public $VC043 = "";
    public $VC044 = "";
    public $VC045 = "";
    public $VC046 = "";
    public $VC047 = "";
    public $VC048 = "";
    public $VC049 = "";
    public $VC050 = "";
    public $VC051 = "";
    public $VC052 = "";
    public $VC053 = "";
    public $VC054 = "";
    public $VC055 = "";
    public $VC056 = "";
    public $VC057 = "";
    public $VC058 = "";
    public $VC059 = "";
    public $VC060 = "";
    public $VC061 = "";
    public $VC062 = "";
    public $VC063 = "";
    public $VC064 = "";
    public $VC065 = "";
    public $VC066 = "";
    public $VC067 = "";
    public $VC068 = "";
    public $VC069 = "";
    public $VC070 = "";
    public $VC071 = "";
    public $VC072 = "";
    public $VC073 = "";
    public $VC074 = "";
    public $VC075 = "";
    public $VC076 = "";
    public $VC077 = "";
    public $VC078 = "";
    public $VC079 = "";
    public $VC080 = "";
    public $VC081 = "";
    public $VC082 = "";
    public $VC083 = "";
    public $VC084 = "";
    public $VC085 = "";
    public $VC086 = "";
    public $VC087 = "";
    public $VC088 = "";
    public $VC089 = "";
    public $VC090 = "";
    public $VC091 = "";
    public $VC092 = "";
    public $VC093 = "";
    public $VC094 = "";
    public $VC095 = "";
    public $VC096 = "";
    public $VC097 = "";
    public $VC098 = "";
    public $VC099 = "";
    public $VC100 = "";
    public $VC101 = "";
    public $VC102 = "";
    public $VC103 = "";
    public $VC104 = "";
    public $VC105 = "";
    public $VC106 = "";
    public $VC107 = "";
    public $VC108 = "";
    public $VC109 = "";
    public $VC110 = "";
    public $VC111 = "";
    public $VC112 = "";
    public $VC113 = "";
    public $VC114 = "";
    public $VC115 = "";
    public $VC116 = "";
    public $VC117 = "";
    public $VC118 = "";
    public $VC119 = "";
    public $VC120 = "";
    public $VC121 = "";
    public $VC122 = "";
    public $VC123 = "";
    public $VC124 = "";
    public $VC125 = "";
    public $VC126 = "";
    public $VC127 = "";
    public $VC128 = "";
    public $VC129 = "";
    public $VC130 = "";
    public $VC131 = "";
    public $VC132 = "";
    public $VC133 = "";
    public $VC134 = "";
    public $VC135 = "";
    public $VC136 = "";
    public $VC137 = "";
    public $VC138 = "";
    public $VC139 = "";
    public $VC140 = "";
    public $VC141 = "";
    public $VC142 = "";
    public $VC143 = "";
    public $VC144 = "";
    public $VC145 = "";
    public $VC146 = "";
    public $VC147 = "";
    public $VC148 = "";
    public $VC149 = "";
    public $VC150 = "";
    public $VC151 = "";
    public $VC152 = "";
    public $VC153 = "";
    public $VC154 = "";
    public $VC155 = "";
    public $VC156 = "";
    public $VC157 = "";
    public $VC158 = "";
    public $VC159 = "";
    public $VC160 = "";
    public $VC161 = "";
    public $VC162 = "";
    public $VC163 = "";
    public $VC164 = "";
    public $VC165 = "";
    public $VC166 = "";
    public $VC167 = "";
    public $VC168 = "";
    public $VC169 = "";
    public $VC170 = "";
    public $VC171 = "";
    public $VC172 = "";
    public $VC173 = "";
    public $VC174 = "";
    public $VC175 = "";
    public $VC176 = "";
    public $VC177 = "";
    public $VC178 = "";
    public $VC179 = "";
    public $VC180 = "";

    public $IframeSRC = "";
    public $Respuesta = "";
    public $Exito = "";
    public $urlFile ="";
    public $html = "";


    public function __construcT($IdPlantilla, $NEmpleado){
        $this->IdPlantilla = $IdPlantilla;
        $this->NEmpleado = $NEmpleado;
    }

    public function getVC001(){return $this->VC001;}
    public function getVC002(){return $this->VC002;}
    public function getVC003(){return $this->VC003;}
    public function getVC004(){return $this->VC004;}
    public function getVC005(){return $this->VC005;}
    public function getVC006(){return $this->VC006;}
    public function getVC007(){return $this->VC007;}
    public function getVC008(){return $this->VC008;}
    public function getVC009(){return $this->VC009;}
    public function getVC010(){return $this->VC010;}
    public function getVC011(){return $this->VC011;}
    public function getVC012(){return $this->VC012;}
    public function getVC013(){return $this->VC013;}
    public function getVC014(){return $this->VC014;}
    public function getVC015(){return $this->VC015;}
    public function getVC016(){return $this->VC016;}
    public function getVC017(){return $this->VC017;}
    public function getVC018(){return $this->VC018;}
    public function getVC019(){return $this->VC019;}
    public function getVC020(){return $this->VC020;}
    public function getVC021(){return $this->VC021;}
    public function getVC022(){return $this->VC022;}
    public function getVC023(){return $this->VC023;}
    public function getVC024(){return $this->VC024;}
    public function getVC025(){return $this->VC025;}
    public function getVC026(){return $this->VC026;}
    public function getVC027(){return $this->VC027;}
    public function getVC028(){return $this->VC028;}
    public function getVC029(){return $this->VC029;}
    public function getVC030(){return $this->VC030;}
    public function getVC031(){return $this->VC031;}
    public function getVC032(){return $this->VC032;}
    public function getVC033(){return $this->VC033;}
    public function getVC034(){return $this->VC034;}
    public function getVC035(){return $this->VC035;}
    public function getVC036(){return $this->VC036;}
    public function getVC037(){return $this->VC037;}
    public function getVC038(){return $this->VC038;}
    public function getVC039(){return $this->VC039;}
    public function getVC040(){return $this->VC040;}
    public function getVC041(){return $this->VC041;}
    public function getVC042(){return $this->VC042;}
    public function getVC043(){return $this->VC043;}
    public function getVC044(){return $this->VC044;}
    public function getVC045(){return $this->VC045;}
    public function getVC046(){return $this->VC046;}
    public function getVC047(){return $this->VC047;}
    public function getVC048(){return $this->VC048;}
    public function getVC049(){return $this->VC049;}
    public function getVC050(){return $this->VC050;}
    public function getVC051(){return $this->VC051;}
    public function getVC052(){return $this->VC052;}
    public function getVC053(){return $this->VC053;}
    public function getVC054(){return $this->VC054;}
    public function getVC055(){return $this->VC055;}
    public function getVC056(){return $this->VC056;}
    public function getVC057(){return $this->VC057;}
    public function getVC058(){return $this->VC058;}
    public function getVC059(){return $this->VC059;}
    public function getVC060(){return $this->VC060;}
    public function getVC061(){return $this->VC061;}
    public function getVC062(){return $this->VC062;}
    public function getVC063(){return $this->VC063;}
    public function getVC064(){return $this->VC064;}
    public function getVC065(){return $this->VC065;}
    public function getVC066(){return $this->VC066;}
    public function getVC067(){return $this->VC067;}
    public function getVC068(){return $this->VC068;}
    public function getVC069(){return $this->VC069;}
    public function getVC070(){return $this->VC070;}
    public function getVC071(){return $this->VC071;}
    public function getVC072(){return $this->VC072;}
    public function getVC073(){return $this->VC073;}
    public function getVC074(){return $this->VC074;}
    public function getVC075(){return $this->VC075;}
    public function getVC076(){return $this->VC076;}
    public function getVC077(){return $this->VC077;}
    public function getVC078(){return $this->VC078;}
    public function getVC079(){return $this->VC079;}
    public function getVC080(){return $this->VC080;}
    public function getVC081(){return $this->VC081;}
    public function getVC082(){return $this->VC082;}
    public function getVC083(){return $this->VC083;}
    public function getVC084(){return $this->VC084;}
    public function getVC085(){return $this->VC085;}
    public function getVC086(){return $this->VC086;}
    public function getVC087(){return $this->VC087;}
    public function getVC088(){return $this->VC088;}
    public function getVC089(){return $this->VC089;}
    public function getVC090(){return $this->VC090;}
    public function getVC091(){return $this->VC091;}
    public function getVC092(){return $this->VC092;}
    public function getVC093(){return $this->VC093;}
    public function getVC094(){return $this->VC094;}
    public function getVC095(){return $this->VC095;}
    public function getVC096(){return $this->VC096;}
    public function getVC097(){return $this->VC097;}
    public function getVC098(){return $this->VC098;}
    public function getVC099(){return $this->VC099;}
    public function getVC100(){return $this->VC100;}
    public function getVC101(){return $this->VC101;}
    public function getVC102(){return $this->VC102;}
    public function getVC103(){return $this->VC103;}
    public function getVC104(){return $this->VC104;}
    public function getVC105(){return $this->VC105;}
    public function getVC106(){return $this->VC106;}
    public function getVC107(){return $this->VC107;}
    public function getVC108(){return $this->VC108;}
    public function getVC109(){return $this->VC109;}
    public function getVC110(){return $this->VC110;}
    public function getVC111(){return $this->VC111;}
    public function getVC112(){return $this->VC112;}
    public function getVC113(){return $this->VC113;}
    public function getVC114(){return $this->VC114;}
    public function getVC115(){return $this->VC115;}
    public function getVC116(){return $this->VC116;}
    public function getVC117(){return $this->VC117;}
    public function getVC118(){return $this->VC118;}
    public function getVC119(){return $this->VC119;}
    public function getVC120(){return $this->VC120;}
    public function getVC121(){return $this->VC121;}
    public function getVC122(){return $this->VC122;}
    public function getVC123(){return $this->VC123;}
    public function getVC124(){return $this->VC124;}
    public function getVC125(){return $this->VC125;}
    public function getVC126(){return $this->VC126;}
    public function getVC127(){return $this->VC127;}
    public function getVC128(){return $this->VC128;}
    public function getVC129(){return $this->VC129;}
    public function getVC130(){return $this->VC130;}
    public function getVC131(){return $this->VC131;}
    public function getVC132(){return $this->VC132;}
    public function getVC133(){return $this->VC133;}
    public function getVC134(){return $this->VC134;}
    public function getVC135(){return $this->VC135;}
    public function getVC136(){return $this->VC136;}
    public function getVC137(){return $this->VC137;}
    public function getVC138(){return $this->VC138;}
    public function getVC139(){return $this->VC139;}
    public function getVC140(){return $this->VC140;}
    public function getVC141(){return $this->VC141;}
    public function getVC142(){return $this->VC142;}
    public function getVC143(){return $this->VC143;}
    public function getVC144(){return $this->VC144;}
    public function getVC145(){return $this->VC145;}
    public function getVC146(){return $this->VC146;}
    public function getVC147(){return $this->VC147;}
    public function getVC148(){return $this->VC148;}
    public function getVC149(){return $this->VC149;}
    public function getVC150(){return $this->VC150;}
    public function getVC151(){return $this->VC151;}
    public function getVC152(){return $this->VC152;}
    public function getVC153(){return $this->VC153;}
    public function getVC154(){return $this->VC154;}
    public function getVC155(){return $this->VC155;}
    public function getVC156(){return $this->VC156;}
    public function getVC157(){return $this->VC157;}
    public function getVC158(){return $this->VC158;}
    public function getVC159(){return $this->VC159;}
    public function getVC160(){return $this->VC160;}
    public function getVC161(){return $this->VC161;}
    public function getVC162(){return $this->VC162;}
    public function getVC163(){return $this->VC163;}
    public function getVC164(){return $this->VC164;}
    public function getVC165(){return $this->VC165;}
    public function getVC166(){return $this->VC166;}
    public function getVC167(){return $this->VC167;}
    public function getVC168(){return $this->VC168;}
    public function getVC169(){return $this->VC169;}
    public function getVC170(){return $this->VC170;}
    public function getVC171(){return $this->VC171;}
    public function getVC172(){return $this->VC172;}
    public function getVC173(){return $this->VC173;}
    public function getVC174(){return $this->VC174;}
    public function getVC175(){return $this->VC175;}
    public function getVC176(){return $this->VC176;}
    public function getVC177(){return $this->VC177;}
    public function getVC178(){return $this->VC178;}
    public function getVC179(){return $this->VC179;}
    public function getVC180(){return $this->VC180;}

    public function setVC001($value){$this->VC001 = $value;}
    public function setVC002($value){$this->VC002 = $value;}
    public function setVC003($value){$this->VC003 = $value;}
    public function setVC004($value){$this->VC004 = $value;}
    public function setVC005($value){$this->VC005 = $value;}
    public function setVC006($value){$this->VC006 = $value;}
    public function setVC007($value){$this->VC007 = $value;}
    public function setVC008($value){$this->VC008 = $value;}
    public function setVC009($value){$this->VC009 = $value;}
    public function setVC010($value){$this->VC010 = $value;}
    public function setVC011($value){$this->VC011 = $value;}
    public function setVC012($value){$this->VC012 = $value;}
    public function setVC013($value){$this->VC013 = $value;}
    public function setVC014($value){$this->VC014 = $value;}
    public function setVC015($value){$this->VC015 = $value;}
    public function setVC016($value){$this->VC016 = $value;}
    public function setVC017($value){$this->VC017 = $value;}
    public function setVC018($value){$this->VC018 = $value;}
    public function setVC019($value){$this->VC019 = $value;}
    public function setVC020($value){$this->VC020 = $value;}
    public function setVC021($value){$this->VC021 = $value;}
    public function setVC022($value){$this->VC022 = $value;}
    public function setVC023($value){$this->VC023 = $value;}
    public function setVC024($value){$this->VC024 = $value;}
    public function setVC025($value){$this->VC025 = $value;}
    public function setVC026($value){$this->VC026 = $value;}
    public function setVC027($value){$this->VC027 = $value;}
    public function setVC028($value){$this->VC028 = $value;}
    public function setVC029($value){$this->VC029 = $value;}
    public function setVC030($value){$this->VC030 = $value;}
    public function setVC031($value){$this->VC031 = $value;}
    public function setVC032($value){$this->VC032 = $value;}
    public function setVC033($value){$this->VC033 = $value;}
    public function setVC034($value){$this->VC034 = $value;}
    public function setVC035($value){$this->VC035 = $value;}
    public function setVC036($value){$this->VC036 = $value;}
    public function setVC037($value){$this->VC037 = $value;}
    public function setVC038($value){$this->VC038 = $value;}
    public function setVC039($value){$this->VC039 = $value;}
    public function setVC040($value){$this->VC040 = $value;}
    public function setVC041($value){$this->VC041 = $value;}
    public function setVC042($value){$this->VC042 = $value;}
    public function setVC043($value){$this->VC043 = $value;}
    public function setVC044($value){$this->VC044 = $value;}
    public function setVC045($value){$this->VC045 = $value;}
    public function setVC046($value){$this->VC046 = $value;}
    public function setVC047($value){$this->VC047 = $value;}
    public function setVC048($value){$this->VC048 = $value;}
    public function setVC049($value){$this->VC049 = $value;}
    public function setVC050($value){$this->VC050 = $value;}
    public function setVC051($value){$this->VC051 = $value;}
    public function setVC052($value){$this->VC052 = $value;}
    public function setVC053($value){$this->VC053 = $value;}
    public function setVC054($value){$this->VC054 = $value;}
    public function setVC055($value){$this->VC055 = $value;}
    public function setVC056($value){$this->VC056 = $value;}
    public function setVC057($value){$this->VC057 = $value;}
    public function setVC058($value){$this->VC058 = $value;}
    public function setVC059($value){$this->VC059 = $value;}
    public function setVC060($value){$this->VC060 = $value;}
    public function setVC061($value){$this->VC061 = $value;}
    public function setVC062($value){$this->VC062 = $value;}
    public function setVC063($value){$this->VC063 = $value;}
    public function setVC064($value){$this->VC064 = $value;}
    public function setVC065($value){$this->VC065 = $value;}
    public function setVC066($value){$this->VC066 = $value;}
    public function setVC067($value){$this->VC067 = $value;}
    public function setVC068($value){$this->VC068 = $value;}
    public function setVC069($value){$this->VC069 = $value;}
    public function setVC070($value){$this->VC070 = $value;}
    public function setVC071($value){$this->VC071 = $value;}
    public function setVC072($value){$this->VC072 = $value;}
    public function setVC073($value){$this->VC073 = $value;}
    public function setVC074($value){$this->VC074 = $value;}
    public function setVC075($value){$this->VC075 = $value;}
    public function setVC076($value){$this->VC076 = $value;}
    public function setVC077($value){$this->VC077 = $value;}
    public function setVC078($value){$this->VC078 = $value;}
    public function setVC079($value){$this->VC079 = $value;}
    public function setVC080($value){$this->VC080 = $value;}
    public function setVC081($value){$this->VC081 = $value;}
    public function setVC082($value){$this->VC082 = $value;}
    public function setVC083($value){$this->VC083 = $value;}
    public function setVC084($value){$this->VC084 = $value;}
    public function setVC085($value){$this->VC085 = $value;}
    public function setVC086($value){$this->VC086 = $value;}
    public function setVC087($value){$this->VC087 = $value;}
    public function setVC088($value){$this->VC088 = $value;}
    public function setVC089($value){$this->VC089 = $value;}
    public function setVC090($value){$this->VC090 = $value;}
    public function setVC091($value){$this->VC091 = $value;}
    public function setVC092($value){$this->VC092 = $value;}
    public function setVC093($value){$this->VC093 = $value;}
    public function setVC094($value){$this->VC094 = $value;}
    public function setVC095($value){$this->VC095 = $value;}
    public function setVC096($value){$this->VC096 = $value;}
    public function setVC097($value){$this->VC097 = $value;}
    public function setVC098($value){$this->VC098 = $value;}
    public function setVC099($value){$this->VC099 = $value;}
    public function setVC100($value){$this->VC100 = $value;}
    public function setVC101($value){$this->VC101 = $value;}
    public function setVC102($value){$this->VC102 = $value;}
    public function setVC103($value){$this->VC103 = $value;}
    public function setVC104($value){$this->VC104 = $value;}
    public function setVC105($value){$this->VC105 = $value;}
    public function setVC106($value){$this->VC106 = $value;}
    public function setVC107($value){$this->VC107 = $value;}
    public function setVC108($value){$this->VC108 = $value;}
    public function setVC109($value){$this->VC109 = $value;}
    public function setVC110($value){$this->VC110 = $value;}
    public function setVC111($value){$this->VC111 = $value;}
    public function setVC112($value){$this->VC112 = $value;}
    public function setVC113($value){$this->VC113 = $value;}
    public function setVC114($value){$this->VC114 = $value;}
    public function setVC115($value){$this->VC115 = $value;}
    public function setVC116($value){$this->VC116 = $value;}
    public function setVC117($value){$this->VC117 = $value;}
    public function setVC118($value){$this->VC118 = $value;}
    public function setVC119($value){$this->VC119 = $value;}
    public function setVC120($value){$this->VC120 = $value;}
    public function setVC121($value){$this->VC121 = $value;}
    public function setVC122($value){$this->VC122 = $value;}
    public function setVC123($value){$this->VC123 = $value;}
    public function setVC124($value){$this->VC124 = $value;}
    public function setVC125($value){$this->VC125 = $value;}
    public function setVC126($value){$this->VC126 = $value;}
    public function setVC127($value){$this->VC127 = $value;}
    public function setVC128($value){$this->VC128 = $value;}
    public function setVC129($value){$this->VC129 = $value;}
    public function setVC130($value){$this->VC130 = $value;}
    public function setVC131($value){$this->VC131 = $value;}
    public function setVC132($value){$this->VC132 = $value;}
    public function setVC133($value){$this->VC133 = $value;}
    public function setVC134($value){$this->VC134 = $value;}
    public function setVC135($value){$this->VC135 = $value;}
    public function setVC136($value){$this->VC136 = $value;}
    public function setVC137($value){$this->VC137 = $value;}
    public function setVC138($value){$this->VC138 = $value;}
    public function setVC139($value){$this->VC139 = $value;}
    public function setVC140($value){$this->VC140 = $value;}
    public function setVC141($value){$this->VC141 = $value;}
    public function setVC142($value){$this->VC142 = $value;}
    public function setVC143($value){$this->VC143 = $value;}
    public function setVC144($value){$this->VC144 = $value;}
    public function setVC145($value){$this->VC145 = $value;}
    public function setVC146($value){$this->VC146 = $value;}
    public function setVC147($value){$this->VC147 = $value;}
    public function setVC148($value){$this->VC148 = $value;}
    public function setVC149($value){$this->VC149 = $value;}
    public function setVC150($value){$this->VC150 = $value;}
    public function setVC151($value){$this->VC151 = $value;}
    public function setVC152($value){$this->VC152 = $value;}
    public function setVC153($value){$this->VC153 = $value;}
    public function setVC154($value){$this->VC154 = $value;}
    public function setVC155($value){$this->VC155 = $value;}
    public function setVC156($value){$this->VC156 = $value;}
    public function setVC157($value){$this->VC157 = $value;}
    public function setVC158($value){$this->VC158 = $value;}
    public function setVC159($value){$this->VC159 = $value;}
    public function setVC160($value){$this->VC160 = $value;}
    public function setVC161($value){$this->VC161 = $value;}
    public function setVC162($value){$this->VC162 = $value;}
    public function setVC163($value){$this->VC163 = $value;}
    public function setVC164($value){$this->VC164 = $value;}
    public function setVC165($value){$this->VC165 = $value;}
    public function setVC166($value){$this->VC166 = $value;}
    public function setVC167($value){$this->VC167 = $value;}
    public function setVC168($value){$this->VC168 = $value;}
    public function setVC169($value){$this->VC169 = $value;}
    public function setVC170($value){$this->VC170 = $value;}
    public function setVC171($value){$this->VC171 = $value;}
    public function setVC172($value){$this->VC172 = $value;}
    public function setVC173($value){$this->VC173 = $value;}
    public function setVC174($value){$this->VC174 = $value;}
    public function setVC175($value){$this->VC175 = $value;}
    public function setVC176($value){$this->VC176 = $value;}
    public function setVC177($value){$this->VC177 = $value;}
    public function setVC178($value){$this->VC178 = $value;}
    public function setVC179($value){$this->VC179 = $value;}
    public function setVC180($value){$this->VC180 = $value;}

    public function Create(){                    
        $Peticion = new stdClass;
        $Peticion->ApiKey = Plantilla::PLANTILLA_TOKEN;
        $Peticion->IdPlantilla = $this->IdPlantilla;
        $Peticion->NEmpleado = $this->NEmpleado;

        $Peticion->VC001 = $this->VC001;
        $Peticion->VC002 = $this->VC002;
        $Peticion->VC003 = $this->VC003;
        $Peticion->VC004 = $this->VC004;
        $Peticion->VC005 = $this->VC005;
        $Peticion->VC006 = $this->VC006;
        $Peticion->VC007 = $this->VC007;
        $Peticion->VC008 = $this->VC008;
        $Peticion->VC009 = $this->VC009;
        $Peticion->VC010 = $this->VC010;
        $Peticion->VC011 = $this->VC011;
        $Peticion->VC012 = $this->VC012;
        $Peticion->VC013 = $this->VC013;
        $Peticion->VC014 = $this->VC014;
        $Peticion->VC015 = $this->VC015;
        $Peticion->VC016 = $this->VC016;
        $Peticion->VC017 = $this->VC017;
        $Peticion->VC018 = $this->VC018;
        $Peticion->VC019 = $this->VC019;
        $Peticion->VC020 = $this->VC020;
        $Peticion->VC021 = $this->VC021;
        $Peticion->VC022 = $this->VC022;
        $Peticion->VC023 = $this->VC023;
        $Peticion->VC024 = $this->VC024;
        $Peticion->VC025 = $this->VC025;
        $Peticion->VC026 = $this->VC026;
        $Peticion->VC027 = $this->VC027;
        $Peticion->VC028 = $this->VC028;
        $Peticion->VC029 = $this->VC029;
        $Peticion->VC030 = $this->VC030;
        $Peticion->VC031 = $this->VC031;
        $Peticion->VC032 = $this->VC032;
        $Peticion->VC033 = $this->VC033;
        $Peticion->VC034 = $this->VC034;
        $Peticion->VC035 = $this->VC035;
        $Peticion->VC036 = $this->VC036;
        $Peticion->VC037 = $this->VC037;
        $Peticion->VC038 = $this->VC038;
        $Peticion->VC039 = $this->VC039;
        $Peticion->VC040 = $this->VC040;
        $Peticion->VC041 = $this->VC041;
        $Peticion->VC042 = $this->VC042;
        $Peticion->VC043 = $this->VC043;
        $Peticion->VC044 = $this->VC044;
        $Peticion->VC045 = $this->VC045;
        $Peticion->VC046 = $this->VC046;
        $Peticion->VC047 = $this->VC047;
        $Peticion->VC048 = $this->VC048;
        $Peticion->VC049 = $this->VC049;
        $Peticion->VC050 = $this->VC050;
        $Peticion->VC051 = $this->VC051;
        $Peticion->VC052 = $this->VC052;
        $Peticion->VC053 = $this->VC053;
        $Peticion->VC054 = $this->VC054;
        $Peticion->VC055 = $this->VC055;
        $Peticion->VC056 = $this->VC056;
        $Peticion->VC057 = $this->VC057;
        $Peticion->VC058 = $this->VC058;
        $Peticion->VC059 = $this->VC059;
        $Peticion->VC060 = $this->VC060;
        $Peticion->VC061 = $this->VC061;
        $Peticion->VC062 = $this->VC062;
        $Peticion->VC063 = $this->VC063;
        $Peticion->VC064 = $this->VC064;
        $Peticion->VC065 = $this->VC065;
        $Peticion->VC066 = $this->VC066;
        $Peticion->VC067 = $this->VC067;
        $Peticion->VC068 = $this->VC068;
        $Peticion->VC069 = $this->VC069;
        $Peticion->VC070 = $this->VC070;
        $Peticion->VC071 = $this->VC071;
        $Peticion->VC072 = $this->VC072;
        $Peticion->VC073 = $this->VC073;
        $Peticion->VC074 = $this->VC074;
        $Peticion->VC075 = $this->VC075;
        $Peticion->VC076 = $this->VC076;
        $Peticion->VC077 = $this->VC077;
        $Peticion->VC078 = $this->VC078;
        $Peticion->VC079 = $this->VC079;
        $Peticion->VC080 = $this->VC080;
        $Peticion->VC081 = $this->VC081;
        $Peticion->VC082 = $this->VC082;
        $Peticion->VC083 = $this->VC083;
        $Peticion->VC084 = $this->VC084;
        $Peticion->VC085 = $this->VC085;
        $Peticion->VC086 = $this->VC086;
        $Peticion->VC087 = $this->VC087;
        $Peticion->VC088 = $this->VC088;
        $Peticion->VC089 = $this->VC089;
        $Peticion->VC090 = $this->VC090;
        $Peticion->VC091 = $this->VC091;
        $Peticion->VC092 = $this->VC092;
        $Peticion->VC093 = $this->VC093;
        $Peticion->VC094 = $this->VC094;
        $Peticion->VC095 = $this->VC095;
        $Peticion->VC096 = $this->VC096;
        $Peticion->VC097 = $this->VC097;
        $Peticion->VC098 = $this->VC098;
        $Peticion->VC099 = $this->VC099;
        $Peticion->VC100 = $this->VC100;
        $Peticion->VC101 = $this->VC101;
        $Peticion->VC102 = $this->VC102;
        $Peticion->VC103 = $this->VC103;
        $Peticion->VC104 = $this->VC104;
        $Peticion->VC105 = $this->VC105;
        $Peticion->VC106 = $this->VC106;
        $Peticion->VC107 = $this->VC107;
        $Peticion->VC108 = $this->VC108;
        $Peticion->VC109 = $this->VC109;
        $Peticion->VC110 = $this->VC110;
        $Peticion->VC111 = $this->VC111;
        $Peticion->VC112 = $this->VC112;
        $Peticion->VC113 = $this->VC113;
        $Peticion->VC114 = $this->VC114;
        $Peticion->VC115 = $this->VC115;
        $Peticion->VC116 = $this->VC116;
        $Peticion->VC117 = $this->VC117;
        $Peticion->VC118 = $this->VC118;
        $Peticion->VC119 = $this->VC119;
        $Peticion->VC120 = $this->VC120;
        $Peticion->VC121 = $this->VC121;
        $Peticion->VC122 = $this->VC122;
        $Peticion->VC123 = $this->VC123;
        $Peticion->VC124 = $this->VC124;
        $Peticion->VC125 = $this->VC125;
        $Peticion->VC126 = $this->VC126;
        $Peticion->VC127 = $this->VC127;
        $Peticion->VC128 = $this->VC128;
        $Peticion->VC129 = $this->VC129;
        $Peticion->VC130 = $this->VC130;
        $Peticion->VC131 = $this->VC131;
        $Peticion->VC132 = $this->VC132;
        $Peticion->VC133 = $this->VC133;
        $Peticion->VC134 = $this->VC134;
        $Peticion->VC135 = $this->VC135;
        $Peticion->VC136 = $this->VC136;
        $Peticion->VC137 = $this->VC137;
        $Peticion->VC138 = $this->VC138;
        $Peticion->VC139 = $this->VC139;
        $Peticion->VC140 = $this->VC140;
        $Peticion->VC141 = $this->VC141;
        $Peticion->VC142 = $this->VC142;
        $Peticion->VC143 = $this->VC143;
        $Peticion->VC144 = $this->VC144;
        $Peticion->VC145 = $this->VC145;
        $Peticion->VC146 = $this->VC146;
        $Peticion->VC147 = $this->VC147;
        $Peticion->VC148 = $this->VC148;
        $Peticion->VC149 = $this->VC149;
        $Peticion->VC150 = $this->VC150;
        $Peticion->VC151 = $this->VC151;
        $Peticion->VC152 = $this->VC152;
        $Peticion->VC153 = $this->VC153;
        $Peticion->VC154 = $this->VC154;
        $Peticion->VC155 = $this->VC155;
        $Peticion->VC156 = $this->VC156;
        $Peticion->VC157 = $this->VC157;
        $Peticion->VC158 = $this->VC158;
        $Peticion->VC159 = $this->VC159;
        $Peticion->VC160 = $this->VC160;
        $Peticion->VC161 = $this->VC161;
        $Peticion->VC162 = $this->VC162;
        $Peticion->VC163 = $this->VC163;
        $Peticion->VC164 = $this->VC164;
        $Peticion->VC165 = $this->VC165;
        $Peticion->VC166 = $this->VC166;
        $Peticion->VC167 = $this->VC167;
        $Peticion->VC168 = $this->VC168;
        $Peticion->VC169 = $this->VC169;
        $Peticion->VC170 = $this->VC170;
        $Peticion->VC171 = $this->VC171;
        $Peticion->VC172 = $this->VC172;
        $Peticion->VC173 = $this->VC173;
        $Peticion->VC174 = $this->VC174;
        $Peticion->VC175 = $this->VC175;
        $Peticion->VC176 = $this->VC176;
        $Peticion->VC177 = $this->VC177;
        $Peticion->VC178 = $this->VC178;
        $Peticion->VC179 = $this->VC179;
        $Peticion->VC180 = $this->VC180;

        $myJSON = json_encode($Peticion,JSON_UNESCAPED_SLASHES);
        
        $datos_post = http_build_query(
            $Peticion
        );

        $opciones = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $datos_post
            ),
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            )
        );        
        $context = stream_context_create($opciones);     
        
   
        $archivo_web = file_get_contents(Plantilla::PLANTILLA_URLWEBSERVICE, false, $context);            
        //$data = json_decode($archivo_web);
       
        //var_dump($archivo_web); //<-- respuesta        
        $res = explode("{",$archivo_web);
        $res = explode("}",$res[1]);
        $respuesta = "[{".$res[0]."}]";

        $array = json_decode($respuesta);
        //var_dump($array);



        /*foreach($array as $key => $val) {
            echo $array[$key] = $val.'<br>';
        }*/

       /* if(is_array($array)){
            //$vuelta = 0;
          foreach ($array as $val) {
            /*  $vuelta = $vuelta + 1;
                //echo $val."<br>";
                if($vuelta == 1){
                    $this->Exito = $val;
                }else if($vuelta == 2){
                    $this->IframeSRC = $val;
                }else if($vuelta == 3){
                    $this->Respuesta = $val;
                }else if($vuelta == 4){
                    $this->urlFile = $val;
                }*/
          /*      $this->Exito = $val->exito;
                $this->IframeSRC = $val->embed;
                $this->Respuesta = $val->msg;
                $this->urlFile = $val->urlfile;
               /*  $this->Exito = $val['exito'];
                $this->IframeSRC = $val['embed'];
                $this->Respuesta = $val['msg'];
                $this->urlFile = $val['urlfile'];*/
         /*   }
        }else{
            echo "no es un array";
        }*/
     
        
       $jsonIterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator(json_decode($respuesta, TRUE)),
            RecursiveIteratorIterator::SELF_FIRST
        );

        
        foreach ($jsonIterator as $key => $val) {
            if (is_numeric($key)){ //rows
            
            }
            else {
                if ($key =='exito'){
                    $this->Exito = $val;

                }

                if ($key =='embed'){
                    $this->IframeSRC = $val;
                }

                if ($key =='msg'){
                    $this->Respuesta = $val;
                }

                if ($key =='urlfile'){
                    $this->urlFile = $val;
                }
            }
            
        }

        $this->html =   "<iframe src='".$this->IframeSRC."' id='iFramePlantilla' style='width: 100%; height: 100%;'>Cargando...</iframe>";


    }

    public function getURL(){
        return $this->Respuesta;        
    }
}

?>