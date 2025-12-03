<?php require_once '../includes/menu.php'; ?>

<section class="form-map-container" id="informacoes">
    <div class="formulario">
        <h2 class="titulo-sugestao">Envie uma Mensagem</h2>
        <form action="obrigado.html" method="post" class="formulario-sugestao">
            <div class="form-flex">
                <div class="input-flex">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div class="input-flex">
                    <label for="telefone">Telefone:</label>
                    <input type="tel" id="telefone" name="telefone" required>
                </div>
            </div>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            <label for="mensagem">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" rows="5" required></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>

    <div>
        <h2 class="titulo-contatos">Informações de Contato</h2>
        <div class="contatos-container">
            <div class="contatos">
                <div class="contato-item">
                    <img class="imagem-contato" src="../img/local2.png" alt="Icone de localização">
                    <div class="texto-contato">
                        <h3>Endereço</h3>
                        <p>Rua Exemplo, 125 - Centro</p>
                        <p>Pedras de Fogo - PB</p>
                    </div>
                </div>
                <div class="contato-item">
                    <img class="imagem-contato" src="../img/telefone.png" alt="Icone de telefone">
                    <div class="texto-contato">
                        <h3>Telefone</h3>
                        <p>(83) 1234-5678</p>
                    </div>
                </div>
                <div class="contato-item">
                    <img class="imagem-contato" src="../img/email2.png" alt="Icone de e-mail">
                    <div class="texto-contato">
                        <h3>E-mail</h3>
                        <p>delta@contato.com.br</p>
                    </div>
                </div>
                <div class="contato-item">
                    <img class="imagem-contato" src="../img/relogio.png" alt="Icone de horário">
                    <div class="texto-contato">
                        <h3>Horário de Funcionamento</h3>
                        <p>Segunda a Sexta: 08:00 - 17:00<br>Sábado: 08:00 - 12:00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/rodape.php'; ?>
