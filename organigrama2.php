<!DOCTYPE html>
<html>
<head>
  <title>ORGANIGRAMA ITAVU</title>

  <meta charset="utf-8" />
  <link rel="stylesheet" href="../lib/css_estructura.css" /> 
  <link rel="stylesheet" href="../lib/css_color.css" /> 
  <style>


*{
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  position: relative;
}
 

.cf:before,
.cf:after {
    content: " "; /* 1 */
    display: table; /* 2 */
}

.cf:after {
    clear: both;
}

.cf {
    *zoom: 1;
}



.content{
  width: 100%;
  max-width: 1142px;
  margin: 0 auto;
  padding: 0 20px;
}


@media all and (max-width: 767px){
  .content{
    padding: 0 20px;
  } 
}

ul{
  padding: 0;
  margin: 0;
  list-style: none;   
}

ul a{
  font-family: "Light";
  display: block;
  background: #484848;
  border: 4px solid #484848;
  text-align: center;
  overflow: hidden;
  font-size: 10pt;
  text-decoration: none;
  color: white;
  height: 70px;
  margin-bottom: -26px;
 
  -webkit-transition: all linear .1s;
  -moz-transition: all linear .1s;
  transition: all linear .1s;
}


@media all and (max-width: 767px){
  ul a{
    font-size: 1em;
  }
}


ul a span{
  top: 50%;
  margin-top: -0.7em;
  display: block;
}

/*
 
 */

.administration > li > a{
  margin-bottom: 25px;
}

.director > li > a{
  width: 50%;
  margin: 0 auto 0px auto;
}

.subdirector:after{
  content: "";
  display: block;
  width: 0;
  height: 130px;
  background: #484848;
  border-left: 4px solid #484848;
  left: 45.45%;
  position: relative;
}

.subdirector,
.departments{
  position: absolute;
  width: 100%;
}

.subdirector > li:first-child,
.departments > li:first-child{  
  width: 18.59894921190893%;
  height: 64px;
  margin: 0 auto 92px auto;   
  padding-top: 25px;
  border-bottom: 4px solid #484848;
  z-index: 1; 
}

.subdirector > li:first-child{
  float: right;
  right: 27.2%;
  border-left: 4px solid #484848;
}

.departments > li:first-child{  
  float: left;
  left: 27.2%;
  border-right: 4px solid #484848;  
}

.subdirector > li:first-child a,
.departments > li:first-child a{
  width: 100%;
}

.subdirector > li:first-child a{  
  left: 25px;
}

@media all and (max-width: 767px){
  .subdirector > li:first-child,
  .departments > li:first-child{
    width: 40%; 
  }

  .subdirector > li:first-child{
    right: 10%;
    margin-right: 2px;
  }

  .subdirector:after{
    left: 49.8%;
  }

  .departments > li:first-child{
    left: 10%;
    margin-left: 2px;
  }
}


.departments > li:first-child a{
  right: 25px;
}

.department:first-child,
.departments li:nth-child(2){
  margin-left: 0;
  clear: left;  
}

.departments:after{
  content: "";
  display: block;
  position: absolute;
  width: 81.1%;
  height: 22px; 
  border-top: 4px solid #484848;
  border-right: 4px solid #484848;
  border-left: 4px solid #484848;
  margin: 0 auto;
  top: 130px;
  left: 9.1%
}

@media all and (max-width: 767px){
  .departments:after{
    border-right: none;
    left: 0;
    width: 49.8%;
  }  
}

@media all and (min-width: 768px){
  .department:first-child:before,
   .department:last-child:before{
    border:none;
  }
}

.department:before{
  content: "";
  display: block;
  position: absolute;
  width: 0;
  height: 22px;
  border-left: 4px solid #484848;
  z-index: 1;
  top: -22px;
  left: 50%;
  margin-left: -4px;
}

.department{
  border-left: 4px solid #484848;
  width: 18.59894921190893%;
  float: left;
  margin-left: 1.751313485113835%;
  margin-bottom: 60px;
}

.lt-ie8 .department{
  width: 18.25%;
}

@media all and (max-width: 767px){
  .department{
    float: none;
    width: 100%;
    margin-left: 0;
  }

  .department:before{
    content: "";
    display: block;
    position: absolute;
    width: 0;
    height: 60px;
    border-left: 4px solid #484848;
    z-index: 1;
    top: -60px;
    left: 0%;
    margin-left: -4px;
  }

  .department:nth-child(2):before{
    display: none;
  }
}

.department > a{
  margin: 0 0 -26px -4px;
  z-index: 1;
}

.department > a:hover{  
 
}

.department > ul{
  margin-top: 0px;
  margin-bottom: 0px;
}

.department li{ 
  padding-left: 25px;
  border-bottom: 4px solid #484848;
  height: 80px; 
}

.department li a{
  background: red;
  top: 48px;  
  position: absolute;
  z-index: 1;
  width: 90%;
  height: 60px;
  vertical-align: middle;
  right: -4px;
}
.department li a:hover{
 
}

/* Department/ section colors */
.department.dep-a a{ background: #484848; }
.department.dep-b a{ background:#484848;}
.department.dep-c a{ background: #484848; }
.department.dep-d a{ background:#484848; }
.department.dep-e a{ background:#484848; }
  </style>
</head>
<body>

</body>
</html>
<div class="content">
  <h1>ORGANIGRAMA ITAVU</h1>
 



 <figure class="org-chart cf">
    <ul class="administration">
      <li>          
        <ul class="director">
          <li>
            <a href="#"><span>CONSEJO</span></a>
            <!-- 
            <ul class="subdirector">
              <li><a href="#"><span>Assistante Director</span></a></li>
            </ul> 
            -->
            <ul class="departments cf">               
              <li><a href="#"><span>Direccion General</span></a></li>
              
              <li class="department dep-a">
                <a href="#"><span>Department A</span></a>
                <ul class="sections">
                  <li class="section"><a href="#"><span>Section A1</span></a></li>
                  <li class="section"><a href="#"><span>Section A2</span></a></li>
                  <li class="section"><a href="#"><span>Section A3</span></a></li>
                  <li class="section"><a href="#"><span>Section A4</span></a></li>
                  <li class="section"><a href="#"><span>Section A5</span></a></li>
                </ul>
              </li>
              <li class="department dep-b">
                <a href="#"><span>Department B</span></a>
                <ul class="sections">
                  <li class="section"><a href="#"><span>Section B1</span></a></li>
                  <li class="section"><a href="#"><span>Section B2</span></a></li>
                  <li class="section"><a href="#"><span>Section B3</span></a></li>
                  <li class="section"><a href="#"><span>Section B4</span></a></li>
                </ul>
              </li>
              <li class="department dep-c">
                <a href="#"><span>Department C</span></a>
                <ul class="sections">
                  <li class="section"><a href="#"><span>Section C1</span></a></li>
                  <li class="section"><a href="#"><span>Section C2</span></a></li>
                  <li class="section"><a href="#"><span>Section C3</span></a></li>
                  <li class="section"><a href="#"><span>Section C4</span></a></li>
                </ul>
              </li>
              <li class="department dep-d">
                <a href="#"><span>Department D</span></a>
                <ul class="sections">
                  <li class="section"><a href="#"><span>Section D1</span></a></li>
                  <li class="section"><a href="#"><span>Section D2</span></a></li>
                  <li class="section"><a href="#"><span>Section D3</span></a></li>
                  <li class="section"><a href="#"><span>Section D4</span></a></li>
                  <li class="section"><a href="#"><span>Section D5</span></a></li>
                  <li class="section"><a href="#"><span>Section D6</span></a></li>
                </ul>
              </li>
              <li class="department dep-e">
                <a href="#"><span>Department E</span></a>
                <ul class="sections">
                  <li class="section"><a href="#"><span>Section E1</span></a></li>
                  <li class="section"><a href="#"><span>Section E2</span></a></li>
                  <li class="section"><a href="#"><span>Section E3</span></a></li>
                </ul>
              </li>
              <li class="department dep-e">
                <a href="#"><span>Department E</span></a>
                <ul class="sections">
                  <li class="section"><a href="#"><span>Section E1</span></a></li>
                  <li class="section"><a href="#"><span>Section E2</span></a></li>
                  <li class="section"><a href="#"><span>Section E3</span></a></li>
                </ul>
              </li>
            </ul>
          </li>
        </ul> 
      </li>
    </ul>     
  </figure>



</div>