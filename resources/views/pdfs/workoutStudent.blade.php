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

    @php
        $groupedWorkouts = [];
        foreach ($workouts as $workout) {
            $day = $workout['day'];
            $groupedWorkouts[$day][] = [
                'description' => $workout['description'] ?? 'N/A',
                'repetitions' => $workout['repetitions'] ?? 'N/A',
                'weight' => $workout['weight'] ?? 'N/A',
                'break_time' => $workout['break_time'] ?? 'N/A',
                'day' => $day,
                'observations' => $workout['observations'] ?? 'N/A',
            ];
        }
    @endphp

    @foreach ($groupedWorkouts as $day => $exerciseGroup)
        <h3>{{ $day }}</h3>
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
                @foreach ($exerciseGroup as $exercise)
                    <tr>
                        <td>{{ $exercise['description'] }}</td>
                        <td>{{ $exercise['repetitions'] }}</td>
                        <td>{{ $exercise['weight'] }}</td>
                        <td>{{ $exercise['break_time'] }}</td>
                        <td>{{ $exercise['day'] }}</td>
                        <td>{{ $exercise['observations'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>

</html>
