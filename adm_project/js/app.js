document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    const errorMessage = document.getElementById('errorMessage');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Usuário e senha fixos para exemplo (não recomendado para produção)
        const validUsername = 'admin';
        const validPassword = 'password';

        if (username === validUsername && password === validPassword) {
            // Define uma variável de sessão simulada
            localStorage.setItem('authenticated', 'true');
            // Redireciona para a página principal
            window.location.href = 'index.php';
        } else {
            // Mostra mensagem de erro
            errorMessage.textContent = 'Usuário ou senha inválidos!';
        }
    });
});
