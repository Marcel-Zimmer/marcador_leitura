import './bootstrap';
import {toastr} from 'toastr';
window.toastr = toastr;


//listenet do botão procurar livros 
document.getElementById('searchForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const bookResultsDiv = document.getElementById('bookResults');
    const query = document.getElementById('searchInput').value; 

    if(query.trim().length !== 0){
        const url = `/searchBook?q=${encodeURIComponent(query)}`;
        let listBooks = await sendGet(url);
        addInformationsInView(bookResultsDiv,listBooks.data)        
    }

    else{
        bookResultsDiv.innerHTML = '<p class="text-gray-500">Por favor digite o nome de um livro.</p>';
    }
    
});


function addToReadingList(book) {
    const url = "http://localhost:8000/markBookToReadingList"
    console.log(book)
    const respost = sendPost(url,book);
    console.log(respost)
    if(respost.success){
        window.dispatchEvent(new CustomEvent('toast', {
        detail: {
            message: 'Livro adicionado a Lista de leitura',
            type: 'success'
            }
        }));
    }

}

function addToReadList(book) {
    const url = "http://localhost:8000/markBookToReadList"
    const respost = sendPost(url, book);

    if(refreshPageBooksToRead.success) sendPost(addBookToReadListRoute, book);
}

function updateBookStatusToRead(book){
    var url = "http://localhost:8000/updateBookStatusToRead"
    sendPost(url, book);
    removeBookFromReadingView(book);
}

function updateBookStatusToReading(book){
    var url = "http://localhost:8000/updateBookStatusToReading"
    sendPost(url, book);
    removeBookFromReadView(book);
    
}

function removeBookFromReadList(book){
    var url = "http://localhost:8000/removeBookReadList"
    sendPost(url, book);
    removeBookFromReadView(book);
}

function removeBookFromReadingList(book){
    var url = "http://localhost:8000/removeBookReadingList"
    sendPost(url, book);
    removeBookFromReadingView(book);
    
}

function removeBookFromReadView(book){
    let div = document.getElementById(book.idBook)
    if(div){
        div.remove()
    }
}

function removeBookFromReadingView(book){
    let div = document.getElementById(book.idBook)
    if(div){
        div.remove()
    }
}

function refreshPageBooksToRead(){
    const url = `/booksToRead`; // Rota com query parameter
    const bookResultsDiv = document.getElementById('bookResults');
    sendGet(url, bookResultsDiv)

}

function refreshPageBooksRead(){
    const url = `/booksRead`; // Rota com query parameter
    const bookResultsDiv = document.getElementById('bookResults');
    sendGet(url, bookResultsDiv)   
}
    
document.addEventListener("DOMContentLoaded", function () {
    let pageName = window.location.pathname.split("/").pop();
    if (pageName === "getBooksToRead") {
        refreshPageBooksToRead();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    let pageName = window.location.pathname.split("/").pop();
    if (pageName === "getBooksRead") {
        refreshPageBooksRead();
    }
});


function addInformationsInView(nameDiv, data){
    nameDiv.innerHTML = '';
    data.forEach(book => {
        const bookCard = document.createElement('div');
        bookCard.id = book.idBook;
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
            firstButton.onclick = () => updateBookStatusToRead(book);
            secondButton.textContent = 'Remover da lista';
            secondButton.onclick = () => removeBookFromReadingList(book);
        }
        else{
            firstButton.textContent = 'Mover para a lista de Livros para ler';
            firstButton.onclick = () => updateBookStatusToReading(book);
            secondButton.textContent = 'Remover da lista';
            secondButton.onclick = () => removeBookFromReadList(book);
        }

        buttonsDiv.appendChild(firstButton);
        buttonsDiv.appendChild(secondButton);

         bookCard.appendChild(buttonsDiv);
        nameDiv.appendChild(bookCard);
    });

}

async function sendGet(url) {
    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        });
        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.statusText);
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erro:', error);
    }
}

async function sendPost(route, book){
    try{
        const response = await fetch(route, {  
                         method: 'POST',  
                         headers: {
                            'Content-Type': 'application/json', 
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  
                        },
                        body: JSON.stringify(book) 
                    });
        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.statusText);
        }     
        const data = await response.json();
        return data;                       
    }catch(error){
        console.log(error)
    }

}

