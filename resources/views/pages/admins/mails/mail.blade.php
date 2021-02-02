<p>Thank you for contact</p>
    <p>Content: {{$e_message}}</p>
    <p>File: </p>
    <iframe src="{{$message->embedData(asset('/public/files/C1_Intro.pdf'),'NAME')}}" frameborder="0" width=”100%” height=”100%”></iframe>
    <embed src="{{$message->embedData(public_path("files/C1_Intro.pdf"),'yeah')}}" type="application/pdf" width="100%" height="600px" >
    <embed src="{{$message->embedData(asset('/files/C1_Intro.pdf'),'PDF')}}" type="application/pdf" width="100%" height="600px" >
