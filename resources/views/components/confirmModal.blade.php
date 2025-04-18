{{-- VARIÁVEIS
    :title="'Confirme por favor'"
    :message="'Quer mesmo alterar a nota?'"
    :btnNo="'Cancelar'"
    :btnYes="'Confirmar'"
    :form="'formEditNote'"
    :action='/deletar'
--}}

<!-- Modal de confirmação -->
<div id="confirmModal">
    <!-- Backdrop escuro -->
    <div class="confirmWindowBackdrop"></div>
    <!-- Janelinha com mensagem e botões -->
    <div class="confirmWindow">
        <div class="modal-content">
            <h2>{{$title}}</h2>
            <p>{{$message}}</p>
            @if (isset($action))
            <form action="{{route('update.note')}}" method="post" id="formEditNote">
                <a href="#" class="btn btn-primary"><i class="fa-solid fa-ban me-2"></i>{{$btnNo}}</a>
                <button type="submit" class="btn btn-secondary" form="{{$form}}"><i class="fa-regular fa-circle-check me-2"></i>{{$btnYes}}</button>
            </form>
            @else
            <div>
                <a href="#" class="btn btn-primary"><i class="fa-solid fa-ban me-2"></i>{{$btnNo}}</a>
                <button type="submit" class="btn btn-secondary" form="{{$form}}"><i class="fa-regular fa-circle-check me-2"></i>{{$btnYes}}</button>
            </div>
            @endif
        </div>
    </div>
</div>
<style>
    /* Estado inicial do Modal */
    #confirmModal{
        display: none;
    }
    /* Quando o modal é ativado */
    #confirmModal:target {
        display: block;
    }

    .confirmWindowBackdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Cor preta com transparência */
        display: block; /* Oculto por padrão */
        z-index: 999; /* Certifique-se de que está acima de outros elementos */
    }

    /* Estilo geral */
    .confirmWindow {
        display: block;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        background-color: var(--bs-body-bg);
        border: var(--bs-border-width) solid rgba(0,0,0,.6);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        padding: 20px;
        z-index: 1000;
    }

    .modal-content {
        text-align: center;
    }

    
</style>