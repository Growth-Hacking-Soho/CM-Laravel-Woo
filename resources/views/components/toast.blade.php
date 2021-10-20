<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
</script>
@if (session('toast'))
    <script>
        $(document).ready(function(){
            Toast.fire({
                icon: '{{ session('toast')['icon'] }}',
                title: '{{ session('toast')['title'] }}'
            })
        });
    </script>
@endif
