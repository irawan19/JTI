<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="c-body">
        <main class="c-main">
            <div class="container-fluid">
                @php($tambah_providers = \App\Models\Provider::get())
                <div class="row">
                    <div class="col-sm-6 col-center">
                        <div class="card">
                            <div class="card-header center-align">
                                <strong>Data No Handphone</strong>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-success successform" style="display:none"></div>
                                <div class="alert alert-danger errorform" style="display:none"></div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="no_handphones">No Handphone <b style="color:red">*</b></label>
                                    <input class="form-control {{ Custom::validForm($errors->first('no_handphones')) }}" id="no_handphones" type="number" name="no_handphones" value="{{Request::old('no_handphones')}}">
                                    {{Custom::pesanErorForm($errors->first('no_handphones'))}}
                                </div>
                                <div class="form-group">
                                    <label class="form-col-form-label" for="providers_id">Provider <b style="color:red">*</b></label>
                                    <select class="form-control select2" id="providers_id" name="providers_id">
                                        @foreach($tambah_providers as $providers)
                                            <option value="{{$providers->id_providers}}" {{ Request::old('providers_id') == $providers->id_providers ? $select='selected' : $select='' }}>{{$providers->nama_providers}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer right-align">
                                <button id="simpan" class="btn btn-success" type="submit" name="simpan" value="simpan">
                                    <svg class="c-icon" style="margin-right:5px;">
                                        <use xlink:href="{{URL::asset('css/icons/coreui/free.svg#cil-plus')}}"></use>
                                    </svg> Save
                                </button>
                                <button id="auto" class="btn btn-secondary" type="submit" name="simpan" value="simpan">
                                    <svg class="c-icon" style="margin-right:5px;">
                                        <use xlink:href="{{URL::asset('css/icons/coreui/free.svg#cil-reload')}}"></use>
                                    </svg> Auto
                                </button>
                                <a class="btn btn-danger" href="{{URL('dashboard')}}">
                                    <svg class="c-icon" style="margin-right:5px;">
                                        <use xlink:href="{{URL::asset('css/icons/coreui/free.svg#cil-ban')}}"></use>
                                    </svg> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $("#simpan").click(function() {
                $.ajaxSetup({
                           headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                        });
                $.ajax({
                    type: "POST",
                    url: '{{URL("/api/input/proses")}}',
                    data: {
                        'no'        : $('#no_handphones').val(),
                        'providers' : $('#providers_id').find(':selected').val(),
                    },
                    success: function(data)
                    {
                        if (data.status == true)
                        {
                            $('.errorform').hide();
                            $('.successform').text(data.pesan);
                            $('.successform').show();
                            $('#no_handphones').val('');
                            $('#providers_id').val(1).trigger('change');
                        }
                        else if (data.status == false)
                        {
                            $('.successform').hide();
                            $('.errorform').text(data.pesan);
                            $('.errorform').show();
                        }
                    }
                });
            });

            $("#auto").click(function(){
                $.ajaxSetup({
                           headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                        });
                $.ajax({
                    type: "GET",
                    url: '{{URL("/api/input/auto")}}',
                    success: function(data)
                    {
                        if (data.status == true)
                        {
                            $('.errorform').hide();
                            $('.successform').text(data.pesan);
                            $('.successform').show();
                            $('#no_handphones').val('');
                            $('#providers_id').val(1).trigger('change');
                        }
                        else if (data.status == false)
                        {
                            $('.successform').hide();
                            $('.errorform').text(data.pesan);
                            $('.errorform').show();
                        }
                    }
                });
            });
        });
    </script>
    
</x-app-layout>