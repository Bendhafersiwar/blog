@extends('main')


@section('title','|Show Post')
@section('content')
    <div class="row">
        <div class="col-md-8">

        <h1>{{ $post->title }}</h1>
    <p class="lead">
        {{ $post->body }}
    </p>
            <hr>

            <div class="tags">
                @foreach ($post->tags as $tag)
                    <span class="label label-default">{{ $tag->name }}</span>
                @endforeach
            </div>
    </div>
        <div class="col-md-4">
            <div class="well">
                <dl class="dl-horizontal">
                    <label>URL Slug:</label>
                    <a href="{{ route('blog.single',$post->slug)}}">{{ route('blog.single',$post->slug)}}</a>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Category: </dt>
                    <dd>{{$post->category->name}}</dd>
                </dl>
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
                        {{Html::linkRoute('posts.edit','Edit',array($post->id),array('class'=>"btn btn-primary btn-block"))}}

                    </div>
                    <div class="col-sm-6">
                        {!! Form::open(['route' => ['posts.destroy',$post->id],'method'=>'DELETE']) !!}
                        {{Form::submit('Delete',array('class'=>'btn btn-danger btn-block'))}}
                        {!! Form::close()!!}
</div>

</div>
                <div class="row">
                    {{Html::linkRoute('posts.index','<< See All Posts',[],array('class'=>"btn btn-default btn-block btn-h1-spacing"))}}

                </div>
</div>


</div>



</div>
@endsection