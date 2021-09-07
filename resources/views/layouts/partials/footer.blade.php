<footer class="main-footer">
  <strong>Copyright &copy; {{$date->year}} <a href="@if(isset($platform->website)) http://{{$platform->website}} @else # @endif" target="_blank">@if(isset($platform->name)) {{$platform->name}} @else Company Name @endif</a>,</strong>
   All rights reserved.
</footer>