let indicePerguntas = 0;

// Exibir a primeira pergunta quando a página carregar
document.addEventListener('DOMContentLoaded', () => {
    exibirPergunta(indicePerguntas);
});

//Verificar se ainda há perguntas para serem exibidas
function proxPergunta(){
    const perguntas = document.querySelectorAll('.pergunta');

    if (indicePerguntas<perguntas.length){
        indicePerguntas++;
        exibirPergunta(indicePerguntas);//Após ser constatado que há perguntas pendentes, é chamada a próxima função
    }
}

// Exibir a pergunta correspondente
function exibirPergunta(cont){
    const perguntas = document.querySelectorAll('.pergunta');
    const feedbackDiv = document.querySelector('.feedback');

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
        botao.textContent = 'Finalizar';
        botao.setAttribute('onclick', 'finalizarFormulario()');
    }
}

//Altera a ação do botão da página formulário
function finalizarFormulario() {
    document.getElementById('formulario').submit();
    window.location.href="obrigado.php";
}

//Recarregar pagina de agradecimento após 5 segundos
window.onload = function(){
    if (document.getElementById('pagina-agradecimento')){
        setTimeout(()=>{
            window.location.href="formulario.php";
        },5000);
    }
}