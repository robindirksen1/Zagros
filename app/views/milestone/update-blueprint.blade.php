@extends('layouts.milestone.main')

@section('title')
    {{trans('layout.zagros')}}::{{$milestone->codename}}
@stop

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">{{trans('layout.update_blueprint')}}</h2>
        @if (Session::has('message'))
            <p class="text-info text-center">{{Session::get('message')}}</p>
        @endif
        {{Form::open(array('action' => array('MilestoneController@postCreateBlueprint', $project->url, $milestone->url), 'class' => 'form-horizontal', 'role' => 'form'))}}
            <div class="form-group">
                {{Form::label('title', trans('layout.title'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::text('title', $blueprint->title, array('class' => 'form-control', 'placeholder' => trans('layout.title'), 'id' => 'title'))}}
                    {{$errors->first('title', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('status', trans('layout.status'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::select('status', Helper::getBlueprintStatus(), $blueprint->status, array('class' => 'form-control'))}}
                    {{$errors->first('status', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('importance', trans('layout.importance'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::select('importance', Helper::getBlueprintImportance(), $blueprint->importance, array('class' => 'form-control'))}}
                    {{$errors->first('importance', '<small class="text-warning">:message</small><br>')}}
                </div>
            </div>
            <div class="form-group">
                {{Form::label('desc', trans('layout.desc'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    {{Form::textarea('description', $blueprint->description, array('class' => 'form-control', 'placeholder' => trans('layout.desc'), 'id' => 'desc'))}}
                    {{$errors->first('description', '<small class="text-warning">:message</small>')}}
                </div>
            </div>
            <hr>
            <div class="form-group">
                {{Form::label('assign', trans('layout.assign'), array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-10">
                    <input type="text" name="user_id_assigned" id="assign" class="form-control" placeholder="{{trans('layout.assign')}}">
                    {{$errors->first('user_id_assigned', '<small class="text-warning">:message</small><br>')}}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10 text-center">
                    {{Form::hidden('update', 'true')}}
                    {{Form::hidden('blueprint_id', $blueprint->blueprint_id)}}
                    {{Form::submit(trans('layout.update'), array('class' => 'btn btn-primary'))}}
                    <a href="{{URL::action('MilestoneController@getDeleteBlueprint', array($project->url, $milestone->url, $blueprint->blueprint_id))}}?_token={{csrf_token()}}" class="btn btn-danger"
                        onclick="if(!confirm('{{trans('messages.delete')}}')) return event.preventDefault();">{{trans('layout.delete_blueprint')}}</a>
                </div>
            </div>
        {{Form::close()}}
    </div>
@stop

@section('footer')
    <script>
        $(function() {
            var admins = $('#assign').magicSuggest({
                data: '{{URL::action('MilestoneController@postUsers', array($project->url, $milestone->url))}}',
                @if (isset($blueprint->user_assigned->user_id))
                    value: [{user_id: "{{$blueprint->user_assigned->user_id}}", name: "{{$blueprint->user_assigned->name}}"}],
                @endif
                valueField: 'user_id',
                displayField: 'name',
                mode: 'remote',
                allowFreeEntries: false,
                maxSelection: 1,
                renderer: function(data){
                    return '<div class="users">' +
                            '<div class="name">' + data.name + '</div>' +
                           '</div>';
                },
                resultAsString: true,
                selectionRenderer: function(data){
                    return '<div class="name">' + data.name + '</div>';
                }
            });
        });
    </script>
@stop
