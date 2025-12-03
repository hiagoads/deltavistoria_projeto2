<?php

// Se estiver sendo acessado diretamente, redireciona para o index.php com a âncora
if (basename($_SERVER['PHP_SELF']) == 'principal.php' && !isset($no_redirect)) {
    // Redireciona para index.php com a seção
    $anchor = isset($_GET['section']) ? '#quem-somos' : '';
    header('Location: index.php?pg=principal' . $anchor);
    exit();
}

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

<!-- Seção Quem Somos - Versão Simples -->
<section class="quem-somos-simples" id="quem-somos">
    <div class="container-quem-somos">
        <h2 class="titulo-quem-somos">QUEM SOMOS</h2>
        <p class="subtitulo-quem-somos">Delta Vistoria - Tradição e Confiança na Região Metropolitana de João Pessoa</p>
        
        <div class="historia-empresa">
            <p>A <strong>Delta Vistoria</strong> nasceu da necessidade de oferecer serviços de vistoria veicular com transparência, agilidade e qualidade superior na região metropolitana de João Pessoa. Com anos de experiência no mercado, construímos uma reputação sólida baseada na confiança de nossos clientes.</p>
            
            <p>Nossa equipe é composta por <strong>profissionais especializados e certificados</strong>, com amplo conhecimento técnico e legal para realizar vistorias completas e detalhadas. Cada membro da nossa equipe passa por constante capacitação para estar atualizado com as normas e regulamentações do setor.</p>
        </div>
        
        <div class="nossos-servicos">
            <h3>Nossos Serviços</h3>
            <div class="servicos-container">
                <div class="servico-item">
                    <div class="servico-icone">🚗</div>
                    <h4>Vistoria Veicular</h4>
                    <p>Avaliação completa do estado do veículo para compra, venda ou renovação de documentação.</p>
                </div>
                
                <div class="servico-item">
                    <div class="servico-icone">🛡️</div>
                    <h4>Vistoria Cautelar</h4>
                    <p>Inspeção detalhada para verificar a situação legal e física do veículo com laudo completo.</p>
                </div>
                
                <div class="servico-item">
                    <div class="servico-icone">📄</div>
                    <h4>Transferência de Propriedade</h4>
                    <p>Assistência completa no processo de transferência, garantindo toda a documentação necessária.</p>
                </div>
            </div>
        </div>
        
        <div class="nossos-valores">
            <h3>Nossos Valores</h3>
            <div class="valores-container">
                <div class="valor-item">
                    <div class="valor-marca">•</div>
                    <div class="valor-texto">
                        <h4>Transparência</h4>
                        <p>Processos claros e informações honestas em todas as etapas</p>
                    </div>
                </div>
                
                <div class="valor-item">
                    <div class="valor-marca">•</div>
                    <div class="valor-texto">
                        <h4>Legalidade</h4>
                        <p>Total conformidade com a legislação vigente</p>
                    </div>
                </div>
                
                <div class="valor-item">
                    <div class="valor-marca">•</div>
                    <div class="valor-texto">
                        <h4>Comprometimento</h4>
                        <p>Dedicação total à satisfação do cliente</p>
                    </div>
                </div>
                
                <div class="valor-item">
                    <div class="valor-marca">•</div>
                    <div class="valor-texto">
                        <h4>Agilidade</h4>
                        <p>Rapidez sem comprometer a qualidade do serviço</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="missao-visao-container">
            <div class="missao">
                <h3>Nossa Missão</h3>
                <p>Oferecer serviços de vistoria com excelência técnica, garantindo segurança jurídica e satisfação total aos nossos clientes.</p>
            </div>
            
            <div class="visao">
                <h3>Nossa Visão</h3>
                <p>Ser a empresa referência em serviços de vistoria na região metropolitana de João Pessoa, reconhecida pela qualidade e confiabilidade.</p>
            </div>
        </div>
        
        <div class="chamada-acao">
            <p>Estamos prontos para atender você com a mesma dedicação e profissionalismo que nos tornaram referência no mercado.</p>
            <a href="agendamento.php" class="botao-agendar">Agende sua vistoria!</a>
        </div>
    </div>
</section>

<div class="container">