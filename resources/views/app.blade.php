<!DOCTYPE html>
<html>

@include('sections.head')

<body class="hold-transition sidebar-mini">
  <div class="wrapper" id="app">
    <app ruta="{{route('basepath')}}"></app>
  </div>
  @include('sections.script')
</body>

</html>