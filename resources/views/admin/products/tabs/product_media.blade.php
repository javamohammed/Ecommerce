@push('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script type="text/javascript">
    Dropzone.autoDiscover = false
    $(document).ready( function(){
        $('#dropzonefileupload').dropzone({
            url: " {{ aurl('upload/image/'.$product->id) }}",
            paraName: 'files[]',
            uploadMultiple:true,
            maxFiles: 15,
            maxFilessiz: 2,//MB
            acceptedFiles: 'image/*',
            dictDefaultMessage: 'إضغط هنا لرفع الملفات أو قم بسحب الملفات وإطلاقها هنا',
            params: {
                _token: '{{csrf_token()}}'
            }
        })
    })

    </script>
@endpush
    <div id="product_media" class="tab-pane fade">
      <h3>{{trans('admin.product_media')}}

    </h3>
      <div class="dropzone" id="dropzonefileupload">

      </div>
    </div>
