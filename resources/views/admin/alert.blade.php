@if (Session::has('error'))
    <script>
        $(document).ready(function() {
            toastr.options = {
                "progressBar": true,
                "closeButton": true,
                "positionClass": "toast-top-right",
            }
            toastr.error(`{{ Session::get('error') }}`, {timeOut: 4000});
        });
    </script>
@endif

@if(Session::has('success'))
    <script>
        $(document).ready(function() {
            // showToast('{{ Session::get('success') }}')
            // var toast = `
            // <div id="toast-container" class="toast-top-right" style="display: none">
            //     <div class="toast toast-success" aria-live="polite">
            //         <div class="toast-message">{{ Session::get('success') }}</div>
            //     </div>
            // </div>
            // `;
            // $('body').append(toast);
            // $('#toast-container').fadeIn(500).delay(3000).fadeOut(500, function() {
            //     $(this).remove();
            // });
            
            toastr.options = {
                "progressBar": true,
                "closeButton": true,
                "positionClass": "toast-top-right",
            }
            toastr.success(`{{ Session::get('success') }}`, {timeOut: 3000});
        });
    </script>
@endif

