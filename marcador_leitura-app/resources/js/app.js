import './bootstrap';

document.getElementById('searchForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Impede o envio tradicional do formulário
    const bookResultsDiv = document.getElementById('bookResults');
    const query = document.getElementById('searchInput').value; // Pega o valor digitado
    if(query.trim().length === 0){
        bookResultsDiv.innerHTML = '<p class="text-gray-500">Por favor digite o nome de um livro.</p>';
    }
    sendSearchRequest(query); // Chama a função para enviar a requisição
});

function sendSearchRequest(query) {
    const url = `/searchBook?q=${encodeURIComponent(query)}`; // Rota com query parameter
    const bookResultsDiv = document.getElementById('bookResults');
    const newUrl = url.replace(/%20/g, '+');


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
        addInformationsInView(bookResultsDiv,data)
    } else {
        bookResultsDiv.innerHTML = '<p class="text-gray-500">Nenhum livro encontrado.</p>';
    }
})
    .catch(error => {
        console.error('Erro:', error); // Exibe erros no console
    });
}

function addToReadingList(book) {
    fetch(addNewBookRoute, {  // Use a função de rota do Laravel para gerar a URL
        method: 'POST',  // Método da requisição
        headers: {
            'Content-Type': 'application/json',  // Tipo de conteúdo (JSON)
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  // Token CSRF
        },
        body: JSON.stringify(book)  // Dados que serão enviados - use 'book_id' ou ajuste conforme sua lógica no backend
    })
    .then(response => response.json())
    .then(data => {
        // Abre uma nova aba no navegador
        const newWindow = window.open('', '_blank'); // A segunda parte ('_blank') indica que será em uma nova aba
    
        // Verifica se a resposta contém dados
        if (data) {
            // Escreve os dados JSON na nova aba
            newWindow.document.write('<pre>' + JSON.stringify(data, null, 2) + '</pre>');
        } else {
            newWindow.document.write('<p>Nenhum dado encontrado.</p>');
        }
    });
    fetch(addBookToReadingListRoute, {  // Use a função de rota do Laravel para gerar a URL
        method: 'POST',  // Método da requisição
        headers: {
            'Content-Type': 'application/json',  // Tipo de conteúdo (JSON)
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  // Token CSRF
        },
        body: JSON.stringify(book)  // Dados que serão enviados - use 'book_id' ou ajuste conforme sua lógica no backend
    })
    .then(response => response.json())
    .then(data => {
        // Abre uma nova aba no navegador
        const newWindow = window.open('', '_blank'); // A segunda parte ('_blank') indica que será em uma nova aba
    
        // Verifica se a resposta contém dados
        if (data) {
            // Escreve os dados JSON na nova aba
            newWindow.document.write('<pre>' + JSON.stringify(data, null, 2) + '</pre>');
        } else {
            newWindow.document.write('<p>Nenhum dado encontrado.</p>');
        }
    });


}

function addToReadList(book) {
    // Aqui você pode fazer uma requisição AJAX para salvar no banco com Laravel
}
    
document.addEventListener("DOMContentLoaded", function () {
    let pageName = window.location.pathname.split("/").pop();
    if (pageName === "getBooksToRead") {
        const url = `/booksToRead`; // Rota com query parameter
        const bookResultsDiv = document.getElementById('bookResults');
    
    
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
            addInformationsInView(bookResultsDiv,data)
        } else {
            bookResultsDiv.innerHTML = '<p class="text-gray-500">Nenhum livro encontrado.</p>';
        }
    })
        .catch(error => {
            console.error('Erro:', error); // Exibe erros no console
        });
    }
});

function addInformationsInView(nameDiv, data){
            nameDiv.innerHTML = '';

        data.forEach(book => {
            const bookCard = document.createElement('div');
            bookCard.className = 'book-card bg-white p-4 rounded-lg shadow-md mb-4';
            // Título
            const title = document.createElement('h2');
            title.className = 'text-xl font-bold';
            title.textContent = book.title;
            bookCard.appendChild(title);
            // Autor(es)
            const authors = document.createElement('p');
            authors.className = 'text-gray-700';
            authors.innerHTML = `<strong>Autor(es):</strong> ${book.authors}`;
            bookCard.appendChild(authors);

            // Imagem do livro
            if (book.thumbnail !== 'Sem imagem') {
                const image = document.createElement('img');
                image.src = book.thumbnail;
                image.alt = `Capa do livro: ${book.title}`;
                image.className = 'mt-2 rounded';
                bookCard.appendChild(image);
            } else {
                const noImage = document.createElement('p');
                noImage.className = 'text-gray-500';
                noImage.textContent = 'Sem imagem disponível';
                bookCard.appendChild(noImage);
            }

            // Botões de ação
            const buttonsDiv = document.createElement('div');
            buttonsDiv.className = 'mt-4 flex space-x-2';

            // Botão "Adicionar à lista de leitura"
            const addToReadingListBtn = document.createElement('button');
            addToReadingListBtn.className = 'bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-700';
            addToReadingListBtn.textContent = 'Adicionar à lista de leitura';
            addToReadingListBtn.onclick = () => addToReadingList(book);
            buttonsDiv.appendChild(addToReadingListBtn);

            // Botão "Adicionar à lista de lidos"
            const addToReadListBtn = document.createElement('button');
            addToReadListBtn.className = 'bg-green-500 text-black px-4 py-2 rounded hover:bg-green-700';
            addToReadListBtn.textContent = 'Adicionar à lista de lidos';
            addToReadListBtn.onclick = () => addToReadList(book);
            buttonsDiv.appendChild(addToReadListBtn);

            bookCard.appendChild(buttonsDiv);
            nameDiv.appendChild(bookCard);
        });

}