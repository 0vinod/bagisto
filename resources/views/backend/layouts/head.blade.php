<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Moonzio || DASHBOARD</title>
  
    <!-- Custom fonts for this template-->
    <link href="{{asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  
    <!-- Custom styles for this template-->
    <link href="{{asset('backend/css/sb-admin-2.min.css')}}" rel="stylesheet">
    @stack('styles')
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css"
      rel="stylesheet">

      <style>

        .rich-text-row {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    background: #fff;
}

.rich-toolbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    padding: 6px;
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.rich-toolbar .ql-toolbar {
    border: none !important;
}

.rich-toolbar .ql-formats {
    margin-right: 8px !important;
}

.rich-toolbar button {
    cursor: pointer;
}

.quill-editor {
    min-height: 100px;
}

.quill-editor .ql-editor {
    min-height: 100px;
    font-size: 15px;
}

.quill-editor .ql-editor p {
    margin-bottom: 5px;
}

.rich-text-row .ql-container {
    border: none !important;
    font-family: inherit;
}

.rich-text-row .ql-editor {
    padding: 12px;
}
      </style>
</head>