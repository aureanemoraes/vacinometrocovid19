@extends('layouts.app')

@section('title', 'VacinômetroCOVID19 - Pré-cadastro')

@section('css')
@endsection

@section('main')
    <div class="container">
        <form id="pre-form" action="/pre-cadastro" method="POST">
            @csrf
            <section>
                <h4>Informações gerais</h4>
                <div class="form-group">
                    <label for="name">Nome completo*</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nome completo...">
                </div>
                <div class="form-group">
                    <label for="cpf">CPF*</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF...">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="birthdate">Data de nascimento*</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="Data de nascimento...">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="gender">Gênero*</label>
                            <select class="form-control" id="gender" name="gender" >
                                <option value="" selected disable>Selecione...</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                                <option value="Homem transgênero">Homem transgênero</option>
                                <option value="Mulher transgênero">Mulher transgênero</option>
                                <option value="Homem transexual">Homem transexual</option>
                                <option value="Cisgênero">Cisgênero</option>
                                <option value="Não sei responder">Não sei responder</option>
                                <option value="Prefiro não responder">Prefiro não responder</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="e-mail">E-mail (opcional)</label>
                    <input type="email" class="form-control" id="e-mail" name="e-mail" placeholder="E-mail (opcional)..">
                </div>
                <div class="form-group">
                    <label for="bedridden">Acamado*</label>
                    <select class="form-control" id="bedridden" name="bedridden">
                        <option value="Sim">Sim</option>
                        <option value="Não" selected>Não</option>
                    </select>
                </div>
            </section>
            <section>
                <h4>Contato</h4>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="phone_1">Telefone principal*</label>
                            <input class="form-control" id="phone_1" name="phone_1" placeholder="Celular...">
                        </div>
                    </div>
                    <input type="hidden" id="type_phone_1" name="type_phone_1" value="Principal" >

                    <div class="col">
                        <div class="form-group">
                            <label for="person_1">Falar com</label>
                            <input class="form-control" id="person_1" name="person_1" placeholder="Nome da pessoa...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="phone_2">Telefone para recado (opcional)</label>
                            <input class="form-control" id="phone_2" name="phone_2" placeholder="Celular...">
                        </div>
                    </div>
                    <input type="hidden" id="type_phone_2" name="type_phone_2" value="Recado" >

                    <div class="col">
                        <div class="form-group">
                            <label for="person_2">Falar com</label>
                            <input class="form-control" id="person_2" name="person_2" placeholder="Nome da pessoa...">
                        </div>
                    </div>
                </div>

            </section>
            <section>
                <h4>Endereço</h4>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="country">País*</label>
                            <input type="text" class="form-control" id="country" name="country" placeholder="País..." value="Brasil" disabled>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="state">Estado*</label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="Estado..." value="Amapá" disabled>
                        </div>
                    </div>
                </div>
                    <div class="form-row align-items-center">
                        <label for="zip_code">Consultar endereço</label>
                        <div class="col-sm-3 my-1">
                            <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Por CEP...">

                        </div>
                        <div class="col-auto my-1">
                            <button type="button" class="btn btn-pill btn-dark" id="search_address">Buscar</button>
                        </div>
                        <div class="col-auto my-1">
                            <p>Não sabe seu CEP? <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/default.cfm" target="_blank">Pesquise aqui</a></p>

                        </div>

                    </div>


                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="public_place">Logradouro*</label>
                            <input class="form-control" id="public_place" name="public_place" placeholder="Logradouro..." >
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="number_of_place">Número*</label>
                            <input class="form-control" id="number_of_place" name="number_of_place" placeholder="Número...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="neighborhood">Bairro*</label>
                            <input class="form-control" id="neighborhood" name="neighborhood" placeholder="Bairro..." >
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="city">Município*</label>
                            <select class="form-control" id="city" name="city" placeholder="Município..." >
                                <option value="" selected disable>Selecione...</option>
                                <option value="Amapá">Amapá</option>
                                <option value="Calçoene">Calçoene</option>
                                <option value="Cutias">Cutias</option>
                                <option value="Ferreira Gomes">Ferreira Gomes</option>
                                <option value="Itaubal">Itaubal</option>
                                <option value="Laranjal do Jari">Laranjal do Jari</option>
                                <option value="Macapá">Macapá</option>
                                <option value="Mazagão">Mazagão</option>
                                <option value="Oiapoque">Oiapoque</option>
                                <option value="Pedra Branca do Amapari">Pedra Branca do Amapari</option>
                                <option value="Porto Grande">Porto Grande</option>
                                <option value="Pracuúba">Pracuúba</option>
                                <option value="Santana">Santana</option>
                                <option value="Serra do Navio">Serra do Navio</option>
                                <option value="Tartarugalzinho">Tartarugalzinho</option>
                                <option value="Vitória do Jari">Vitória do Jari</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>
            {{--
            <section>
                <h4>Local de vacinação</h4>
                <small class="form-text text-muted">
                    Caso todos os locais disponíveis se encontrem com capacidade máxima de vacinação, você será direcionado para uma unidade diferente das selecionadas.
                </small>
                <div class="form-group">
                    <label for="vp_one">Preferência principal*</label>
                    <select class="form-control" id="vp_one" name="vp_one">
                    </select>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="vp_two">2ª Preferência*</label>
                            <select class="form-control" id="vp_two" name="vp_two">
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="vp_three">3ª Preferência*</label>
                            <select class="form-control" id="vp_three" name="vp_three">
                            </select>
                        </div>
                    </div>
                </div>
            </section>
            --}}
            <button type="submit">Enviar</button>
        </form>
    </div>
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous"></script>
    <script>
        jQuery.validator.addMethod("cpf", function(value, element) {
            value = jQuery.trim(value);

            value = value.replace('.','');
            value = value.replace('.','');
            cpf = value.replace('-','');
            while(cpf.length < 11) cpf = "0"+ cpf;
            var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
            var a = [];
            var b = new Number;
            var c = 11;
            for (i=0; i<11; i++){
                a[i] = cpf.charAt(i);
                if (i < 9) b += (a[i] * --c);
            }
            if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
            b = 0;
            c = 11;
            for (y=0; y<10; y++) b += (a[y] * c--);
            if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

            var retorno = true;
            if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

            return this.optional(element) || retorno;

        }, "Informe um CPF válido");

        jQuery(document).ready(function($){
            $("#cpf").mask("000.000.000-00");
            $("#zip_code").mask("00000-000");
            $("#phone_1").mask("(00) 00000-0000");
            $("#phone_2").mask("(00) 00000-0000");

            $("#search_address").click(function (e) {
                e.preventDefault();
                let data = {
                    "_token": "{{ csrf_token() }}",
                    'zip_code' : $('#zip_code').val(),
                    'public_place': $('#public_place').val()
                };
                $.ajax({
                    type: 'POST',
                    url: 'cep',
                    data: data,
                    dataType: 'json',
                    success: function (data) {
                        $('#public_place').val(data.logradouro);
                        $('#neighborhood').val(data.bairro);
                        $('#city').val(data.localidade);
                        console.log(data);

                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
        });



        $('#pre-form').validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                cpf: {
                    cpf: true,
                    required: true,
                }
                ,
                birthdate: {
                    required: true,
                    date: true,
                },
                gender: {
                    required: true
                },
                email: {
                    email: true,
                },
                bedridden: {
                    required: true
                },
                phone_1: {
                    required: true
                },
                public_place: {
                    required: true,
                },
                number_of_place: {
                    required: true
                },
                neighborhood: {
                    required: true
                },
                city: {
                    required: true
                }

            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $('#pre-form').submit(() => {
            $('#cpf').unmask();
            $('#zip_code').unmask();
            $('#phone_1').unmask();
            $('#phone_2').unmask();
        });
    </script>
@endsection
