<html>
<head>
  <title>GitHub.com/BreakXD</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.11/css/mdb.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="style">
  <style type="text/css">
    
    .wrapper { 
  height: 100%;
  width: 100%;
  left:0;
  right: 0;
  top: 0;
  bottom: 0;
  position: absolute;
background: linear-gradient(124deg, #1e1e1e, #0c0c0c, #1e1e1e, #0c0c0c, #1e1e1e, #0c0c0c, #1e1e1e, #0c0c0c);
background-size: 1800% 1800%;

-webkit-animation: rainbow 18s ease infinite;
-z-animation: rainbow 18s ease infinite;
-o-animation: rainbow 18s ease infinite;
  animation: rainbow 18s ease infinite;}

@-webkit-keyframes rainbow {
    0%{background-position:0% 82%}
    50%{background-position:100% 19%}
    100%{background-position:0% 82%}
}
@-moz-keyframes rainbow {
    0%{background-position:0% 82%}
    50%{background-position:100% 19%}
    100%{background-position:0% 82%}
}
@-o-keyframes rainbow {
    0%{background-position:0% 82%}
    50%{background-position:100% 19%}
    100%{background-position:0% 82%}
}
@keyframes rainbow { 
    0%{background-position:0% 82%}
    50%{background-position:100% 19%}
    100%{background-position:0% 82%}
}

.fff {
  animation: color-change 1s infinite;
}

@keyframes color-change {
  100% { color: green; }
  50% { color: blue; }
  100% { color: red; }
}


  </style>
</head>

<body class="wrapper">
  <br>
    <div class="row col-md-12">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class="card col-sm-8">
  <h3 class="card-body h6"><center class="" style="font-family: 'Arial', 'Courier New', serif;"><b>Checker League of Legends</b></center></h3>
  <div class="">      
<div class="md-form">
  <div class="col-md-12">
  <textarea type="text" style="text-align: center; font-family: 'Arial', 'Courier New', serif;" id="lista" class="md-textarea form-control" rows="1" placeholder="Coloque sua lista de contas"></textarea>
</div>
</div>
  
  <center>
  <input rows="0" type="password" placeholder="Chave de acesso" class="form-control" id="authkey" style="resize: none; outline: 0; text-align: center; width: 30%;"></input>
  </center><br>

<center>
 <button class="btn btn-primary" style="width: 200px; outline: none;" id="testar" onclick="enviar()" >TESTAR</button>
  <button class="btn btn-danger" style="width: 200px; outline: none;">PARAR</button>
</center><br>
  </div>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class="card col-sm" style="height: 350px">
  
  <div class="card-body">
    <span><b>Checkando: </b></span><span class="badge badge-secondary" id="status">Aguardando conta.</span>
<div class="md-form1">
  <span><b>Aprovadas:</b></span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="cLive" class="badge badge-success">0</span><br>
  <span><b>Reprovadas:</b></span>&nbsp;&nbsp;<span id="cDie" class="badge badge-danger"> 0</span><br>
  <span><b>Testadas:</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="total" class="badge badge-info">0</span><br>
  <span><b>Carregadas:</b></span>&nbsp;&nbsp;&nbsp;<span id="carregadas" class="badge badge-dark">0</span><br>

  <hr>
  <span>
    <a style="font-size: 11px;" href="https://twitter.com/breakrank1"><b>Twitter</b></a>
    <a style="font-size: 11px;" href="https://github.com/BreakXD"><b>Github</b></a>
  </span>
  <hr>
  <center>
   <span><a style="font-size: 15px;"><b>Proxy</b></a></span><br>
    <div class="btn-group btn-group-toggle" data-toggle="buttons">

  <label class="btn btn-white active">
    <input type="radio" name="options" id="proxyoff" autocomplete="off" checked> Off </input>
  </label>
  <label class="btn btn-white">
    <input type="radio" name="options" id="proxyon" autocomplete="off"> On </input>
  </label>
</div>


</div>
  </div>
</div>
</div>
<br>

<div class="col-md-12">
<div class="card">
<div style="position: absolute;
        top: 0;
        right: 0;">

  <button type="button" class="btn btn-outline-success btn-sm" onclick="copiar_30_combo()">Copiar Combo</button>
  <button type="button" class="btn btn-outline-success btn-sm" onclick="copiar_30()">Copiar Tudo</button>
  <button id="mostra" class="btn btn-Success">MOSTRAR/OCULTAR</button>

</div>
  <div class="card-body">
    <h6 style="font-weight: bold;" class="card-title">APROVADAS NIVEL 30 + | <span  id="cLive2" class="badge badge-success">0</span> <br><br><hr> </h6>
    <div id="bode"><span id=".aprovadas" class="aprovadas"></span></span><span id=".aprovadascombo" class="aprovadascombo" style="display: none;"></span>
</div>
  </div>
</div>
</div>

<br><br>

<div class="col-md-12">
<div class="card">
<div style="position: absolute;
        top: 0;
        right: 0;">

  <button type="button" class="btn btn-outline-warning btn-sm" onclick="copiar_low_combo()">Copiar Combo</button>
  <button type="button" class="btn btn-outline-warning btn-sm" onclick="copiar_low()">Copiar Tudo</button>
  <button id="mostra3" class="btn btn-warning">MOSTRAR/OCULTAR</button>

</div>
  <div class="card-body">
    <h6 style="font-weight: bold;" class="card-title">APROVADAS NIVEL 30 -  | <span  id="cLive3" class="badge badge-warning">0</span> <br><br><hr> </h6>
    <div id="bode3"><span id=".aprovadaslow" class="aprovadaslow"></span><span id=".aprovadaslowcombo" class="aprovadaslowcombo" style="display: none;"></span>
</div>
  </div>
</div>
</div>



<br>
<br>
<div class="col-md-12">
<div class="card">
  <div style="position: absolute;
        top: 0;
        right: 0;">

  <button type="button" class="btn btn-outline-danger btn-sm" onclick="clear_acc()">Limpar</button>
  <button id="mostra2" class="btn btn-danger">MOSTRAR/OCULTAR</button>

</div>
  <div class="card-body">
    <h6 style="font-weight: bold;" class="card-title">Reprovadas - <span id="cDie2" class="badge badge-danger">0</span> <br><br><hr> </h6>
    <div id="bode2"><span id=".reprovadas" class="reprovadas"></span>
    </div>
  </div>
</div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>

<script type="text/javascript">
  function copiar_30() {
    var copyText = document.getElementById(".aprovadas");
    var textArea = document.createElement("textarea");
    textArea.value = copyText.textContent;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("Copy");
    textArea.remove();
}


  function copiar_low() {
    var copyText = document.getElementById(".aprovadaslow");
    var textArea = document.createElement("textarea");
    textArea.value = copyText.textContent;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("Copy");
    textArea.remove();
}
  function copiar_low_combo() {
    var copyText = document.getElementById(".aprovadaslowcombo");
    var textArea = document.createElement("textarea");
    textArea.value = copyText.textContent;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("Copy");
    textArea.remove();
}
  function copiar_30_combo() {
    var copyText = document.getElementById(".aprovadascombo");
    var textArea = document.createElement("textarea");
    textArea.value = copyText.textContent;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("Copy");
    textArea.remove();
}


  function proxyModeCheck(){
    if(document.getElementById("proxyoff").checked){
      return "off";
    }else if(document.getElementById("proxyon").checked){
      return "on";
    }
  }


  function clear_acc(){
    $('.reprovadas').html("");
    $('#cDie2').html('0');
    $('#cDie').html('0');
  }
</script>

<script type="text/javascript">

$(document).ready(function(){


    $("#bode").hide();
  $("#esconde").show();
  
  $('#mostra').click(function(){
  $("#bode").slideToggle();
  });

});

</script>

<script type="text/javascript">

$(document).ready(function(){


    $("#bode2").hide();
  $("#esconde2").show();
  
  $('#mostra2').click(function(){
  $("#bode2").slideToggle();
  });

});

</script>

<script type="text/javascript">

$(document).ready(function(){


    $("#bode3").hide();
  $("#esconde3").show();
  
  $('#mostra3').click(function(){
  $("#bode3").slideToggle();
  });

});

</script>



<script title="ajax do checker">

    function enviar() {
        var authchecker = $('#authkey').val();
        var linha = $("#lista").val();
        var linhaenviar = linha.split("\n");
        var total = 0;
        var ap = 0;
        var aplow = 0;  
        var rp = 0;
        var proxyuse = proxyModeCheck();

        if(proxyuse == "off"){
          $('#proxyuse').html('No');
          var velocidade = 5000;
          }else if(proxyuse == 'on'){
          $('#proxyuse').html('Yes');
          var velocidade = 500;
          }


        linhaenviar.forEach(function(value, index) {
          var [username, password] = value.split(":");

            setTimeout(
                function() {
                  total++;
                  $('#carregadas').html(total);
                  $('#status').html(value);
                    $.ajax({
                    url: 'http://localhost/checkerNew/LeagueChecker/api.php?user=' + username + '&pass=' + password,
                    type: 'GET',
                    async: true,
                    success: function(resultado) {
                      if (resultado.match(/🥇 SOLOQ/) == '🥇 SOLOQ') {
                        var conta = resultado;
                        removelinha();
                        ap++;
                        aprovadas(conta + "<br><br>");
                        aprovadascombo(value + "<br><br>");
                      } else if (resultado.match(/#breakcoder.org/) == "#breakcoder.org") {
                        var conta = resultado;
                        removelinha();
                        aplow++;
                        aprovadaslow(conta + "<br><br>");
                        aprovadaslowcombo(value + "<br><br>");
                      } else {
                        removelinha();
                        rp++;
                        reprovadas(resultado + "<br><br>");
                      }
                      var fila = parseInt(ap) + parseInt(rp) + parseInt(aplow);
                      $('#cLive').html(ap + aplow);
                      $('#cDie').html(rp);
                      $('#cDie2').html(rp);
                      $('#total').html(fila);
                      $('#cLive2').html(ap);
                      $('#cLive3').html(aplow);

                    }
                  });
              }, index * 2000); // TIME
      });
    }
    function aprovadas(str) {
        $(".aprovadas").append(str + "\n");
    }
    function aprovadaslow(str) {
        $(".aprovadaslow").append(str + "\n");
    }
    function aprovadascombo(str) {
        $(".aprovadascombo").append(str + "\n");
    }
    function aprovadaslowcombo(str) {
        $(".aprovadaslowcombo").append(str + "\n");
    }
    function reprovadas(str) {
        $(".reprovadas").append(str + "\n");
    }
    function removelinha() {
        var lines = $("#lista").val().split('\n');
        lines.splice(0, 1);
        $("#lista").val(lines.join("\n"));
    }
</script>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.11/js/mdb.min.js"></script>
</body>
<br>
<footer >


    <div class="footer-copyright text-center py-3">
   
    </div>


  </footer>



</html>