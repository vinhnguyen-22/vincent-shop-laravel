<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Images server</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.18.0/ckeditor.js" integrity="sha512-woYV6V3QV/oH8txWu19WqPPEtGu+dXM87N9YXP6ocsbCAH1Au9WDZ15cnk62n6/tVOmOo0rIYwx05raKdA4qyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var funcNum = @php echo $_GET["CKEditorFuncNum"].';'; @endphp
            $('#fileExplorer').on('click','img',function (){
                var fileUrl = $(this).attr('title');
                window.opener.CKEDITOR.tools.callFunction(funcNum,fileUrl);
                window.close();
            }).hover(function(){
                $(this).css('cursor', 'pointer');
            });
        });
    </script>
    <style type="text/css">
        ul.file-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul.file-list li {
            float: left;
            margin: 5px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        ul.file-list li:hover {
            cursor: pointer;
            background:cornsilk;
        }
    </style>
</head>
<body>
    <div id="fileExplorer">
        @foreach($fileNames as $file)
            <div class="thumbnail">
                <ul class="file-list">
                    <li><img src="{{asset('/public/uploads/ckeditor/'.$file)}}" alt="thumb" with="120" height="120" title="{{asset('/public/uploads/ckeditor/'.$file)}}">
                     <br>
                    <span style="color:blue">{{$file}}</span></li>
                   
                </ul>    
            </div>
        @endforeach
    </div>
</body>
</html>