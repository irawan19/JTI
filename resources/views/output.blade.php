<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="c-body">
        <main class="c-main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header center-align">
                                <strong>Output</strong>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-success successform" style="display:none"></div>
                                <div class="alert alert-danger errorform" style="display:none"></div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <table id="outputtableganjil" class="table table-responsive-sm table-bordered table-striped table-sm">
            						  		<thead>
            						  			<tr>
            						  				<th class="center-align">Ganjil</th>
            						  			</tr>
            						  		</thead>
            						  		<tbody></tbody>
            						  	</table>
                                    </div>
                                    <div class="col-sm-6">
                                        <table id="outputtablegenap" class="table table-responsive-sm table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="center-align">Genap</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer right-align">
                                <button id="edit" class="btn btn-primary" type="submit" name="simpan" value="simpan">
                                    <svg class="c-icon" style="margin-right:5px;">
                                        <use xlink:href="{{URL::asset('css/icons/coreui/free.svg#cil-pencil')}}"></use>
                                    </svg> Edit
                                </button>
                                <button id="hapus" class="btn btn-danger" type="submit" name="hapus" value="hapus">
                                    <svg class="c-icon" style="margin-right:5px;">
                                        <use xlink:href="{{URL::asset('css/icons/coreui/free.svg#cil-trash')}}"></use>
                                    </svg> Delete
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header center-align">
                                <strong>Edit</strong>
                            </div>
                            <div class="card-body">
                                @php($edit_providers = \App\Models\Provider::get())
                                    <div class="alert alert-success successformedit" style="display:none"></div>
                                    <div class="alert alert-danger errorformedit" style="display:none"></div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="no_handphones">No Handphone <b style="color:red">*</b></label>
                                        <input disabled class="form-control" id="no_handphones" type="number" name="no_handphones" value="{{Request::old('no_handphones')}}">
                                        <div class="errorform" id="errorformhandphone" style="display:none">No Harus Diisi.</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-col-form-label" for="providers_id">Provider <b style="color:red">*</b></label>
                                        <select class="form-control select2" disabled id="providers_id" name="providers_id">
                                            @foreach($edit_providers as $providers)
                                                <option value="{{$providers->id_providers}}" {{ Request::old('providers_id') == $providers->id_providers ? $select='selected' : $select='' }}>{{$providers->nama_providers}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                            <div class="card-footer right-align">
                                <button id="prosesedit" class="btn btn-primary" type="submit" name="edit" value="edit">
                                    <svg class="c-icon" style="margin-right:5px;">
                                        <use xlink:href="{{URL::asset('css/icons/coreui/free.svg#cil-pencil')}}"></use>
                                    </svg> Proses Edit
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
            tampilData();

            $('#prosesedit').hide();
            $('#edit').on('click', function(){
                idhandphone = $('.tdselect').find('button').val();
                if(idhandphone != undefined)
                {
                    $.ajaxSetup({
                                   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                                });
                    $.ajax({
                        type: "POST",
                        url: '{{URL("/api/output/detail")}}',
                        data:{id_handphones: idhandphone},
                        success: function(data)
                        {
                            $('#no_handphones').val(data.pesan.no_handphones);
                            $('#providers_id').val(data.pesan.providers_id).trigger('change');
                            $('#no_handphones').prop('disabled',false);
                            $('#providers_id').prop('disabled',false);
                            $('#prosesedit').show();
                        }
                    });
                }
                else
                {
                    $('#no_handphones').prop('disabled',true);
                    $('#no_handphones').val('');
                    $('#providers_id').prop('disabled',true);
                    $('#providers_id').val(1).trigger('change');
                    $('#prosesedit').hide();
                }
            });

            $('#hapus').on('click', function(){
                idhandphone = $('.tdselect').find('button').val();
                if(idhandphone != undefined)
                {
                    $.ajaxSetup({
                                   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                                });
                    $.ajax({
                        type: "POST",
                        url: '{{URL("/api/output/delete")}}',
                        data:{id_handphones: idhandphone},
                        success: function(data)
                        {
                            if (data.status == true)
                            {
                                $('.errorform').hide();
                                $('.successform').text(data.pesan);
                                $('.successform').show();
                            }
                            else if (data.status == false)
                            {
                                $('.successform').hide();
                                $('.errorform').text(data.pesan);
                                $('.errorform').show();
                            }

                            $('#outputtableganjil tbody > tr > td').remove();
                            $('#outputtablegenap tbody > tr > td').remove();
                            tampilData();
                        }
                    });
                }
            })

            $('#prosesedit').on('click', function(){
                if($('#no_handphones').val() != '')
                {
                    idhandphone = $('.tdselect').find('button').val();
                    if(idhandphone != undefined)
                    {
                        $.ajaxSetup({
                                       headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                                    });
                        $.ajax({
                            type: "POST",
                            url: '{{URL("/api/output/edit")}}',
                            data:{
                                id_handphones: idhandphone,
                                no_handphones: $('#no_handphones').val(),
                                providers_id : $('#providers_id').find(':selected').val(),
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
                                    $('#no_handphones').prop('disabled',true);
                                    $('#providers_id').prop('disabled',true);
                                    $('#prosesedit').hide();
                                }
                                else if (data.status == false)
                                {
                                    $('.successform').hide();
                                    $('.errorform').text(data.pesan);
                                    $('.errorform').show();
                                }

                                $('#outputtableganjil tbody > tr > td').remove();
                                $('#outputtablegenap tbody > tr > td').remove();
                                tampilData();
                                $('#errorformhandphone').css('display','none');
                                $('#no_handphones').removeClass('is-invalid');
                            }
                        });
                    }
                }
                else
                {
                    $('#errorformhandphone').css('display','block');
                    $('#no_handphones').addClass('is-invalid');
                }
            });
        });

        function tampilData()
        {
            $.ajaxSetup({
                           headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                        });
            $.ajax({
                type: "GET",
                url: '{{URL("/api/output")}}',
                success: function(data)
                {
                    $.each( data, function( key, value ) {
                        $.each(value.ganjil, function(key2, value2) {
                            newRowContent = '<tr>'+
                                                '<td id="handphone'+value2.id+'"><button style="width:100%; text-align:left; outline:none" onclick="pilihHandphone('+value2.id+')" value="'+value2.id+'">'+value2.no+'<button></td>'+
                                            '</tr>';
                            $("#outputtableganjil tbody").append(newRowContent);
                        });
                    });

                    $.each( data, function( key, value ) {
                        $.each(value.genap, function(key2, value2) {
                            newRowContent = '<tr>'+
                                                '<td id="handphone'+value2.id+'"><button style="width:100%; text-align:left; outline:none" onclick="pilihHandphone('+value2.id+')" value="'+value2.id+'">'+value2.no+'</button></td>'+
                                            '</tr>';
                            $("#outputtablegenap tbody").append(newRowContent);
                        });
                    });
                }
            });
        }

        function pilihHandphone(idhandphones)
        {
            if($('#handphone'+idhandphones).hasClass('tdselect') == false)
            {
                $('td').css('background-color','');
                $('td').removeClass('tdselect');
                $('#handphone'+idhandphones).css('background-color','#f79e9e');
                $('#handphone'+idhandphones).addClass('tdselect');
            }
            else if($('#handphone'+idhandphones).hasClass('tdselect') == true)
            {
                $('td').css('background-color','');
                $('td').removeClass('tdselect');
                $('#handphone'+idhandphones).css('background-color','');
                $('#handphone'+idhandphones).removeClass('tdselect');
            }
        }
    </script>
    
</x-app-layout>