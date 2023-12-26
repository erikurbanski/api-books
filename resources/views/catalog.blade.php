<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Relatório - Catálogo de Livros</title>
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
            }
            h1 {
                font-size: 20px;
            }
            table {
                border-collapse: collapse;
                border: 1px solid #e2e2e2;
                width: 100%;
            }
            table td,
            table th {
                padding: 4px;
                text-align: left;
            }
            table.book-detail td,
            table.book-detail th {
                border: 1px solid #e2e2e2;
            }
        </style>
    </head>
    <body>
        <table style="border:0 none">
            <tr>
                <th style="text-align:center">
                    <h1>Catálogo de Livros</h1>
                </th>
            </tr>
        </table>
        <table>
            <thead>
                <tr>
                    <th>Autores:</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($catalog as $author => $books)
                    <tr>
                        <td>
                            <span>{{ $author }}</span>
                        </td>
                    <tr>
                    <tr>
                        <td>
                            <table class="book-detail">
                                <thead>
                                    <tr>
                                        <th>Livro</th>
                                        <th>Assunto</th>
                                        <th>Editora</th>
                                        <th>Edição</th>
                                        <th>Valor</th>
                                        <th>Ano</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($books as $key => $item)
                                        <tr>
                                            <td>{{ $item['title'] }}</td>
                                            <td>{{ $item['description'] }}</td>
                                            <td>{{ $item['publisher'] }}</td>
                                            <td>{{ $item['edition'] }}</td>
                                            <td>R$ {{ number_format($item['value'], 2) }}</td>
                                            <td>{{ $item['year'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align:right">
                        <span>{{ count($catalog) }} autores cadastrados.</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:right">
                        <span>Data do relatório {{ $date }}.</span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
