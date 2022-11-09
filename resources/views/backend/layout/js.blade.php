<!-- Bootstrap core JavaScript-->
    <script src="{{url('public/backend')}}/vendor/jquery/jquery.min.js"></script>
    <script src="{{url('public/backend')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{url('public/backend')}}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{url('public/backend')}}/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="{{url('public/backend')}}/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{url('public/backend')}}/js/demo/chart-area-demo.js"></script>
    <script src="{{url('public/backend')}}/js/demo/chart-pie-demo.js"></script>
    <script src="{{url('public/backend')}}/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>   
    <script type="text/javascript" src="{{url('public/backend')}}/js/slug.js"></script>
    {{-- Nhúng ck-editor --}}
    <script type="text/javascript" src="{{url('public/backend')}}/ckeditor/ckeditor.js"></script>
    <script>
    CKEDITOR.replace( 'editor-ckeditor' ,{
        filebrowserBrowseUrl : '{{url('filemanager')}}/dialog.php?type=2&editor=ckeditor&fldr=',
        filebrowserUploadUrl : '{{url('filemanager')}}/dialog.php?type=2&editor=ckeditor&fldr=',
        filebrowserImageBrowseUrl : '{{url('filemanager')}}/dialog.php?type=1&editor=ckeditor&fldr='
    });
    CKEDITOR.replace('editor');
    </script>

</script>
    </script>
    {{-- Sự kiện Modal ảnh --}}
    <script src="{{url('public/backend')}}/js/modal.js"></script>
    {{-- Nhúng select-2 --}}
    <script src="{{url('public/backend')}}/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select-2').select2();
        });
    </script>   
    <script>
        const story = document.getElementById("story");
        story.onchange = () => {
            document.getElementById("banner_name").value=story.options[story.selectedIndex].text
        }
    </script>

    <script>
        const a = document.querySelectorAll('.name_story');
        // console.log(a[1].innerText.length)
        a.forEach((value) => {
            if(value.innerHTML.length>28){
                value.innerHTML = value.innerHTML.slice(0,28)+'...'
            }
        })
    </script>
