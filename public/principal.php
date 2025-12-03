<?php
// Define caminho base para as imagens
$base_img = '/deltavistoria_projeto2/img/';
?>

</div>

<section class="carrossel">
    <div class="slides">
        <input type="radio" name="radio-btn" id="radio1" checked>
        <input type="radio" name="radio-btn" id="radio2">
        <input type="radio" name="radio-btn" id="radio3">

        <div class="slide slide1">
            <img src="<?php echo $base_img; ?>slide001.png" alt="slide1" />
            <div class="conteudo">
                <h2>Vistoria Profissional</h2>
                <p>Avaliação completa e detalhada do seu veículo</p>
            </div>
        </div>
        <div class="slide slide2">
            <img src="<?php echo $base_img; ?>slide002.png" alt="slide2" />
            <div class="conteudo">
                <h2>Experiência Garantida</h2>
                <p>Especialistas com anos de experiência no mercado</p>
            </div>
        </div>
        <div class="slide slide3">
            <img src="<?php echo $base_img; ?>slide003.png" alt="slide3" />
            <div class="conteudo">
                <h2>Agilidade e Segurança</h2>
                <p>Processos rápidos e totalmente confiáveis</p>
            </div>
        </div>
    </div>

    <div class="navegacao">
        <label for="radio1" class="nav-btn"></label>
        <label for="radio2" class="nav-btn"></label>
        <label for="radio3" class="nav-btn"></label>
    </div>
</section>

<section class="nossos-diferenciais">
    <div>
        <h2 class="titulo-diferenciais">NOSSOS DIFERENCIAIS</h2>
        <p class="paragrafo"><i>O que nos torna a melhor escolha para seus serviços automotivos</i></p>
    </div>
    <div class="cartoes-diferenciais">
        <div>
            <img src="<?php echo $base_img; ?>agi.png" alt="agilidade">
            <p>Processos rápidos e eficientes para não deixar você esperando</p>
        </div>
        <div>
            <img src="<?php echo $base_img; ?>seg.png" alt="seguranca">
            <p class="seg">Todos os processos realizados dentro da legalidade</p>
        </div>
        <div>
            <img src="<?php echo $base_img; ?>sup.png" alt="suporte">
            <p>Atendimento personalizado para tirar todas suas dúvidas</p>
        </div>
    </div>
</section>

<div class="container">