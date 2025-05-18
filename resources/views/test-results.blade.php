<x-layout>
<div class="container">
    <h1 class="mb-4">Результаты тестирования</h1>
    
    @if($results->isEmpty())
        <div class="alert alert-info">
            Пока нет результатов тестирования.
        </div>
    @else
        <div>
            @foreach($results as $result)
                <div class="col-md-6 mb-4">
                    <div class="border p-4 rounded mb-2">
                        <div class="card-body">
                            <h5 class="card-title">Имя <b>{{ $result->name }}</b></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Email <b>{{ $result->email }}</b></h6>
                            <p class="card-text">
                                <strong>Дата прохождения:</strong> {{ \Carbon\Carbon::parse($result->date)->format('d.m.Y H:i') }}<br>
                                <strong>Результат:</strong> 
                                <span class="badge {{ $result->result === 'success' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $result->result === 'success' ? 'Успешно' : 'Проиграно' }}
                                </span>
                            </p>
                            <div class="answers">
                                <strong>Ответы:</strong>
                                <ol>
                                    @foreach(json_decode($result->answers, true) as $key => $value)
                                        <li>{{ $key }}: {{ json_encode($value) }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</x-layout>