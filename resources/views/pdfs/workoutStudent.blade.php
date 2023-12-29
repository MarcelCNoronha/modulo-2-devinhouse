<html>

<head>
    <style>
        .title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1 class="title">Lista de Treinos</h1>

    <h2>Estudante: <span>{{ $name }}</span> </h2>

    @foreach ($workouts as $workout)
        <h3>{{ $workout['day'] }}</h3>
        <table border="1">
            <thead>
                <th>Exercicio</th>
                <th>Repetições</th>
                <th>Peso</th>
                <th>Pausa</th>
                <th>Dia</th>
                <th>Observações</th>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $workout['description'] ?? 'N/A' }} </td>
                    <td>{{ $workout['repetitions'] ?? 'N/A' }} </td>
                    <td>{{ $workout['weight'] ?? 'N/A' }} </td>
                    <td>{{ $workout['break_time'] ?? 'N/A' }} </td>
                    <td>{{ $workout['day'] ?? 'N/A' }} </td>
                    <td>{{ $workout['observations'] ?? 'N/A' }} </td>
                </tr>
            </tbody>
        </table>
    @endforeach
</body>

</html>
