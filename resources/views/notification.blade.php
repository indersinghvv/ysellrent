<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


<script>
        @if(Session::has('message'))
          var type = "{{ Session::get('alert-type', 'info') }}";
          toastr.options.closeButton = true;
          toastr.options.preventDuplicates = true;
          toastr.options.hideMethod = 'slideUp';
          toastr.options.newestOnTop = true;
          toastr.options.progressBar = true;
          toastr.options.positionClass = 'toast-top-full-width';
          
          switch(type){
              case 'info':
                  toastr.info("{{ Session::get('message') }}");
                  break;
              
              case 'warning':
                  toastr.warning("{{ Session::get('message') }}");
                  break;
      
              case 'success':
                  toastr.success("{{ Session::get('message') }}");
                  break;
      
              case 'error':
                  toastr.error("{{ Session::get('message') }}");
                  break;
          }
        @endif
      </script>