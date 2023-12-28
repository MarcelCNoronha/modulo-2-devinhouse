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

    <h2>Estudante: <span>{{ $student->name }}</span> </h2>

    @foreach ($workouts as $day => $groupedWorkouts)
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
                @foreach ($groupedWorkouts as $workout)
                    <tr>
                        <td>{{ $workout->exercise_id }} </td>
                        <td>{{ $workout->repetitions }} </td>
                        <td>{{ $workout->weight }} </td>
                        <td>{{ $workout->break_time }} </td>
                        <td>{{ $workout->day }} </td>
                        <td>{{ $workout->observations }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>

</html>

