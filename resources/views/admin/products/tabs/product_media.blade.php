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
            dictRemoveFile: '{{trans('admin.delete')}}',
            params: {
                _token: '{{csrf_token()}}'
            },
            addRemoveLinks: true,
            removedfile: function(file){
                $.ajax({
                    dataType: 'json',
                    method: 'post',
                    url:  "{{ aurl('delete/image')}}",
                    data: {_token:'{{csrf_token()}}', id: file.fid}
                })
                var fmock;
                return (fmock = file.previewElement) != null ? fmock.parentNode.removeChild(file.previewElement) : void 0
            },
            init: function (){
               @foreach ($product->files()->get() as $file)
                    var mock = { name: '{{$file->name}}',fid: '{{$file->id }}', size: '{{$file->size}}', type: '{{$file->mime_type}}' }
                    this.emit('addedfile',mock)
                    this.options.thumbnail.call(this,mock, '{{url('storage/'.$file->full_file)}}' )
                @endforeach

                this.on('sending',function(file, xhr, formdata){
                    formdata.append('fid', '')
                    file.id =''
                })
                this.on('success', function(file, response){
                    file.fid = response.id
                })
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
