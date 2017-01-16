@extends('main')


@section('title','|Edit Blog Post')
@section('stylesheets')
    {!! Html::style('css/select2.min.css') !!}
    {!! Html::style('css/parsley.css') !!}
@endsection
@section('content')
    <div class="row">
        {!! Form::model($post,['data-parsley-validate'=>'','route' => ['posts.update',$post->id],'method'=>'PUT']) !!}
        <div class="col-md-8">
            {{ Form::label('title','Title:') }}
            {{Form::text('title',null,array('class'=>'form-control input-lg','required'=>''))}}
            {{ Form::label('slug','Slug:',['class'=>'form-spacing-top']) }}
            {{Form::text('slug',null,array('class'=>'form-control input-lg','required'=>''))}}
            {{ Form::label('category_id','Category:',['class'=>'form-spacing-top']) }}
            {{Form::select('category_id',$categories,null,array('class'=>'form-control'))}}
            {{ Form::label('tags', 'Tags:', ['class' => 'form-spacing-top']) }}
            {{ Form::select('tags[]', $tags, null, ['class' => 'form-control select2-multi', 'multiple' => 'multiple']) }}
            {{ Form::label('body','Post Body:',['class'=>'form-spacing-top']) }}
            {{Form::textarea('body',null,array('class'=>'form-control','required'=>'','maxlength'=>'255'))}}
        </div>
        <div class="col-md-4">
            <div class="well">
                <dl class="dl-horizontal">
                    <dt>Create At:</dt>
                    <dd>{{ date('M j, Y h:ia',strtotime($post->created_at))}}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Updated At:</dt>
                    <dd>{{ date('M j, Y h:ia',strtotime($post->updated_at))}}</dd>
                </dl>
                <hr>
                <div class="row">

                    <div class="col-sm-6">
                        {{Html::linkRoute('posts.show','Cancel',array($post->id),array('class'=>"btn btn-danger btn-block"))}}

                    </div>
                    <div class="col-sm-6">
                        {{Form::submit('Save changes',array('class'=>'btn btn-success btn-block'))}}


                    </div>

                </div>
            </div>


        </div>

{!! Form::close() !!}

    </div>
@endsection
@section('scripts')
    {!! Html::script('js/parsley.min.js')!!}
    {!! Html::script('js/select2.min.js') !!}
    <script type="text/javascript">
        $('.select2-multi').select2();
        $('.select2-multi').select2().val({!! json_encode($post->tags()->getRelatedIds()) !!}).trigger('change');

    </script>


@endsection