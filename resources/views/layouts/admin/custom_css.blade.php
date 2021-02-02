@yield('css_link')
    <!-- Calendar CSS -->
    <link href="{{asset('/plugins/bower_components/calendar/dist/fullcalendar.css')}}" rel="stylesheet" />
<style>
        .panel-default:not(.index){
            background-color: #E6E6FA;
        }
        .panel-heading{
            background-color: red;
        }
        .jumbotron{
            background-color: white;
            height: 30em;
        }
        .col-md-2 img{
            height: 300px;
        }
        .col-md-8:not(.index){
            position: absolute;
            left: 30em;
        }
        .title{
            color: #2570BB;
            font-family: 'Roboto Condensed', Arial, sans-serif;
            text-transform: uppercase;
        }
        .title h3{
            color:#2570BB;
            font-weight: 400;
        }
        .title_class_name{
            color:cornflowerblue;
        }
        #public-methods{
            background: #E6E6FA;
        }
</style>
