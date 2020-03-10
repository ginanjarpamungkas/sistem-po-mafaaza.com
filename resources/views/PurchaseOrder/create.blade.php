@extends('layouts.dashboard')
@section('header')
<style>
    /* my daterangepicker custom css */
    .calendar.left.single {width: 100%;}
    .ranges{text-align: center;float: none !important;}
    /* table style */
    #dg{width:100%; border: 1px solid #95B8E7}
    #dg .row-number, thead{background:#F4F4F4; text-align:center}
    #dg td, th{border: 1px dotted #ccc;}
    .input-table{border:none;width: 100%; height: 25px;}
    .input-table:focus{outline: none}
    .footer-table, th {background:#F4F4F4; text-align:center; height: 31px}
    .data-table{overflow:scroll; height: 500px}
    .header-table{text-align: center; background:#95B8E7; padding:10px 0}
    .is-invalid{border: 1px solid red !important;}
    .nav-sm ul.nav.chart{width: fit-content;height: fit-content;left: 0;top: 100%;border: 1px solid #fff}
    select{font-family: fontAwesome}
    tbody tr:hover {background-color: #fff !important;}
    tbody tr td label{display: block;cursor: text}
</style>
@endsection
@section('content')
    <section class="content-header">
        <h1>
        Purchase Order
        <small>{{config('app.name')}}</small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bullhord"></i> Purchase Order</a></li>
        <li class="active">create</li>
        </ol>
    </section>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pembuatan Purchase Order</h3>
                    </div>
                    <div class="box-body">                                      
                        <form action="{{route('po.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Tanggal Pemesanan <span class="required">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-btn"><a class="btn btn-default" aria-hidden="true" disabled><i class="fa fa-calendar-o"></i></a></span>
                                    <input type="text" class="form-control {{ $errors->has('tgl_pemesanan') ? ' is-invalid' : '' }}" id="tgl_pemesanan" name="tgl_pemesanan" required onkeydown="event.preventDefault()">
                                    @if ($errors->has('tgl_pemesanan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong style="color:red">{{ $errors->first('tgl_pemesanan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Supplier <span class="required">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('supplier') ? ' is-invalid' : '' }}" id="supplier" name="supplier" required>
                                @if ($errors->has('supplier'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color:red">{{ $errors->first('supplier') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Pemesanan Untuk <span class="required">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('gudang') ? ' is-invalid' : '' }}" id="gudang" name="gudang" required>
                                @if ($errors->has('gudang'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color:red">{{ $errors->first('gudang') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Pemesan <span class="required">*</span></label>
                                <input type="text" class="form-control" id="pemesan" name="pemesan" value="{{auth()->user()->name}}" readonly>
                                <input type="hidden" value="{{auth()->user()->id}}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="8"></textarea>
                                @if ($errors->has('supplier'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color:red">{{ $errors->first('keterangan') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="header-table">Input Data</div>
                            <div class="form-group data-table">
                                <table id="dg">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Harga Satuan</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i < 31; $i++)
                                            <tr>
                                                <td class="row-number">{{$i}}</td>
                                                <td><label><input type="text" name="nama_barang[]" class="input-table" tabindex="{{$i}}" data="1" data-autosize-input='{ "space": 40 }'></label></td>
                                                <td><label><input type="text" name="jumlah_barang[]" class="input-table" tabindex="{{$i}}" data="2" id="jmlBrg{{$i}}" data-autosize-input='{ "space": 40 }' onkeydown="return(f_validchar('.0123456789',event))" onkeyup="kali()"></label></td>
                                                <td><label><input type="text" name="satuan_barang[]" class="input-table" tabindex="{{$i}}" data="3" data-autosize-input='{ "space": 40 }'></label></td>
                                                <td><label><input type="text" name="harga_barang[]" class="input-table" tabindex="{{$i}}" data="4" id="hrgBrg{{$i}}" data-autosize-input='{ "space": 40 }' onkeydown="return(f_validchar('.0123456789',event))" onkeyup="kali()"></label></td>
                                                <td><label><input type="text" name="total_harga_barang[]" class="input-table" tabindex="{{$i}}" data="5" id="ttlHrgBrg{{$i}}" data-autosize-input='{ "space": 40 }' onkeydown="return(f_validchar('.0123456789',event))" readonly></label></td>
                                            </tr>    
                                        @endfor
                                        <tr><td class="footer-table" colspan="28"></td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <label>Sub Total Harga</label>
                                <input type="number" class="form-control" id="subtotal" name="subtotal" value="0" readonly>
                            </div>
                            <button type="submit" class="col-xs-12 btn btn-success">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('footer')
<script>
    $(document).ready(function() {
        $('body').attr('class','skin-red sidebar-mini sidebar-collapse')
    })
    $(function() {
      $('input[id="tgl_pemesanan"]').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        timePicker24Hour: true,
        timePickerSeconds: false,
        drops: "down",
        locale: {
          format: 'DD-MM-YYYY'
        }
      });
    });
    $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
        if(e.which == 13) {
            e.preventDefault();
            return false;
        }
    });
    $(document).on("keypress", ".input-table", function (e)
    {
        var dataId = $(this).attr('data');
        if (e.keyCode == 13)
        {
            var nextElement = $('[tabindex="' + (this.tabIndex + 1) + '"][data="' + dataId + '"]');
            
            if (nextElement.length)
                $('[tabindex="' + (this.tabIndex + 1) + '"][data="' + dataId + '"]').focus()
            else
                $('[tabindex="1"][data="2"]').focus();
        }
    });
    $(document).on("keydown", ".input-table", function (e)
    {
        var dataSet = $(this).attr('data');
        var dataTab = $(this).attr('tabindex');
        var dataId = parseInt(dataSet);
        switch (e.keyCode) {
            case 37:
                $('[tabindex="' + dataTab + '"][data="' + (dataId-1) + '"]').focus()
            break;
            case 38:
                $('[tabindex="' + (dataTab-1) + '"][data="' + dataId + '"]').focus()
            break;
            case 39:                
                $('[tabindex="' + dataTab + '"][data="' + (dataId+1) + '"]').focus()
            break;
            case 40:
                $('[tabindex="' + (this.tabIndex + 1) + '"][data="' + dataId + '"]').focus()
            break;
        }
    });
    function f_validchar($validcharacter,$event){
      $event=($event)?$event:window.event;  
      if(("|8|13|37|38|39|40|46|").indexOf($event.which)>0)return true; //|backspace|enter|left|down|up|right|delete|
      if ($event.which == 190) {return true;}
      return($validcharacter.indexOf(String.fromCharCode($event.which))<0?false:true)
    };
    
    var Plugins;(function(n){var t=function(){function n(n){typeof n=="undefined"&&(n=30);this.space=n}return n}(),i;n.AutosizeInputOptions=t;i=function(){function n(t,i){var r=this;this._input=$(t);this._options=$.extend({},n.getDefaultOptions(),i);this._mirror=$('<span style="position:absolute; top:-999px; left:0; white-space:pre;"/>');$.each(["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],function(n,t){r._mirror[0].style[t]=r._input.css(t)});$("body").append(this._mirror);this._input.on("keydown keyup input propertychange change",function(){r.update()});(function(){r.update()})()}return n.prototype.getOptions=function(){return this._options},n.prototype.update=function(){var n=this._input.val()||"",t;n!==this._mirror.text()&&(this._mirror.text(n),t=this._mirror.width()+this._options.space,this._input.width(t))},n.getDefaultOptions=function(){return this._defaultOptions},n.getInstanceKey=function(){return"autosizeInputInstance"},n._defaultOptions=new t,n}();n.AutosizeInput=i,function(t){var i="autosize-input",r=["text","password","search","url","tel","email","number"];t.fn.autosizeInput=function(u){return this.each(function(){if(this.tagName=="INPUT"&&t.inArray(this.type,r)>-1){var f=t(this);f.data(n.AutosizeInput.getInstanceKey())||(u==undefined&&(u=f.data(i)),f.data(n.AutosizeInput.getInstanceKey(),new n.AutosizeInput(this,u)))}})};t(function(){t("input[data-"+i+"]").autosizeInput()})}(jQuery)})(Plugins||(Plugins={}))
    function kali() { 
        var subtotal = 0;
        for ($i =1; $i < 31; $i++) {
            $('#ttlHrgBrg'+$i).val($('#jmlBrg'+$i).val()*$('#hrgBrg'+$i).val())
            subtotal = subtotal+parseInt($('#ttlHrgBrg'+$i).val())
        };
        $('#subtotal').val(subtotal)
    };
  </script>
@endsection