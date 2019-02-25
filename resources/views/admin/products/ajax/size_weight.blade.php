<div class="col-md-6">
    <div class="from-group">
        <label for="sizes" class="col-md-3">{{ trans('admin.size_id')}}</label>
        <div class="col-md-9">
            {!! Form::select('size_id',$sizes,'',['class'=>'form-control', 'placeholder' =>trans('admin.size_id') ]) !!}
        </div>
    </div>

    <div class="from-group">
        <label for="sizes" class="col-md-3">{{ trans('admin.size')}}</label>
        <div class="col-md-9">
            {!! Form::text('size','',['class'=>'form-control', 'placeholder' =>trans('admin.size') ]) !!}
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="from-group">
        <label for="weights" class="col-md-3">{{ trans('admin.weight_id')}}</label>
        <div class="col-md-9">
            {!! Form::select('weight_id',$weights,'',['class'=>'form-control', 'placeholder' =>trans('admin.weight_id') ]) !!}
        </div>
    </div>

    <div class="from-group">
        <label for="weights" class="col-md-3">{{ trans('admin.weight')}}</label>
        <div class="col-md-9">
            {!! Form::text('weight','',['class'=>'form-control', 'placeholder' =>trans('admin.weight') ]) !!}
        </div>
    </div>

</div>

<div class="clearfix"></div>
