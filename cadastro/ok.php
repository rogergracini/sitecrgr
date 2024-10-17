<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="theme.css" type="text/css">
</head>

<body>








  <div class="py-5" style="	border-color: #ccc;	border-top-width: 1px;	border-bottom-width: 1px;">
    <div class="container">
      <!-- <div class="row">
        <div class="col-md-12 text-center"><a href="crgr.com.br"><img class="img-fluid d-block mx-auto" src="logo.png"></a></div>
      </div>-->
    </div>
  </div>
  <div class="py-3 text-center" style="background-color:#ae7e3d26;	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
    <div class="container">
      <div class="row">


        <div class="mx-auto p-4 col-lg-7">
<div class="col-md-12 text-center" style="
    font-size: 30px;
    color: #0ab123;
    font-weight: 400;
">






                   CADASTRO REALIZADO COM SUCESSO! EM BREVE ENTRAREMOS EM CONTATO.


</div>
</div>




<script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-143676173-1');

        function sendForm() {
            var now = new Date();
            now.getTime();
            var url_send_email = 'https://'+window.location.hostname+'/send_email.php';
            var nome = jQuery('#form_name').val();
            var email = jQuery('#form_email').val();
            var fone = jQuery('#form_phone').val();
            var ddd = jQuery('#form_ddd').val();
            var cnpj = jQuery('#cnpj').val();
            var assunto = 'Formulário desafio 21 dias do site - ' + now;
            var empresa = jQuery('#form_empresa').val();

            var content = `
                <br>Contato recebido pelo site<Br><br>
                Nome do lead: ${nome} <br>
                Email do lead: ${email} <br>
                Fone do lead: ${ddd} ${fone} <br>
                Cnpj: ${cnpj}<br>
                Empresa: ${empresa} <br>
            `;
            var data = {
                'assunto': assunto,
                'content': content
            };
            jQuery.post(url_send_email, data, function (ret) {
                if (ret == 'success') {
                    window.location.href = "/congrats";
                } else {
                    console.log("erro");
                }
            });
        }
    </script>




<br><br><br><br>


       <!-- <div class="mx-auto p-4 col-lg-7">
          <h1 class="mb-4">Já tem cadastro? Escolha abaixo o catálogo que deseja ter acesso:</h1>
                  <div class="col-md-12 text-center"><a href="https://crgr.com.br/galle/customer/account/login/">  <img class="img-fluid d-block mx-auto" src="logo-galle.jpg"></div>
        </div>-->
      </div>
    </div>
  </div>


<!--   
  <div class="py-5 text-center" style="	background-size: 100%;	background-position: top left;	background-repeat: repeat;	background-color: #cccccc73;">
    <div class="container">
      <div class="row">
        <div class="mx-auto col-md-6 col-10 bg-white p-5">
          <h1 class="mb-4">Já tem cadastro? Clique em entrar.</h1>
          <form>
            <button type="submit" class="btn btn-primary">Entrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
-->







  <!-- <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="carousel slide" data-ride="carousel" id="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active carousel-item-left"> <img class="d-block img-fluid w-100" src="slide1.jpg">
              </div>
              <div class="carousel-item carousel-item-next carousel-item-left"> <img class="d-block img-fluid w-100" src="slide1.jpg">
              </div>
              <div class="carousel-item"> <img class="d-block img-fluid w-100" src="slide2.jpg">
              </div>
            </div> <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carousel" role="button" data-slide="next"> <span class="carousel-control-next-icon"></span> <span class="sr-only">Next</span> </a>
          </div>
        </div>
      </div>
    </div>
  </div>-->








  <!-- <div class="py-3" style="	background-color: #cccccc73;	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-6 p-3"> <img class="img-fluid d-block" src="logo.png"> </div>
        <div class="col-lg-4 col-6 p-3">
          <p contenteditable="true">Av Dr. Lauro Correa da Silva, 3233</p>
          <p>WhatsApp: (22) 99251-7315</p>
          <p class="mb-0">contato@crgr.com.br</p>
        </div>
        <div class="col-md-4 p-3">
          <h5> <b>Sobre nós</b></h5>
          <p class="mb-0"> Breve texto sobre a empresa</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <p class="mb-0 mt-2">© 2021 CRGR Todos os direitos reservados.</p>
        </div>
      </div>
    </div>
  </div>-->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>