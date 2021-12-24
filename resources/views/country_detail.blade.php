@extends('layout')

@section('content')
    <div class="container-fluid mt-5 mb-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $country->display_name }}</h5>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Website</th>
                        <th scope="col">City</th>
                        <th scope="col">Address</th>
                        <th scope="col">Office hours</th>
                        <th scope="col">Note</th>
                        <th scope="col">Type</th>
                        <th scope="col">Emails</th>
                        <th scope="col">Phones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($diplomaticMissions as $i => $mission)
                        <tr>
                            <th scope="row">{{ $i + 1 }}</th>
                            <td>
                                @if($mission['website'])
                                    <a href="{{ $mission['website'] }}" target="_blank">
                                        <i class="fa fa-external-link" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </td>
                            <td>{{ $mission['city'] }}</td>
                            <td>{{ $mission['address'] }}</td>
                            <td>{{ $mission['office_hours'] }}</td>
                            <td>
                                @if($mission['note'])
                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#NoteModal" data-bs-note="{{ $mission['note'] }}">
                                        <i class="fa fa-comment" aria-hidden="true"></i>
                                    </button>
                                @endif
                            </td>
                            <td>{{ $mission['type'] }}</td>
                            <td>{{ join(', ', $mission['emails']) }}</td>
                            <td>{{ join(', ', $mission['phones']) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="NoteModal" tabindex="-1" aria-labelledby="NoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script>
        var NoteModal = document.getElementById('NoteModal')
        NoteModal.addEventListener('show.bs.modal', function (event) {
            console.log('asd');
            var button = event.relatedTarget
            var modalContent = NoteModal.querySelector('.modal-body p')
            modalContent.innerHTML = button.getAttribute('data-bs-note')
        })
    </script>
@endpush
