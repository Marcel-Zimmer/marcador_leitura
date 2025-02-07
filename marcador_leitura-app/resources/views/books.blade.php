<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados da Pesquisa</title>
    <style>
        .book-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .book-card {
            border: 1px solid #ccc;
            padding: 10px;
            width: 200px;
            text-align: center;
        }
        .book-card img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Resultados da Pesquisa</h1>

    @if(count($books) > 0)
        <div class="book-container">
            @foreach($books as $book)
                <div class="book-card">
                    <h2>{{ $book->title }}</h2>
                    <p><strong>Autor(es):</strong> {{ $book->authors }}</p>
                    @if($book->imagemLink !== 'Sem imagem')
                        <img src="{{ $book->imagemLink }}" alt="Capa do livro: {{ $book->title }}">
                    @else
                        <p>Sem imagem disponível</p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p>Nenhum livro encontrado.</p>
    @endif
</body>
</html>