@extends('layouts.admin')
@section('content')
    <!-- row -->
    <div class="row">
        <!-- Left sidebar -->
        <div class="col-md-12">
            <div class="white-box">
                @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{  $error}}    </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (\Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <p>{{  \Session::get('success') }}</p>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-2 col-md-3  col-sm-4 col-xs-12 inbox-panel">
                        <div> <a href="#" class="btn btn-custom btn-block waves-effect waves-light">Compose</a>
                            <div class="list-group mail-list m-t-20"> <a href="inbox.html" class="list-group-item active">Inbox <span class="label label-rouded label-success pull-right">5</span></a> <a href="#" class="list-group-item ">Starred</a> <a href="#" class="list-group-item">Draft <span class="label label-rouded label-warning pull-right">15</span></a> <a href="#" class="list-group-item">Sent Mail</a> <a href="#" class="list-group-item">Trash <span class="label label-rouded label-default pull-right">55</span></a> </div>
                            <h3 class="panel-title m-t-40 m-b-0">Labels</h3>
                            <hr class="m-t-5">
                            <div class="list-group b-0 mail-list"> <a href="#" class="list-group-item"><span class="fa fa-circle text-info m-r-10"></span>Work</a> <a href="#" class="list-group-item"><span class="fa fa-circle text-warning m-r-10"></span>Family</a> <a href="#" class="list-group-item"><span class="fa fa-circle text-purple m-r-10"></span>Private</a> <a href="#" class="list-group-item"><span class="fa fa-circle text-danger m-r-10"></span>Friends</a> <a href="#" class="list-group-item"><span class="fa fa-circle text-success m-r-10"></span>Corporate</a> </div>
                        </div>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 mail_listing">
                        <h3 class="box-title">Compose New Message</h3>
                        <form action="{{ route('mails.import_list_mails') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                              <label for="list_mails">Import danh sách mail</label>
                              <input type="file" name="list_mails" id="list_mails" class="form-control" placeholder="" aria-describedby="helpId">
                              <br>
                              <button type="submit" class="btn btn-warning">Import</button>
                            </div>
                        </form>
                        <form action="{{route('mails.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input class="form-control" id="email" name="email" placeholder="To:">
                            </div>
                            <a href="#" class="btn-accept" style="color:blue">Gửi nhiều người</a>
                            <br>
                            <div class="form-group show-send-multiple-email" style="display:none;">
                                <input type="text" class="form-control" id="multiple_emails" name="multiple_emails" placeholder="Gửi nhiều">
                            </div> 
                            <br>
                            <div class="form-group">
                                <input class="form-control" id="subject" name="subject" placeholder="Subject:">
                            </div>
                            <div class="form-group">
                                <textarea class="textarea_editor form-control" id="message" name="message" rows="15" placeholder="Enter text ..."></textarea>
                            </div>
                            <h4><i class="ti-link"></i> Attachment</h4>
                            <div class="fallback">
                                <input type="file" name="file" id="file">
                            </div>
                            <hr>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                                <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{asset('/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
<script>
    $('textarea').ckeditor();
    // $('.textarea').ckeditor(); // if class is prefered.
</script>
<script>
    $(function(){
        $('.btn-accept').click(function(event){
            event.preventDefault();
            $('.show-send-multiple-email').toggle("slow");
        });
    })
</script>
@endsection