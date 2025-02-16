import './bootstrap';

document.getElementById('searchForm').addEventListener('submit', function (e) {
    e.preventDefault(); 
    const bookResultsDiv = document.getElementById('bookResults');
    const query = document.getElementById('searchInput').value; 
    if(query.trim().length === 0){
        bookResultsDiv.innerHTML = '<p class="text-gray-500">Por favor digite o nome de um livro.</p>';
    }
    else{
        const url = `/searchBook?q=${encodeURIComponent(query)}`;
        sendGet(url,bookResultsDiv)
    }
});


function addToReadingList(book) {
    sendPost(addNewBookRoute,book);
    sendPost(addBookToReadingListRoute, book);
}

function addToReadList(book) {
    sendPost(addNewBookRoute, book);
    sendPost(addBookToReadListRoute, book);
}

function removeBookFromReadList(book){
    var url = "http://localhost:8000/removeBookReadList"
    sendPost(url, book);
}

function removeBookFromReadingList(book){
    var url = "http://localhost:8000/removeBookReadingList"
    sendPost(url, book);
}
    
document.addEventListener("DOMContentLoaded", function () {
    let pageName = window.location.pathname.split("/").pop();
    if (pageName === "getBooksToRead") {
        const url = `/booksToRead`; // Rota com query parameter
        const bookResultsDiv = document.getElementById('bookResults');
        sendGet(url, bookResultsDiv)
    }
});

document.addEventListener("DOMContentLoaded", function () {
    let pageName = window.location.pathname.split("/").pop();
    if (pageName === "getBooksRead") {
        const url = `/booksRead`; // Rota com query parameter
        const bookResultsDiv = document.getElementById('bookResults');
        sendGet(url, bookResultsDiv)
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

        // Primeiro botão da tela
        const firstButton = document.createElement('button');
        firstButton.className = 'bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-700';
         // Botão "Adicionar à lista de lidos"
        const secondButton = document.createElement('button');
        secondButton.className = 'bg-green-500 text-black px-4 py-2 rounded hover:bg-green-700';

        let pageName = window.location.pathname.split("/").pop();
        if(pageName ==="dashboard"){
            firstButton.textContent = 'Adicionar à lista de leitura';
            firstButton.onclick = () => addToReadingList(book);
            secondButton.textContent = 'Adicionar à lista de lidos';
            secondButton.onclick = () => addToReadList(book);
        }
        else if (pageName === "getBooksToRead"){
            firstButton.textContent = 'Mover para a lista de Lidos';
            firstButton.onclick = () => addToReadList(book);
            secondButton.textContent = 'Remover da lista';
            secondButton.onclick = () => removeBookFromReadingList(book);
        }
        else{
            firstButton.textContent = 'Mover para a lista de Livros para ler';
            firstButton.onclick = () => addToReadList(book);
            secondButton.textContent = 'Remover da lista';
            secondButton.onclick = () => removeBookFromReadList(book);
        }

        buttonsDiv.appendChild(firstButton);
        buttonsDiv.appendChild(secondButton);

         bookCard.appendChild(buttonsDiv);
        nameDiv.appendChild(bookCard);
    });

}

function sendGet(url,div){
    fetch(url, {
        method: 'GET', 
        headers: {
            'Accept': 'application/json', 
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.statusText);
        }
        return response.json(); 
    })
    .then(data => {
        if (data.length > 0) {
            addInformationsInView(div,data)
        } else {
            div.innerHTML = '<p class="text-gray-500">Nenhum livro encontrado.</p>';
        }
    })
        .catch(error => {
            console.error('Erro:', error); 
        });
}

function sendPost(route, book){
    fetch(route, {  
        method: 'POST',  
        headers: {
            'Content-Type': 'application/json', 
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  
        },
        body: JSON.stringify(book) 
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.statusText);
        }
        return response.json(); 
    })
    .then(data => {
        if (data.length > 0) {
            //addInformationsInView(div,data)
            const jsonString = JSON.stringify(data, null, 2);

            // Cria um Blob a partir da string JSON
            const blob = new Blob([jsonString], { type: 'application/json' });
        
            // Cria uma URL para o Blob
            const url = URL.createObjectURL(blob);
        
            // Abre a URL em uma nova guia
            window.open(url, '_blank');
        } else {
            div.innerHTML = '<p class="text-gray-500">Nenhum livro encontrado.</p>';
        }
    })
        .catch(error => {
            console.error('Erro:', error); 
        });
}
