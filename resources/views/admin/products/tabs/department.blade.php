@push('js')


<script type="text/javascript">
$(document).ready(function(){

  $('#jstree').jstree({
    "core" : {
      'data' : {!! load_dep($product->department_id) !!},
      "themes" : {
        "variant" : "large"
      }
    },
    "checkbox" : {
      "keep_selected_style" : true
    },
    "plugins" : [ "wholerow" ]//checkbox
  });

});

 $('#jstree').on('changed.jstree',function(e,data){
    var i , j , r = [];
    var  name = [];
    for(i=0,j = data.selected.length;i < j;i++)
    {
        r.push(data.instance.get_node(data.selected[i]).id);
    }
    var department = r.join(', ')
    $('.department_id').val(department);

    $.ajax({
        url: "{{ aurl('load/weight/size') }}",
        dataType: 'html',
        type: 'post',
        data: {_token:'{{ csrf_token() }}', dep_id:department},
        success: function(data){
            $('.size_weight').html(data)
            $('.other_data').removeClass('hidden')
        }
    })
});

</script>
@endpush


<div id="department" class="tab-pane fade">
    <h3>{{trans('admin.department')}}</h3>
    <div id="jstree"></div>
    <input type="hidden" name="department_id" class="department_id" />
</div>
