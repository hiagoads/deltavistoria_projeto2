<div id="adminModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-left"></div>

        <div class="modal-right">
            <span class="close-btn">&times;</span>
            <h2>Login Admin</h2>
            
            <form action="validar_login.php" method="POST">
                <label for="user">Usuário</label>
                <input type="text" id="user" name="username" placeholder="Usuário" required>

                <label for="pass">Senha</label>
                <input type="password" id="pass" name="password" placeholder="Senha" required>

                <button type="submit" class="btn-submit">Entrar</button>
            </form>
        </div>
    </div>
</div>
