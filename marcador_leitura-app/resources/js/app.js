import './bootstrap';

document.getElementById('searchForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Impede o envio tradicional do formulário

    const query = document.getElementById('searchInput').value; // Pega o valor digitado
    sendSearchRequest(query); // Chama a função para enviar a requisição
});

function sendSearchRequest(query) {
    const url = `/searchBook?q=${encodeURIComponent(query)}`; // Rota com query parameter
    const bookResultsDiv = document.getElementById('bookResults');
    const newUrl = url.replace(/%20/g, '+');
    console.log(newUrl)

    fetch(url, {
        method: 'GET', // Método HTTP
        headers: {
            'Accept': 'application/json', // Define que você espera uma resposta JSON
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.statusText);
        }
        return response.json(); // Converte a resposta para JSON
    })
    .then(data => {
        if (data.length > 0) {
            // Cria os cartões dos livros
            bookResultsDiv.innerHTML = ''; // Limpa o "Carregando..."
            data.forEach(book => {
                const bookCard = document.createElement('div');
                bookCard.className = 'book-card bg-white p-4 rounded-lg shadow-md mb-4';

                const title = document.createElement('h2');
                title.className = 'text-xl font-bold';
                title.textContent = book.title;
                bookCard.appendChild(title);

                const authors = document.createElement('p');
                authors.className = 'text-gray-700';
                authors.innerHTML = `<strong>Autor(es):</strong> ${book.authors}`;
                bookCard.appendChild(authors);

                if (book.imagemLink !== 'Sem imagem') {
                    const image = document.createElement('img');
                    image.src = book.imagemLink;
                    image.alt = `Capa do livro: ${book.title}`;
                    image.className = 'mt-2 rounded';
                    bookCard.appendChild(image);
                } else {
                    const noImage = document.createElement('p');
                    noImage.className = 'text-gray-500';
                    noImage.textContent = 'Sem imagem disponível';
                    bookCard.appendChild(noImage);
                }

                bookResultsDiv.appendChild(bookCard);
            });
        } else {
            // Exibe uma mensagem se não houver resultados
            bookResultsDiv.innerHTML = '<p class="text-gray-500">Nenhum livro encontrado.</p>';
        }
    })
    .catch(error => {
        console.error('Erro:', error); // Exibe erros no console
    });
}