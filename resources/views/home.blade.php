@extends('layouts.main_layout')

@section('contents')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col">

                @include('top_bar')
                
                @if (count($notes) == 0)
                <!-- no notes available -->
                <div class="row mt-5">
                    <div class="col text-center">
                        <p class="display-6 mb-5 text-secondary opacity-50">You have no notes available!</p>
                        <a href="{{Route('new.note')}}" class="btn btn-secondary btn-lg p-3 px-5">
                            <i class="fa-regular fa-pen-to-square me-3"></i>Create Your First Note
                        </a>
                    </div>
                </div>
                @else
                    <!-- notes are available -->
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{Route('new.note')}}" class="btn btn-secondary px-3">
                            <i class="fa-regular fa-pen-to-square me-2"></i>New Note
                        </a>
                    </div>

                    @foreach ($notes as $note)
                        <div class="row">
                            <div class="col">
                                <div class="card p-4">
                                    <div class="row">
                                        <div class="col">
                                            <h4 class="text-info">{{$note['title']}}</h4>
                                            <small class="text-secondary"><span class="opacity-75 me-2">Created at:</span><strong>{{$note['created_at']}}</strong></small>
                                            @if ($note['created_at']!=$note['updated_at'])
                                            <small class="text-secondary ms-5"><span class="opacity-75 me-2">Updated at:</span><strong>{{$note['updated_at']}}</strong></small>                                                
                                            @endif
                                        </div>
                                        <div class="col text-end">
                                            {{-- USAMOS CRYPT PARA ENCRIPTAR OS DADOS AO PASSA-LOS VIA GET --}}
                                            <a href="{{Route('edit.note', ['id'=>Crypt::encrypt($note['id'])])}}" class="btn btn-outline-secondary btn-sm mx-1"><i class="fa-regular fa-pen-to-square"></i></a>
                                            <a href="{{Route('remove.note', Crypt::encrypt($note['id']))}}
                                            " class="btn btn-outline-danger btn-sm mx-1"><i class="fa-regular fa-trash-can"></i></a>
                                        </div>
                                    </div>
                                    <hr>
                                    <p class="text-secondary">{{$note['text']}}</p>
                                </div>
                            </div>
                        </div>
                        {{-- @if ($loop->last) --}}
                        {{-- @else --}}
                            <br>
                        {{-- @endif --}}
                    @endforeach
                @endif
            </div>

            <div class="toast2">Este é um toast que desaparece!</div>
            <style>
                /* Estilização do toast */
                .toast2 {
                    position: fixed;
                    top: 0px;
                    left: 0px;
                    background-color: #333;
                    color: #fff;
                    padding: 15px 20px;
                    border-radius: 5px;
                    font-size: 14px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                    opacity: 0; /* Começa invisível */
                    transform: translateY(-20px); /* Posicionado fora de vista */
                    animation: showToast 5s ease forwards;
                }

                /* Animação para mostrar e esconder */
                @keyframes showToast {
                    0% {
                        opacity: 0;
                        transform: translateY(-20px);
                    }
                    10% {
                        opacity: 1;
                        transform: translateY(0);
                    }
                    90% {
                        opacity: 1;
                        transform: translateY(0);
                    }
                    100% {
                        opacity: 0;
                        transform: translateY(-20px);
                    }
                }
            </style>

        </div>
    </div>
@endsection