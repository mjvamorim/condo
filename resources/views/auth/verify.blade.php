@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifique o seu email!') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Um link de verificação acabou de ser enviado para o seu email.') }}
                        </div>
                    @endif

                    {{ __('Uma email de confirmação foi enviado. Por favor abra a sua caixa de emails e clique no link enviado.') }}
                    {{ __('Caso não tenha recebido o email de verificação,') }},
                    <a href="{{ route('verification.resend') }}">
                        {{ __('clique aqui para envia-lo novamente') }}
                    </a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
