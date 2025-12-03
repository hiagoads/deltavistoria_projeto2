<?php
require_once '../includes/menu.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nossos Serviços - Delta Vistoria</title>
    <link rel="stylesheet" href="../css/servicos.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Hero Section -->
    <section class="servicos-hero">
        <div class="hero-container">
            <h1 class="hero-title">Nossos Serviços</h1>
            <p class="hero-subtitle">Soluções completas em vistorias com precisão, agilidade e confiabilidade</p>
        </div>
    </section>

    <!-- Serviços Principais -->
    <section class="servicos-principais">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Serviços Especializados</h2>
                <p class="section-description">Oferecemos uma gama completa de serviços de vistoria para atender suas necessidades</p>
            </div>

            <div class="servicos-grid">
                <!-- Vistoria Veicular -->
                <div class="servico-card">
                    <div class="servico-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3 class="servico-title">Vistoria Veicular</h3>
                    <ul class="servico-lista">
                        <li><i class="fas fa-check"></i> Vistoria cautelar para compra e venda</li>
                        <li><i class="fas fa-check"></i> Laudo de sinistro</li>
                        <li><i class="fas fa-check"></i> Vistoria para financiamento</li>
                        <li><i class="fas fa-check"></i> Verificação de histórico</li>
                        <li><i class="fas fa-check"></i> Avaliação de danos</li>
                    </ul>
                    <div class="servico-footer">
                        <span class="tempo"><i class="far fa-clock"></i> 30-60 minutos</span>
                        <a href="../public/agendamento.php" class="btn-solicitar">Solicitar Vistoria</a>
                    </div>
                </div>

                <!-- Vistoria Imobiliária -->
                <div class="servico-card">
                    <div class="servico-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3 class="servico-title">Vistoria Imobiliária</h3>
                    <ul class="servico-lista">
                        <li><i class="fas fa-check"></i> Vistoria pré-locação</li>
                        <li><i class="fas fa-check"></i> Vistoria de entrega de obra</li>
                        <li><i class="fas fa-check"></i> Laudo de condições</li>
                        <li><i class="fas fa-check"></i> Verificação de infraestrutura</li>
                        <li><i class="fas fa-check"></i> Documentação fotográfica</li>
                    </ul>
                    <div class="servico-footer">
                        <span class="tempo"><i class="far fa-clock"></i> 1-2 horas</span>
                        <a href="../public/agendamento.php" class="btn-solicitar">Solicitar Vistoria</a>
                    </div>
                </div>

                <!-- Vistoria para Seguro -->
                <div class="servico-card">
                    <div class="servico-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="servico-title">Vistoria para Seguro</h3>
                    <ul class="servico-lista">
                        <li><i class="fas fa-check"></i> Vistoria pré-apólice</li>
                        <li><i class="fas fa-check"></i> Laudo para sinistro</li>
                        <li><i class="fas fa-check"></i> Avaliação de risco</li>
                        <li><i class="fas fa-check"></i> Documentação para seguradoras</li>
                        <li><i class="fas fa-check"></i> Perícia técnica</li>
                    </ul>
                    <div class="servico-footer">
                        <span class="tempo"><i class="far fa-clock"></i> 45-90 minutos</span>
                        <a href="../public/agendamento.php" class="btn-solicitar">Solicitar Vistoria</a>
                    </div>
                </div>

                <!-- Vistoria Táxi/App -->
                <div class="servico-card">
                    <div class="servico-icon">
                        <i class="fas fa-taxi"></i>
                    </div>
                    <h3 class="servico-title">Vistoria Táxi/App</h3>
                    <ul class="servico-lista">
                        <li><i class="fas fa-check"></i> Vistoria para aplicativos</li>
                        <li><i class="fas fa-check"></i> Renovação de licença</li>
                        <li><i class="fas fa-check"></i> Verificação de requisitos</li>
                        <li><i class="fas fa-check"></i> Documentação obrigatória</li>
                        <li><i class="fas fa-check"></i> Laudo para prefeituras</li>
                    </ul>
                    <div class="servico-footer">
                        <span class="tempo"><i class="far fa-clock"></i> 30-45 minutos</span>
                        <a href="../public/agendamento.php" class="btn-solicitar">Solicitar Vistoria</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Processo de Trabalho -->
    <section class="processo-trabalho">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Como Funciona</h2>
                <p class="section-description">Nosso processo simples e eficiente</p>
            </div>

            <div class="processo-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Solicitação</h3>
                    <p class="step-description">Entre em contato ou agende online informando o tipo de vistoria necessária</p>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Agendamento</h3>
                    <p class="step-description">Definimos data, horário e local para realização da vistoria</p>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Vistoria</h3>
                    <p class="step-description">Nossos especialistas realizam a análise técnica completa no local combinado</p>
                </div>

                <div class="step">
                    <div class="step-number">4</div>
                    <h3 class="step-title">Laudo</h3>
                    <p class="step-description">Emissão do laudo técnico detalhado com validade legal</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefícios -->
    <section class="beneficios">
        <div class="container">
            <div class="beneficios-content">
                <div class="beneficios-text">
                    <h2 class="beneficios-title">Por que escolher a Delta Vistoria?</h2>
                    <ul class="beneficios-lista">
                        <li><i class="fas fa-bolt"></i> <strong>Agilidade:</strong> Processos rápidos e eficientes</li>
                        <li><i class="fas fa-gavel"></i> <strong>Legalidade:</strong> Totalmente dentro das normas</li>
                        <li><i class="fas fa-headset"></i> <strong>Suporte:</strong> Atendimento personalizado</li>
                        <li><i class="fas fa-user-tie"></i> <strong>Especialistas:</strong> Profissionais certificados</li>
                        <li><i class="fas fa-file-contract"></i> <strong>Documentação:</strong> Laudos com validade jurídica</li>
                        <li><i class="fas fa-map-marker-alt"></i> <strong>Atendimento:</strong> Realizamos vistorias em todo o estado</li>
                    </ul>
                </div>
                <div class="beneficios-image">
                    <div class="image-placeholder">
                        <i class="fas fa-clipboard-check"></i>
                        <p>Vistorias Profissionais</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Pronto para solicitar sua vistoria?</h2>
            <p class="cta-text">Entre em contato agora mesmo e garanta um serviço de qualidade</p>
            <div class="cta-buttons">
                <a href="../public/agendamento.php" class="btn-cta-primary">
                    <i class="fas fa-calendar-check"></i> Agendar Vistoria
                </a>
                <a href="../public/contato.php" class="btn-cta-secondary">
                    <i class="fas fa-phone-alt"></i> Falar com Especialista
                </a>
            </div>
        </div>
    </section>

    <?php
    require_once '../includes/rodape.php';
    ?>

    <script src="../js/servicos.js"></script>
</body>
</html>