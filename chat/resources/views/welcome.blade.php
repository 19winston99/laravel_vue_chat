@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center gap-5 flex-wrap">
    <div class="description-container me-2 ms-2">
        <p class="description-site">
            Benvenuti nel mondo emozionante della comunicazione in tempo reale! Il nostro sito offre un'esperienza unica, grazie alla potente combinazione di Laravel, Vue.js e Pusher.

            Con Laravel, un framework PHP all'avanguardia, e Vue.js, un framework JavaScript flessibile e moderno, la nostra chat si trasforma in un'esperienza coinvolgente e reattiva. Goditi un'interfaccia utente dinamica e fluida, che si adatta alle tue esigenze e risponde ai tuoi comandi.

            E cosa c'è di meglio di una connessione istantanea? Con Pusher, i messaggi viaggiano attraverso i confini digitali ad una velocità impressionante. Non devi più aspettare, né ricaricare la pagina. La comunicazione diventa istantanea, come se le parole prendessero vita e danzassero sullo schermo.

            Visita il nostro sito oggi stesso e inizia a vivere il fascino della comunicazione in tempo reale!
        </p>
        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary mt-1">Get Started <i class="bi bi-arrow-right-circle"></i></a>
    </div>
    <div class="d-flex flex-column gap-5">
        <img src="{{ asset('images/contents/chat-3.png')}}" class="welcome-image" alt="chat-image">
        <img src="{{ asset('images/contents/chat-2.png')}}" class="welcome-image" alt="chat-image">
    </div>
</div>
@endsection