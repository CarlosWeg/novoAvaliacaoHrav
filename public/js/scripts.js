let indicePerguntas = 0;

// Exibir a primeira pergunta quando a página carregar
document.addEventListener('DOMContentLoaded', () => {
    exibirPergunta(indicePerguntas);
});

function proxPergunta() {
    const perguntas = document.querySelectorAll('.pergunta');

    const perguntaAtual = perguntas[indicePerguntas];
    const radios = perguntaAtual.querySelectorAll('input[type="radio"]');
    const algumMarcado = Array.from(radios).some(radio => radio.checked);

    //Verifica se foi marcado algum radio para cada pergunta
    if (!algumMarcado) {
        alert("Por favor, responda a pergunta antes de prosseguir.");
        return;
    }

    // Exibe a próxima pergunta,se houver
    if (indicePerguntas < perguntas.length) {
        indicePerguntas++;
        exibirPergunta(indicePerguntas);
    }
}

// Exibir a pergunta correspondente
function exibirPergunta(cont){
    const perguntas = document.querySelectorAll('.pergunta');
    const feedbackDiv = document.querySelector('.feedback-container');

    perguntas.forEach(function(pergunta, index){
        if (index === cont){
            pergunta.style.display = 'block';
        } else {
            pergunta.style.display = 'none';
        }
    })

    if (cont === perguntas.length){
        perguntas.forEach(pergunta=>pergunta.style.display = 'none');
        feedbackDiv.style.display = 'block';

        // Alterar o texto do botão para "Finalizar"
        const botao = document.querySelector('button');
        botao.textContent = 'FINALIZAR';
        botao.setAttribute('onclick', 'finalizarFormulario()');
    }
}

//Altera a ação do botão da página formulário
function finalizarFormulario() {
    document.getElementById('formulario').submit();
}

//Recarregar pagina de agradecimento após 5 segundos /timer dinâmico na tela
//Exibir mensagem de erro ao usuário
window.onload = function(){
    if (document.getElementById('pagina-agradecimento')){
        let segundos = 5;
        const elementoTimer = document.getElementById('elementoTimer');
    
        const timer = setInterval(function(){
            segundos--;
            elementoTimer.textContent = segundos;
    
            if (segundos <= 0){
                clearInterval(timer);
                window.location.href = "formulario.php";
            }
        }, 1000);
    }

    const mensagem = document.getElementById("mensagemSistema");
    if (mensagem) {
        setTimeout(() => {
            mensagem.style.animation = "fadeSaida 0.3s ease";
            setTimeout(() => mensagem.remove(), 300);
        }, 5000);
    }
};